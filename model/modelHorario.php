<?php

#inclui arquivo da classe de conexão
include_once '../../model/PDOConnectionFactory.class.php';

class modelHorario extends PDOConnectionFactory {
    
   public $conex = null;

    
    public function inserir( $b ){
        $this->conex = PDOConnectionFactory::getConnection();
        try{            
            $stmt = $this->conex->prepare("insert into horario_login (dia_sem, hora_ini, hora_fim, id_usuario) value (?,?,?,?)");           
            $stmt->bindValue(1, $b->getDiaSem() );
            $stmt->bindValue(2, $b->getHoraIni() );
            $stmt->bindValue(3, $b->getHoraFim() );
            $stmt->bindValue(4, $b->getIdUsuario() );
            $stmt->execute();
            $this->conex = PDOConnectionFactory::Close();
        }catch ( PDOException $ex ){  
            echo "Erro: ".$ex->getMessage(); 
        }
    }       
    
    public function alterar( $b ){
        $this->conex = PDOConnectionFactory::getConnection();
        try{
            $stmt = $this->conex->prepare("update horario_login set dia_sem=?, hora_ini=?, hora_fim=?, id_usuario=? where id_horario_login=?");
            $this->conex->beginTransaction();
            
            $stmt->bindValue(1, $b->getDiaSem() );
            $stmt->bindValue(2, $b->getHoraIni() );
            $stmt->bindValue(3, $b->getHoraFim() );
            $stmt->bindValue(4, $b->getIdUsuario() );
            $stmt->bindValue(5, $b->getIdHorarioLogin() );
            
            $stmt->execute();
 
            $this->conex->commit();
            
            $this->conex = PDOConnectionFactory::Close();
        
        }catch ( PDOException $ex ){  
            echo "Erro: ".$ex->getMessage(); 
        }
    }
    
    public function excluir( $id ){
        $this->conex = PDOConnectionFactory::getConnection();
        try{
            $num = $this->conex->exec("delete from horario_login where id_horario_login = $id");            
            $this->conex = PDOConnectionFactory::Close();
            if( $num >= 1 ){ 
                return $num; 
            } else { 
                return 0; 
            }           
        }catch ( PDOException $ex ){  
            echo "Erro: ".$ex->getMessage(); 
        }
    }
    
    public function listar($query = null){
        $this->conex = PDOConnectionFactory::getConnection();
        try{
            if( $query == null ){               
                $stmt = $this->conex->query("select * from horario_login order by id_horario_login");
            }else{
                $stmt = $this->conex->query($query);
            }
            $this->conex = PDOConnectionFactory::Close();
            return $stmt;
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }
    }
    
    public function contar( $query = null){
        $this->conex = PDOConnectionFactory::getConnection();
        try{            
            $count = 0;
            if( $query == null ){
                $stmt = $this->conex->query("select * from horario_login");
            }else{
                $stmt = $this->conex->query($query);                
            }           
            foreach($stmt as $b){
                $count ++;
            }
            $this->conex = PDOConnectionFactory::Close();
            return $count;
        }catch ( PDOException $ex ){  
            //echo "Erro: ".$ex->getMessage(); 
        }
    }

}
