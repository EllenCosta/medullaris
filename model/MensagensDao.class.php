<?php

class MensagensDao extends PDOConnectionFactory {
	
	public $conex = null;
	
	public function MensagensDao(){
		//$this->conex = PDOConnectionFactory::getConnection();		
	}	
	
	public function inserir( $mensagens ){
		$this->conex = PDOConnectionFactory::getConnection();
		try{			
			$stmt = $this->conex->prepare("insert into mensagens (id_de, id_para, data, mensagem, lido) VALUES(?,?,NOW(),?,'0')");			
			$stmt->bindValue(1, $mensagens->getIdDe() );
			$stmt->bindValue(2, $mensagens->getIdPara() );
			$stmt->bindValue(3, $mensagens->getMensagens() );			
			$stmt->execute();
			$this->conex = PDOConnectionFactory::Close();
		}catch ( PDOException $ex ){  
			echo "Erro: ".$ex->getMessage(); 
		}
	}
	
	public function listar($query = null){
		$this->conex = PDOConnectionFactory::getConnection();
		try{
			if( $query == null ){				
				$stmt = $this->conex->query("select * from mensagens order by id_mensagens");
			}else{
				$stmt = $this->conex->query($query);
			}
			$this->conex = PDOConnectionFactory::Close();
			return $stmt;
		}catch ( PDOException $ex ){  
			//echo "Erro: ".$ex->getMessage(); 
		}
	}
}
?>