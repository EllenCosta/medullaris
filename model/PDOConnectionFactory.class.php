<?php

class PDOConnectionFactory{	

	public static $instance;
	
	public $con = null;	
	public $dbType 	= "mysql";
 	
	//public $host 	= $_SESSION['host'];
	public $host 	= "admed.cqxuennp4oyg.sa-east-1.rds.amazonaws.com"; // são paulo
	//public $host 	= "admed.cvbvstuzzoms.us-east-1.rds.amazonaws.com"; //virginia
	//public $host ="localhost";
	public $user = "root";
	//public $senha = "vertrigo";
	public $dbname = "medullaris";
	public $senha = "dmed246dmed";
 
	public $persistent = true;
 	
	/*public function PDOConnectionFactory( $persistent=false ){
		session_start();
		if( $persistent != false){
			$this->persistent = true;
		}
	}*/
 
	public function getConnection(){
			try{
				///sincronizar data e hora php e mysql ////////
				date_default_timezone_set('America/Sao_Paulo');				
				$now = new DateTime();
				$mins = $now->getOffset() / 60;
				$sgn = ($mins < 0 ? -1 : 1);
				$mins = abs($mins);
				$hrs = floor($mins / 60);
				$mins -= $hrs * 60;
				$offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);				
				//////////////////////
				if($this->con == null){
					$this->con = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname, $this->user, $this->senha, 				
					array( PDO::ATTR_PERSISTENT => $this->persistent, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES latin1' ) );
					//$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->con->exec("SET time_zone='$offset';");
				}
				return $this->con;					
			}catch ( PDOException $ex ){ 
				echo "Erro na conexao com o banco de dados : <br>".$ex->getMessage();
			}
	}

	public function Close(){
		
		if( $this->con != null ){
			$this->con = null;	//se a conexão é persistente teoricamente não preciso de fechar a conexao		
		}
	}
 
}
?>