<?php

#inclui arquivo da classe de conexão
include_once 'PDOConnectionFactory.class.php';

class modelUsuario extends PDOConnectionFactory {
    
    public $conex = null;

    #atributos
    private $id;
    private $nome;
    private $login;
    private $pass;
    private $status;
    private $id_grupo;
    private $master;
    private $generico;


    #métodos gets e sets
    public function getId() {return $this->id;}
    public function getNome() {return $this->nome;}
    public function getLogin() {return $this->login;}
    public function getPass() {return $this->pass;}
    public function getStatus() {return $this->status;}
    public function getId_Grupo() {return $this->id_grupo;}
    public function getMaster() {return $this->master;}
    public function getGenerico() {return $this->generico;}
   
    public function setId($id) {$this->id = $id;}
    public function setNome($nome) {$this->nome = $nome;}
    public function setLogin($login) {$this->login = $login;}
    public function setPass($pass) {$this->pass = $pass;}
    public function setStatus($status) {$this->status = $status;}
    public function setId_Grupo($id_grupo) {$this->id_grupo = $id_grupo;}
    public function setMaster($master) {$this->master = $master;}
    public function setGenerico($generico) {$this->generico = $generico;}

   
    public function inserir($login,$pass,$nome,$status,$id_grupo,$master,$generico) {

        $this->conex = PDOConnectionFactory::getConnection();

        
        $this->setNome($nome);
        $this->setLogin($login);
        $this->setPass($pass);
        $this->setStatus($status);
        $this->setId_Grupo($id_grupo);
        $this->setMaster($master);
        $this->setGenerico($generico);
        $this->setId(null);

        try{


                $stmt = $this->conex->prepare("insert into usuario (id_usuario, login, senha, nome, status, id_grupo, master, usu_atu, data_cad, horario, limite, generico, altera_senha, chat_ativo) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bindValue(1," ");
                $stmt->bindValue(2,$this->getLogin());
                $stmt->bindValue(3,$this->getPass());
                $stmt->bindValue(4,$this->getNome());
                $stmt->bindValue(5,$this->getStatus());
                $stmt->bindValue(6,$this->getId_Grupo());
                $stmt->bindValue(7,$this->getMaster());
                $stmt->bindValue(8," ");//usu_atu
                $stmt->bindValue(9," ");//data_cad
                $stmt->bindValue(10," ");//horario
                $stmt->bindValue(11," ");//limite
                $stmt->bindValue(12,$this->getGenerico());
                $stmt->bindValue(13," ");
                $stmt->bindValue(14," ");
                $stmt->execute();

                return 1;

                $this->conex = PDOConnectionFactory::Close();

        }catch ( PDOException $ex ){  
            echo "Erro: ".$ex->getMessage(); 
        }
    
    }

    public function alterar($id_usuario, $login, $pass, $nome, $status, $id_grupo, $master, $generico){

        $this->setId($id_usuario);
        $this->setNome($nome);
        $this->setLogin($login);
        $this->setPass($pass);
        $this->setStatus($status);
        $this->setId_Grupo($id_grupo);
        $this->setMaster($master);
        $this->setGenerico($generico);

        $this->conex = PDOConnectionFactory::getConnection();
        if($this->getPass() != ""){ // verificar se senha é vazia ai altera senão permanece a mesma // tirar o master
            try{
                $stmt = $this->conex->prepare("update usuario set login= ?, nome = ?, status=?, id_grupo=?, master = ?, generico = ?, senha=? where id_usuario = ?");
                $this->conex->beginTransaction();
                
                $stmt->bindValue(1, $this->getLogin() );         
                $stmt->bindValue(2, $this->getNome() );
                $stmt->bindValue(3, $this->getStatus() );
                $stmt->bindValue(4, $this->getId_Grupo() );
                $stmt->bindValue(5, $this->getMaster() );
                $stmt->bindValue(6, $this->getGenerico() );
                $stmt->bindValue(7, $this->getPass() );
                $stmt->bindValue(8, $this->getId() );

                
                $stmt->execute();
     
                $this->conex->commit();
                
                $this->conex = PDOConnectionFactory::Close();

                return 1;
            
            }catch ( PDOException $ex ){  
                echo "Erro: ".$ex->getMessage(); 
            }
        }else{
            try{
                $stmt = $this->conex->prepare("update usuario set login= ?, nome = ?, status=?, id_grupo=?, master = ?, generico = ? where id_usuario = ?");
                $this->conex->beginTransaction();
                
                $stmt->bindValue(1, $this->getLogin() );         
                $stmt->bindValue(2, $this->getNome() );
                $stmt->bindValue(3, $this->getStatus() );
                $stmt->bindValue(4, $this->getId_Grupo() );
                $stmt->bindValue(5, $this->getMaster() );
                $stmt->bindValue(6, $this->getGenerico() );
                $stmt->bindValue(7, $this->getId() );
                $stmt->execute();
     
                $this->conex->commit();
                
                $this->conex = PDOConnectionFactory::Close();

                return 1;
            
            }catch ( PDOException $ex ){  
                echo "Erro: ".$ex->getMessage(); 
            }

        }
    }

    #metodo para alterar um paciente    
    public function logar($login,$pass) {

        $this->conex = PDOConnectionFactory::getConnection();
        
        $this->setLogin($login);
        $this->setPass($pass);

        try{
                     
                $stmt = $this->conex->prepare("select * from usuario where login = ?");
                $stmt->bindValue(1,$this->getLogin());
                $stmt->execute();

                
                if($stmt->rowCount() != 0){

                    while($dados = $stmt->fetch(PDO::FETCH_ASSOC)){

                        $senhaUser = $dados['senha'];
                    }
                    if($senhaUser == $this->getPass()){

                        $stmt = $this->conex->prepare("update usuario set ativo = ? where login = ?");
                        $stmt->bindValue(1,1);
                        $stmt->bindValue(2,$this->getlogin());
                        $stmt->execute();

                        $return =1;
                        $this->conex = PDOConnectionFactory::Close();
                        return $return;
                    }
                    else{

                        $return = "Senha Incorreta!";
                        $this->conex = PDOConnectionFactory::Close();
                        return $return;
                    } 
                }
                else{

                     $return = "Usuario não encontrado";
                     $this->conex = PDOConnectionFactory::Close();
                     return $return;
                }
                       

            
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }

    }

    public function excluir($id_usuario) {

        $this->conex = PDOConnectionFactory::getConnection();

        $this->setId($id_usuario);

        try{
                     
                $stmt = $this->conex->prepare("delete from usuario where id_usuario = ?");
                $stmt->bindValue(1, $this->getId() );
                $stmt->execute();
                return 1;
                $this->conex = PDOConnectionFactory::Close();
            
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }

    }

    public function listar($sql) {

        $this->conex = PDOConnectionFactory::getConnection();
        //$this->setId($id);

        try{
                     
                $stmt = $this->conex->prepare($sql);
                $stmt->execute();
                return $stmt;
                $this->conex = PDOConnectionFactory::Close();
            
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }

    }

    public function busca($sql) {

        $this->conex = PDOConnectionFactory::getConnection();
        //$this->setId($id);

        try{
                     
                $stmt = $this->conex->query("select * from empresa");
                $stmt->execute();
                return $stmt;
                $this->conex = PDOConnectionFactory::Close();
            
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }

    }

    public function contar( $query = null){
        $this->conex = PDOConnectionFactory::getConnection();
        try{            
            $count = 0;
            if( $query == null ){
                $stmt = $this->conex->query("select * from usuario");
            }else{
                $stmt = $this->conex->query($query);                
            }           
            foreach($stmt as $usuario){
                $count ++;
            }
            $this->conex = PDOConnectionFactory::Close();
            return $count;
        }catch ( PDOException $ex ){  
            echo "Erro: ".$ex->getMessage(); 
        }
    }

}
