<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/medullaris/model/PDOConnectionFactory.class.php");
#inclui arquivo da classe de conexão
include_once '../../model/PDOConnectionFactory.class.php';

class modelGrupoUsuario extends PDOConnectionFactory {
    
    public $conex = null;

    private $id_grupo;
    private $descricao;
   

    public function getId() {return $this->id_grupo;}
    public function getDescricao() {return $this->descricao;}
   
    public function setId($id_grupo) {$this->id_grupo = $id_grupo;}
    public function setDescricao($descricao) {$this->descricao = $descricao;}
  


    public function listar($query = null){
        $this->conex = PDOConnectionFactory::getConnection();
        try{
            if( $query == null ){               
                $stmt = $this->conex->query("select * from grupo order by id_grupo");
            }else{
                $stmt = $this->conex->query($query);
            }
            $this->conex = PDOConnectionFactory::Close();
            return $stmt;
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }
    }


    public function inserir($descricao){
        $this->conex = PDOConnectionFactory::getConnection();
        $this->setDescricao($descricao);
        $data = date('Y-m-d H:i');


        try{
                         
                $stmt = $this->conex->prepare("insert into grupo (id_grupo, descricao, usu_atu, data_cad) values (?,?,?,?)");
                $stmt->bindValue(1,"");
                $stmt->bindValue(2,$this->getDescricao());
                $stmt->bindValue(3,"");
                $stmt->bindValue(4,$data);
                $stmt->execute();

                return 1;
           
                $this->conex = PDOConnectionFactory::Close();
 
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }
    }
     

    public function alterar($id_grupo, $descricao){

        $this->conex = PDOConnectionFactory::getConnection();

        $this->setId($id_grupo);
        $this->setDescricao($descricao);

        try{
                

                $stmt = $this->conex->prepare("update grupo set descricao = ? where id_grupo = ?");
                $stmt->bindValue(1,$this->getDescricao());
                $stmt->bindValue(2,$this->getId());
                $stmt->execute();
                
                return 1;
           
                $this->conex = PDOConnectionFactory::Close();
 
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }
    }


    public function excluir($id_grupo){

        $this->conex = PDOConnectionFactory::getConnection();

        $this->setId($id_grupo);
    

        try{
                
                $stmt = $this->conex->prepare("delete from grupo where id_grupo = ?");
                $stmt->bindValue(1,$this->getId());
                $stmt->execute();

                return 1;
           
                $this->conex = PDOConnectionFactory::Close();
 
        }catch ( PDOException $ex ){  
            echo "Erro: ".$ex->getMessage(); 
        }
    }

    public function contar( $query = null){
        $this->conex = PDOConnectionFactory::getConnection();
        try{            
            $count = 0;
            if( $query == null ){
                $stmt = $this->conex->query("select * from grupo");
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
