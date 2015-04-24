<?php
class EmpresaDao extends PDOConnectionFactory {
	
	public $conex = null;
	
	public function EmpresaDao(){
		//$this->conex = PDOConnectionFactory::getConnection();
	}
	
	public function inserir( $empresa ){
		$this->conex = PDOConnectionFactory::getConnection();
		try{			
			$stmt = $this->conex->prepare("insert into empresa (nome, cnpj, cnes, desc_imp, email, endereco, telefone, fax, logo, cnae, nfe_serie, nfe_modelo, nfe_regime, nfe_tributo, nfe_email_cc, nfe_ir, cep, bairro, cidade, codigo_ibge, uf, ie, numero) value (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$stmt->bindValue(1, $empresa->getNome() );			
			$stmt->bindValue(2, $empresa->getCnpj() );			
			$stmt->bindValue(3, $empresa->getCnes() );			
			$stmt->bindValue(4, $empresa->getDescImp() );			
			$stmt->bindValue(5, $empresa->getEmail() );			
			$stmt->bindValue(6, $empresa->getEndereco() );			
			$stmt->bindValue(7, $empresa->getTelefone() );
			$stmt->bindValue(8, $empresa->getFax() );
			$stmt->bindValue(9, $empresa->getLogo() );
			$stmt->bindValue(10, $empresa->getCnae() );
			$stmt->bindValue(11, $empresa->getNfeSerie() );
			$stmt->bindValue(12, $empresa->getNfeModelo() );
			$stmt->bindValue(13, $empresa->getNfeRegime() );
			$stmt->bindValue(14, $empresa->getNfeTributo() );
			$stmt->bindValue(15, $empresa->getNfeEmailCc() );
			$stmt->bindValue(16, $empresa->getNfeIr() );
			$stmt->bindValue(17, $empresa->getCep() );
			$stmt->bindValue(18, $empresa->getBairro() );
			$stmt->bindValue(19, $empresa->getCidade() );
			$stmt->bindValue(20, $empresa->getCodigoIbge() );
			$stmt->bindValue(21, $empresa->getUf() );
			$stmt->bindValue(22, $empresa->getIe() );
			$stmt->bindValue(23, $empresa->getNumero() );
 			
			$stmt->execute();
 
			$this->conex = PDOConnectionFactory::Close();
		}catch ( PDOException $ex ){  
			echo "Erro: ".$ex->getMessage(); 
		}
	}
	
	public function alterar( $empresa ){
		$this->conex = PDOConnectionFactory::getConnection();
		try{
			if($empresa->logo != ""){				
				$stmt = $this->conex->prepare("update empresa set nome=?, cnpj=?, cnes=?, desc_imp=?, email=?, endereco=?, telefone=?, fax=?, logo=?, cnae=?, nfe_serie=?, nfe_modelo=?, nfe_regime=?, nfe_tributo=?, nfe_email_cc=?, nfe_ir=?, cep=?, bairro=?, cidade=?, codigo_ibge=?, uf=?, ie=?, numero=? where id_empresa=?");
				$this->conex->beginTransaction();
				
				$stmt->bindValue(1, $empresa->getNome() );
				$stmt->bindValue(2, $empresa->getCnpj() );
				$stmt->bindValue(3, $empresa->getCnes() );
				$stmt->bindValue(4, $empresa->getDescImp() );
				$stmt->bindValue(5, $empresa->getEmail() );
				$stmt->bindValue(6, $empresa->getEndereco() );
				$stmt->bindValue(7, $empresa->getTelefone() );
				$stmt->bindValue(8, $empresa->getFax() );
				$stmt->bindValue(9, $empresa->getLogo() );
				$stmt->bindValue(10, $empresa->getCnae() );			
				$stmt->bindValue(11, $empresa->getNfeSerie() );			
				$stmt->bindValue(12, $empresa->getNfeModelo() );			
				$stmt->bindValue(13, $empresa->getNfeRegime() );			
				$stmt->bindValue(14, $empresa->getNfeTributo() );			
				$stmt->bindValue(15, $empresa->getNfeEmailCc() );			
				$stmt->bindValue(16, $empresa->getNfeIr() );
				$stmt->bindValue(17, $empresa->getCep() );
				$stmt->bindValue(18, $empresa->getBairro() );
				$stmt->bindValue(19, $empresa->getCidade() );
				$stmt->bindValue(20, $empresa->getCodigoIbge() );
				$stmt->bindValue(21, $empresa->getUf() );
				$stmt->bindValue(22, $empresa->getIe() );
				$stmt->bindValue(23, $empresa->getNumero() );
				$stmt->bindValue(24, $empresa->getIdEmpresa() );
				
				$stmt->execute();
	 
				$this->conex->commit();
				
				$this->conex = PDOConnectionFactory::Close();
			}else{
				$stmt = $this->conex->prepare("update empresa set nome=?, cnpj=?, cnes=?, desc_imp=?, email=?, endereco=?, telefone=?, fax=?, cnae=?, nfe_serie=?, nfe_modelo=?, nfe_regime=?, nfe_tributo=?, nfe_email_cc=?, nfe_ir=?, cep=?, bairro=?, cidade=?, codigo_ibge=?, uf=?, ie=?, numero=? where id_empresa = ?");
				$this->conex->beginTransaction();
				
				$stmt->bindValue(1, $empresa->getNome() );
				$stmt->bindValue(2, $empresa->getCnpj() );
				$stmt->bindValue(3, $empresa->getCnes() );
				$stmt->bindValue(4, $empresa->getDescImp() );
				$stmt->bindValue(5, $empresa->getEmail() );
				$stmt->bindValue(6, $empresa->getEndereco() );
				$stmt->bindValue(7, $empresa->getTelefone() );
				$stmt->bindValue(8, $empresa->getFax() );
				$stmt->bindValue(9, $empresa->getCnae() );			
				$stmt->bindValue(10, $empresa->getNfeSerie() );			
				$stmt->bindValue(11, $empresa->getNfeModelo() );			
				$stmt->bindValue(12, $empresa->getNfeRegime() );			
				$stmt->bindValue(13, $empresa->getNfeTributo() );			
				$stmt->bindValue(14, $empresa->getNfeEmailCc() );			
				$stmt->bindValue(15, $empresa->getNfeIr() );
				$stmt->bindValue(16, $empresa->getCep() );
				$stmt->bindValue(17, $empresa->getBairro() );
				$stmt->bindValue(18, $empresa->getCidade() );
				$stmt->bindValue(19, $empresa->getCodigoIbge() );
				$stmt->bindValue(20, $empresa->getUf() );
				$stmt->bindValue(21, $empresa->getIe() );
				$stmt->bindValue(22, $empresa->getNumero() );
				$stmt->bindValue(23, $empresa->getIdEmpresa() );
				
				$stmt->execute();
	 
				$this->conex->commit();
				
				$this->conex = PDOConnectionFactory::Close();
			}
		}catch ( PDOException $ex ){  
			echo "Erro: ".$ex->getMessage(); 
		}
	}
	
	
	public function excluir( $idEmpresa ){
		$this->conex = PDOConnectionFactory::getConnection();
		try{			
			$num = $this->conex->exec("delete from empresa where id_empresa = $idEmpresa");			
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
				$stmt = $this->conex->query("select * from empresa order by id_empresa");
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
				$stmt = $this->conex->query("select * from empresa");
			}else{
				$stmt = $this->conex->query($query);				
			}			
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

?>