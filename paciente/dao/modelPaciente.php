<?php
header("Content-Type" . "text/plain");
#inclui arquivo da classe de conexão
include_once '../model/PDOConnectionFactory.class.php';

class modelPaciente extends PDOConnectionFactory {
    
    public $conex = null;

    #atributos
    private $id;
    private $nome;
    private $cpf;
    private $dor;
    private $data;
    private $idDados;
    private $numAvaliacao;
  


    #métodos gets e sets
    public function getId() {return $this->id;}
    public function getNome() {return $this->nome;}
    public function getCpf() {return $this->cpf;}
    public function getDor() {return $this->dor;}
    public function getData() {return $this->data;}
    public function getIdDados() {return $this->idDados;}
    public function getNumAvaliacao() {return $this->numAvaliacao;}
   

    public function setId($id) {$this->id = $id;}
    public function setNome($nome) {$this->nome = $nome;}
    public function setCpf($cpf) {$this->cpf = $cpf;}
    public function setDor($dor) {$this->dor = $dor;}
    public function setData($data) {$this->data = $data;}
    public function setIdDados($idDados) {$this->idDados = $idDados;}
    public function setNumAvaliacao($numAvaliacao) {$this->numAvaliacao = $numAvaliacao;}

    
    public function nome($cpf) {
        $this->conex = PDOConnectionFactory::getConnection();
        $this->setCpf($cpf);

        try{
                     
                $stmt = $this->conex->prepare("select * from paciente where cpf = ?");
                $stmt->bindValue(1,$this->getCpf());
                $stmt->execute();

        
                    while($nome = $stmt->fetch(PDO::FETCH_ASSOC)){

                        $return = $nome['nome'];
                    }

                     $this->conex = PDOConnectionFactory::Close();
                     return $return;
            
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }

    }

    public function note($cpf){

        $this->conex = PDOConnectionFactory::getConnection();
        $this->setCpf($cpf);

        try{
            

                $stmt = $this->conex->prepare("select * from paciente where cpf = ?");
                $stmt->bindValue(1,$this->getCpf());
                $stmt->execute();

                if($stmt->rowCount() == 0){

                    return 1;
                }else{

                    while($nome = $stmt->fetch(PDO::FETCH_ASSOC)){

                        $this->setId($nome['id_paciente']);
                    }

                    $sql = "select * from paciente,dados where id_paciente = id_Paci and paciente.id_paciente = ".$this->getId()." order by avaliacao desc limit 0,1";
                    $stmt = $this->conex->prepare($sql);
                    $stmt->execute();

                    $n = $stmt->rowCount();


                    

                    if ($n == 0) {
                        return 2;
                        break;

                    }else{
                        for($i = 0; $i<$n; $i++){
                            $dados[] = $stmt->fetch(PDO::FETCH_ASSOC);
                        }

                        return json_encode($dados, true);
                    }
                    
                   
                    $this->conex = PDOConnectionFactory::Close();
                }   
                
            
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }

    }

    public function alerta($cpf){

        $this->conex = PDOConnectionFactory::getConnection();
        $this->setCpf($cpf);

        try{
              
                $stmt = $this->conex->prepare("select * from paciente where cpf = ?");
                $stmt->bindValue(1,$this->getCpf());
                $stmt->execute();

               
                    while($nome = $stmt->fetch(PDO::FETCH_ASSOC)){

                        $this->setNome($nome['nome']) ;
                        $this->setId($nome['id_paciente']);
                    }

                    $sql = "select * from paciente,dados where id_paciente = id_Paci and paciente.id_paciente = ".$this->getId()." order by avaliacao desc limit 0,1";
                    $stmt = $this->conex->prepare($sql);
                    $stmt->execute();


                    while($nome = $stmt->fetch(PDO::FETCH_ASSOC)){

                        $this->setData($nome['data']);
                        $this->setNumAvaliacao($nome['avaliacao']);
                    }

                    $dias;
                    $proxima;
                    $hoje = date('Y-m-d');
                   

                    $dias = $this->intervalo($this->getData(), $hoje);

                    if($dias <= 30){

                        $dias = 30 - $dias  ;
                        $current_date = new DateTime( );
                        $current_date->add( new DateInterval( 'P'.$dias.'D' ) );
                        $proxima = $current_date->format( 'Y-m-d' );
                        $proxima = implode("/",array_reverse(explode("-",$proxima))); 
                        $ultima = implode("/",array_reverse(explode("-",$this->getData())));

                        return "Data da última avaliação: ".$ultima."\n".$this->getNome()." faça sua próxima avaliação daqui a ".$dias." dias"."\nPróxima avaliação: ".$proxima;  
                    }else{

                        //$ultima = implode("/",array_reverse(explode("-",$this->getData())));
                        //return "Data da última avaliação: ".$ultima."<br>".$this->getNome()." faça uma nova avaliação!";
                        return 1;
                    }
                         
                    $this->conex = PDOConnectionFactory::Close();

                    

                    
                   
                
            
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }

    }
   

    public function avaliacao($cpf, $dor){

        $this->conex = PDOConnectionFactory::getConnection();

        $this->setCpf($cpf);
        $this->setDor($dor);
       

        try{

            $stmt = $this->conex->prepare("select * from paciente where cpf = ?");// verifica se o paciente está cadastrado.
            $stmt->bindValue(1,$this->getCpf());
            $stmt->execute();

            if ($stmt->rowCount() != 0){// se tiver faz verificações.

                foreach ($stmt as $id){
                    $this->setId($id['id_paciente']);//guarda o id do pacientes
                }
              
                
                $hoje = date('Y-m-d');

                $stmt = $this->conex->prepare("select * from dados where id_Paci = ?");
                $stmt->bindValue(1,$this->getId());
                $stmt->execute();



                 if ($stmt->rowCount() == 0){

                    $stmt = $this->conex->prepare("insert into dados (id_dados, id_Paci, avaliacao, dor, data) values (?,?,?,?,?)");
                    $stmt->bindValue(1,"");
                    $stmt->bindValue(2,$this->getId());
                    $stmt->bindValue(3,1);
                    $stmt->bindValue(4,$this->getDor());
                    $stmt->bindValue(5,$hoje);
                    $stmt->execute();

                    return 1;

                 }else{


                        foreach ($stmt as $data) {
                            if($data['data'] == $hoje){
                                $this->setIdDados($data['id_dados']);

                            }else{
                                $this->setIdDados(0);
                                $this->setData($data['data']);
                            }
                        
                        }

                         if($this->getIdDados() == 0){//verificar aqui se tem 30 dias da avaliacao
                            
                            $dias = $this->intervalo($this->getData(), $hoje);
            
                            if($dias >= 30){

                                $stmt = $this->conex->prepare("select max(avaliacao) as maior from dados where id_paci = ?");
                                $stmt->bindValue(1,$this->getId());
                                $stmt->execute();

                                foreach ($stmt as $data) {
                                    $this->setNumAvaliacao($data['maior']);
                                }


                                $numeroAvaliacao = $this->getNumAvaliacao() + 1;

                                $stmt = $this->conex->prepare("insert into dados (id_dados, id_Paci, avaliacao, dor, data) values (?,?,?,?,?)");
                                $stmt->bindValue(1,"");
                                $stmt->bindValue(2,$this->getId());
                                $stmt->bindValue(3,$numeroAvaliacao);
                                $stmt->bindValue(4,$this->getDor());
                                $stmt->bindValue(5,$hoje);
                                $stmt->execute();

                            }else{

                                $dias = 30 - $dias  ;
                            
                                $current_date = new DateTime( );

                                $current_date->add( new DateInterval( 'P'.$dias.'D' ) );

                                $proxima = $current_date->format( 'Y-m-d' );
                                                           
                                return implode("/",array_reverse(explode("-",$proxima)));
                            }

                            

                        }else{

                            $stmt = $this->conex->prepare("update dados set dor = ? where id_dados =?");
                            $stmt->bindValue(1,$this->getDor());
                            $stmt->bindValue(2,$this->getIdDados());
                            $stmt->execute();

                        }

                        return 1;


                 }
               
            }else{

                return 0;

            }

            
            
            $this->conex = PDOConnectionFactory::Close();

        }catch ( PDOException $ex ){  
            echo "Erro: ".$ex->getMessage(); 
        }
    
    }

    private function intervalo($inicio, $fim){

        $data_inicial =  implode("/",array_reverse(explode("-",$inicio)));
        $data_final =  implode("/",array_reverse(explode("-",$fim)));

        // Cria uma função que retorna o timestamp de uma data no formato DD/MM/AAAA
        function geraTimestamp($data) {
            $partes = explode('/', $data);
            return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
        }

        // Usa a função criada e pega o timestamp das duas datas:
        $time_inicial = geraTimestamp($data_inicial);
        $time_final = geraTimestamp($data_final);

        // Calcula a diferença de segundos entre as duas datas:
        $diferenca = $time_final - $time_inicial; // 19522800 segundos

        // Calcula a diferença de dias
        $dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias

        // Exibe uma mensagem de resultado:
       return $dias;

        // A diferença entre as datas 23/03/2009 e 04/11/2009 é de 225 dias


    }


}
