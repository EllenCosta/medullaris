<?php

#inclui arquivo da classe de conexão
include_once '../../model/PDOConnectionFactory.class.php';

class modelPaciente extends PDOConnectionFactory {
    
    public $conex = null;

    #atributos
    private $id;
    private $nome;
    private $cpf;
    private $dor;
    private $data;
    private $tel;
    private $status;
  


    #métodos gets e sets
    public function getId() {return $this->id;}
    public function getNome() {return $this->nome;}
    public function getCpf() {return $this->cpf;}
    public function getDor() {return $this->dor;}
    public function getData() {return $this->data;}
    public function getTel() {return $this->tel;}
    public function getStatus() {return $this->status;}

    public function setId($id) {$this->id = $id;}
    public function setNome($nome) {$this->nome = $nome;}
    public function setCpf($cpf) {$this->cpf = $cpf;}
    public function setDor($dor) {$this->dor = $dor;}
    public function setData($data) {$this->data = $data;}
    public function setTel($tel) {$this->tel = $tel;}
    public function setStatus($status) {$this->status = $status;}

    
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

    public function inserir($nome, $cpf, $tel) {

        $this->conex = PDOConnectionFactory::getConnection();

        #setar os dados
        $this->setNome($nome);
        $this->setCpf($cpf);
        $this->setTel($tel);

        try{

            $stmt = $this->conex->prepare("select * from paciente where cpf = ?");
            $stmt->bindValue(1,$this->getCpf());
            $stmt->execute();

            if ($stmt->rowCount() == 0){

                $stmt = $this->conex->prepare("insert into paciente (id_paciente, cpf, nome, telefone, status) values (?, ?, ?, ?, ?)");
                $stmt->bindValue(1,null);
                $stmt->bindValue(2,$this->getCpf());
                $stmt->bindValue(3,$this->getNome());
                $stmt->bindValue(4,$this->getTel());
                $stmt->bindValue(5,"A");
                $stmt->execute();
                
                $stmt = $this->conex->prepare("select last_insert_id(id_paciente) as ultimo from paciente order by id_paciente desc limit 0, 1");
                $stmt->execute();
                $num;
                while($nome = $stmt->fetch(PDO::FETCH_ASSOC)){

                        $num = $nome['ultimo'];
                }

                return $num;

            }else{

                return 0;

            }
            $this->conex = PDOConnectionFactory::Close();

        }catch ( PDOException $ex ){  
            echo "Erro: ".$ex->getMessage(); 
        }
    
    }
    
    public function listar($id,$nome,$cpf,$status,$sqlp) {

        $this->conex = PDOConnectionFactory::getConnection();
        $this->setNome($nome);
        $this->setCpf($cpf);
        $this->setStatus($status);
        $this->setId($id);

        try{

                if($this->getId() != ""){
                    $sql="select * from paciente where paciente.id_paciente= ".$this->getId();
                   // $sql="select * from paciente INNER JOIN dados on paciente.id = ".$this->getId()." and dados.id_Paci =".$this->getId();
                    $stmt = $this->conex->query($sql);
                    $stmt->execute();

                }
                else{
                
                    $sql="select * from paciente where 1 ";

                    if($this->getNome() != ""){

                        $sql = $sql."and nome like '%".$this->getNome()."%' ";
                    }

                    if($this->getCpf() != ""){
                        $sql = $sql."and cpf like '%".$this->getCpf()."%' ";
                    }

                    if($this->getStatus() != ""){
                        $sql = $sql."and status like '%".$this->getStatus()."%' ";
                    }
                          

                    $sql= $sql.$sqlp;
                 
                    $stmt = $this->conex->query($sql);
                    $stmt->execute();

                }

             return $stmt;       
                
            $this->conex = PDOConnectionFactory::Close();
            
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }

    }


    public function alterar($id, $nome, $cpf, $tel,$status){

        $this->setId($id);
        $this->setNome($nome);
        $this->setCpf($cpf);
        $this->setTel($tel);
        $this->setStatus($status);
        $identificador;
        $name;

        $this->conex = PDOConnectionFactory::getConnection();

         try{

                $stmt = $this->conex->prepare("select * from paciente where cpf = ?");
                $stmt->bindValue(1,$this->getCpf());
                $stmt->execute();

                if ($stmt->rowCount() == 0){//não existe este cpf cadastrado

                    $stmt = $this->conex->prepare("update paciente set cpf = ?, nome = ?, telefone = ? where id_paciente = ?");
                    $stmt->bindValue(1,$this->getCpf());
                    $stmt->bindValue(2,$this->getNome());
                    $stmt->bindValue(3,$this->getTel());
                    $stmt->bindValue(4,$this->getId());
                    $stmt->execute();
                    return 0;

                }else{//existe pelo menos 1 com o esse cpf

                    while($linha = $stmt->fetch(PDO::FETCH_ASSOC)){

                            $identificador = $linha['id_paciente'];
                            $name = $linha['nome'];
                    }

                    if($this->getId() == $identificador){// verifica se o cpf a alterar é o mesmo encontrado

                        $stmt = $this->conex->prepare("update paciente set cpf = ?, nome = ?, telefone = ?, status = ? where id_paciente = ?");
                        $stmt->bindValue(1,$this->getCpf());
                        $stmt->bindValue(2,$this->getNome());
                        $stmt->bindValue(3,$this->getTel());
                        $stmt->bindValue(4,$this->getStatus());
                        $stmt->bindValue(5,$this->getId());
                        $stmt->execute();
                        return 0;

                        
                    }else{
                        //return "Este cpf já esta cadastrado com o nome: '".$name."'";
                        return utf8_encode($name);
                    }


                }

                


                //$sql = "update paciente set cpf = '".$this->getCpf()."', nome = '".$this->getNome()."'?, telefone = '".$this->getTel()."' where id = '".$this->getId();
                

               

        }catch ( PDOException $ex ){  
            echo "Erro: ".$ex->getMessage(); 
        }
         $this->conex = PDOConnectionFactory::Close();

    }

     public function excluir($id){

         $this->conex = PDOConnectionFactory::getConnection();
         $this->setId($id);

            $array;
            $dataI;
            $dataF;

         try{
           

            $stmt = $this->conex->prepare("select * from paciente where id_paciente = ?");
            $stmt->bindValue(1,$this->getId());
            $stmt->execute();

            while($array = $stmt->fetch(PDO::FETCH_ASSOC)){

                $dataI = $array['pSMS'];
                $dataF = $array['uSMS'];
            }


            if($dataI == "0000-00-00" || $dataF == "0000-00-00" || $dataI == "" || $dataF == ""){
               

                $stmt = $this->conex->prepare("delete from paciente where id_paciente = ?");
                $stmt->bindValue(1,$this->getId());
                $stmt->execute();

                $stmt = $this->conex->prepare("delete from  dados where id_Paci = ?");
                $stmt->bindValue(1,$this->getId());
                $stmt->execute();
                
                return 1;    

            }else{
                return 0;
            }

         }catch ( PDOException $ex ){  
             echo "Erro: ".$ex->getMessage(); 
         }
          $this->conex = PDOConnectionFactory::Close();

    }

    public function busca($cpf){

        $this->conex = PDOConnectionFactory::getConnection();
        $this->setCpf($cpf);

        try{

            $stmt = $this->conex->prepare("select * from paciente where cpf = ?");
            $stmt->bindValue(1,$this->getCpf());
            $stmt->execute();

            $id;
            while($nome = $stmt->fetch(PDO::FETCH_ASSOC)){

                        $id = $nome['id_paciente'];
            }

            return $id;
            $this->conex = PDOConnectionFactory::Close();

        }catch ( PDOException $ex ){  
            echo "Erro: ".$ex->getMessage(); 
        } 

    }

    public function contar(){

       $this->conex = PDOConnectionFactory::getConnection();
        try{            
            $count = 0;
            $stmt = $this->conex->query("select * from paciente");
            
            foreach($stmt as $usuario){
                $count ++;
            }
            $this->conex = PDOConnectionFactory::Close();
            return $count;
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }
    }


    public function dataSMS($id) {
        $this->conex = PDOConnectionFactory::getConnection();
        #setar os valores
        $this->setId($id);

        $dataP;
        $dataU;
        $dataHoje = date('Y-m-d');

        try{
                     
                $stmt = $this->conex->prepare("select * from paciente where id_paciente = ?");
                $stmt->bindValue(1,$this->getId());
                $stmt->execute();

                while($nome = $stmt->fetch(PDO::FETCH_ASSOC)){

                    $dataP = $nome['pSMS'];
                    $dataU = $nome['uSMS'];
                }
                if ($dataP == "0000-00-00" || $dataP == null){

                    $stmt = $this->conex->prepare("update paciente set pSMS = ? , uSMS = ? where id_paciente = ?");
                    $stmt->bindValue(1,$dataHoje);
                    $stmt->bindValue(2,$dataHoje);
                    $stmt->bindValue(3,$this->getId());
                    $stmt->execute();

                   
                }else{
                    $stmt = $this->conex->prepare("update paciente set uSMS = ? where id_paciente = ?");
                    $stmt->bindValue(1,$dataHoje);
                    $stmt->bindValue(2,$this->getId());
                    $stmt->execute(); 

                }

            
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }

    }


}
