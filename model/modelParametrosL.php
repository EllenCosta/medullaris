<?php

#inclui arquivo da classe de conexão
include_once 'PDOConnectionFactory.class.php';

class modelParametros extends PDOConnectionFactory {
    
    public $conex = null;

    #atributos
    private $id;
    private $nome;
    private $cpf;
    private $dor;
    private $data;
    private $login;
    private $pass;


    #métodos gets e sets
    public function getId() {return $this->id;}
    public function getNome() {return $this->nome;}
    public function getCpf() {return $this->cpf;}
    public function getDor() {return $this->dor;}
    public function getData() {return $this->data;}
    public function getLogin() {return $this->login;}
    public function getPass() {return $this->pass;}



    public function setId($id) {$this->id = $id;}
    public function setNome($nome) {$this->nome = $nome;}
    public function setCpf($cpf) {$this->cpf = $cpf;}
    public function setDor($dor) {$this->dor = $dor;}
    public function setData($data) {$this->data = $data;}
    public function setLogin($login) {$this->login = $login;}
    public function setPass($pass) {$this->pass = $pass;}

    #metodo para execultar uma consulta, recebe como parametro o id e o nome
    

    #método para inserir um paciente
    public function inserir($nome, $cpf, $dor, $data) {

        $this->conex = PDOConnectionFactory::getConnection();

        #setar os dados
        $this->setNome($nome);
        $this->setCpf($cpf);
        $this->setDor($dor);
        $this->setData($data);
        $idPac = null;

        try{

            $stmt = $this->conex->prepare("select * from paciente where cpf = ?");
            $stmt->bindValue(1,$this->getCpf());
            $stmt->execute();

            if ($stmt->rowCount() == 0){

                $stmt = $this->conex->prepare("insert into paciente (id, cpf, nome) values (?, ?, ?)");
                $stmt->bindValue(1," ");
                $stmt->bindValue(2,$this->getCpf());
                $stmt->bindValue(3,$this->getNome());
                $stmt->execute();

                $ultimoID = $this->conex->lastInsertId();
                $this->setId($ultimoID);
                //$stmt = null;

                $stmt = $this->conex->prepare("insert into dados (id_Paci, dor, data) values (?, ?, ?)");
                $stmt->bindValue(1, $this->getId());
                $stmt->bindValue(2, $this->getDor());
                $stmt->bindValue(3, $this->getData());
                $stmt->execute();

            }else{

                 while($ID = $stmt->fetch(PDO::FETCH_ASSOC)){

                    $return = $ID['id'];
                    $this->setId($return);
                }

                $stmt = $this->conex->prepare("insert into dados (id_Paci, dor, data) values (?, ?, ?)");
                $stmt->bindValue(1, $this->getId());
                $stmt->bindValue(2, $this->getDor());
                $stmt->bindValue(3, $this->getData());
                $stmt->execute();

            }

            
            
            $this->conex = PDOConnectionFactory::Close();

        }catch ( PDOException $ex ){  
            echo "Erro: ".$ex->getMessage(); 
        }
    
    }

    #metodo para alterar um paciente    
    public function alterar( $p ){
        $this->conex = PDOConnectionFactory::getConnection();
        try{
            $stmt = $this->conex->prepare("update parametros set valor = ? where descricao = ?");
            $this->conex->beginTransaction();
                        
            $stmt->bindValue(1, $p->getValor() );
            $stmt->bindValue(2, $p->getDescricao() );
            
            $stmt->execute();
 
            $this->conex->commit();
            
            $this->conex = PDOConnectionFactory::Close();
        
        }catch ( PDOException $ex ){  
            echo "Erro: ".$ex->getMessage(); 
        }
    }

    public function listar($sql) {

        $this->conex = PDOConnectionFactory::getConnection();

        try{

                if($sql == "") {
                    $stmt = $this->conex->prepare("select * from parametros");
                    $stmt->execute();

                    return $stmt;
                    $this->conex = PDOConnectionFactory::Close();
                }else{

                    $stmt = $this->conex->prepare($sql);
                    $stmt->execute();

                    return $stmt;
                    $this->conex = PDOConnectionFactory::Close();

                }
                
                

        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }

    }

}
