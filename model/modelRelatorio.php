<?php

#inclui arquivo da classe de conexão
include_once '../../model/PDOConnectionFactory.class.php';

class modelRelatorio extends PDOConnectionFactory {
    
   public $conex = null;

    #atributos
    private $id;
    private $nome;
    private $cpf;
    private $dor;
    private $data;
    private $tel;
    private $consulta;


    #métodos gets e sets
    public function getId() {return $this->id;}
    public function getNome() {return $this->nome;}
    public function getCpf() {return $this->cpf;}
    public function getDor() {return $this->dor;}
    public function getData() {return $this->data;}
    public function getTel() {return $this->tel;}
    public function getConsulta() {return $this->consulta;}
   

    public function setId($id) {$this->id = $id;}
    public function setNome($nome) {$this->nome = $nome;}
    public function setCpf($cpf) {$this->cpf = $cpf;}
    public function setDor($dor) {$this->dor = $dor;}
    public function setData($data) {$this->data = $data;}
    public function setTel($tel) {$this->tel = $tel;}
    public function setConsulta($consulta) {$this->consulta = $consulta;}


    
    public function buscar($cpf) {
        $this->conex = PDOConnectionFactory::getConnection();
        #setar os valores
        $this->setCpf($cpf);

        try{
                     
                $stmt = $this->conex->prepare("select * from paciente where cpf = ?");
                $stmt->bindValue(1,$this->getCpf());
                $stmt->execute();

                if ($stmt->rowCount() != 0){
                    while($nome = $stmt->fetch(PDO::FETCH_ASSOC)){

                        $return = $nome['nome'];
                    }

                     $this->conex = PDOConnectionFactory::Close();
                     return $return;
                }else{
                    
                     $return = null;
                     $this->conex = PDOConnectionFactory::Close();
                     return $return;
                }

            
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }

    }
 
    public function listar($id, $nome, $cpf, $sql) {

        $this->conex = PDOConnectionFactory::getConnection();
        $this->setNome($nome);
        $this->setCpf($cpf);
        $this->setId($id);
        $this->setConsulta($sql);

        try {

            if($this->getId() != ""){
                $con="select * from paciente,dados where paciente.id_paciente=dados.id_Paci and paciente.id_paciente = ".$this->getId()." order by data desc ".$this->getConsulta();
                $stmt = $this->conex->query($con);
                $stmt->execute();

                return $stmt;        

                $this->conex = PDOConnectionFactory::Close();
            }
            else{



                $con = "select * from paciente,dados where paciente.id_paciente=dados.id_Paci ";

                if($this->getNome() != ""){// tem nome

                    $con = $con."and paciente.nome like '%".$this->getNome()."%' ";
                }  
                if($this->getcpf() != ""){// tem cpf
                    $con = $con."and paciente.cpf like '%".$this->getCpf()."%' ";
                }

                $con = $con."and dados.id_dados in (select max(id_dados) from dados group by id_Paci) order by nome ".$this->getConsulta();
               
                $stmt = $this->conex->query($con);
                $stmt->execute();

                $this->conex = PDOConnectionFactory::Close();        
                return $stmt;


              
            }

            
        } catch (PDOException $ex) {
            //echo "Erro: ".$ex->getMessage(); 
        }


    }

    public function contar($nome, $cpf){

       $this->conex = PDOConnectionFactory::getConnection();
      
        try{  
                $sql = "select * from paciente,dados where paciente.id_paciente=dados.id_Paci ";

                if($nome != ""){
                    $sql = $sql."and paciente.nome like '%".$nome."%' ";
                }

                if($cpf != ""){
                     $sql = $sql."and paciente.cpf like '%".$this->getCpf()."%' ";
                }

                $sql = $sql."and dados.id_dados in (select max(id_dados) from dados group by id_Paci)";

                $count = 0;
                $stmt = $this->conex->query($sql);
                
                foreach($stmt as $usuario){
                    $count ++;
                }
                $this->conex = PDOConnectionFactory::Close();
                return $count;
        
            
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }
    }

    public function conte($sql){

       $this->conex = PDOConnectionFactory::getConnection();
      
        try{  
                
                $count = 0;
                $stmt = $this->conex->query($sql);
                
                foreach($stmt as $usuario){
                    $count ++;
                }
                $this->conex = PDOConnectionFactory::Close();
                return $count;
        
            
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }
    }
}
