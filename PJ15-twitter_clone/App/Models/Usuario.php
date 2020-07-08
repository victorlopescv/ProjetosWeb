<?php 

namespace App\Models;

use MF\Model\Model;

class Usuario extends Model {

	private $id;
	private $nome;
	private $imagem;
	private $email;
	private $senha;

//funcao get e set já que sao privados os attr
	public function __get($attr){
		return $this->$attr;
	}

	public function __set($attr,$valor){
		$this->$attr = $valor;
	}

//salvar
	public function salvar(){
		$query = "insert into usuarios(nome,imagem,email,senha)values(:nome,:email,:senha)";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(":nome", $this->__get("nome"));
		$stmt->bindValue(":email", $this->__get("email"));
		$stmt->bindValue(":senha", $this->__get("senha")); // usaremos a funcao md5() -> hash 32 caracteres => para gravar nao a senha numerica no banco e sim uma criptografia hash com até 32 caractes
		$stmt->execute();

		return $this; //retornando o proprio obj
	}

//validar se um cadastro pode ser feito

	public function validarCadastro(){

	$valido = true;
		
		if (strlen($this->__get('nome')) < 3 ) {
			$valido = false;
		}
		if (strlen($this->__get('email')) < 3 ) {
			$valido = false;
		}
		if (strlen($this->__get('senha')) < 3 ) {
			$valido = false;
		}

	return $valido;	
	}
//recuperar um usuário por e-mail

	public function getUsuarioPorEmail(){

		$query = "select nome,email,senha from usuarios where email = :email";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(":email",$this->__get('email'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}


	public function autenticar(){

		$query = "select id,nome,email from usuarios where email = :email and senha = :senha";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':email',$this->__get('email'));
		$stmt->bindValue(':senha',$this->__get('senha'));
		$stmt->execute();

		$usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

		if ($usuario['id'] != '' && $usuario['nome'] != '') {
			$this->__set('id', $usuario['id']) ;
			$this->__set('nome', $usuario['nome']);
		}

		return $this; //retornando o objeto


	}

	public function getAll(){

		$query = "select 
					u.id,
					u.nome,
					u.email, 
					( 
					 select 
					 	count(*) 
					 from 
					 	usuarios_seguidores as us
					 where
					 	us.id_usuario = :id and us.id_usuario_seguindo = u.id
					  ) as seguindo_sn 
				  from 
				  	usuarios as u
				  where u.nome like :nome and u.id != :id
				  ";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':nome', '%'.$this->__get('nome').'%');
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);

	}

	public function seguirUsuario($id_usuario_seguindo){
		$query = "insert usuarios_seguidores(id_usuario,id_usuario_seguindo)
		values(:id,:id_usuario_seguindo)";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id',$this->__get('id'));
		$stmt->bindValue(':id_usuario_seguindo',$id_usuario_seguindo);
		$stmt->execute();

		return true;
	}

	public function deixarSeguirUsuario($id_usuario_seguindo){
		$query = "delete from usuarios_seguidores where id_usuario = :id and id_usuario_seguindo = :id_usuario_seguindo";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id',$this->__get('id'));
		$stmt->bindValue(':id_usuario_seguindo',$id_usuario_seguindo);
		$stmt->execute();

		return true;


	}

	public function remover_tweet($id_tweet){
		$query = "delete from tweets where id = :id";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id',$id_tweet);
		$stmt->execute();

		return true;


	}

	//informacao nome usuario logado
	public function nomeUsuarioLogado(){
		$query = "select nome from usuarios where id = :id_usuario";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario',$this->__get('id'));
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	//total tweets usuario logado
	public function totalTweets(){
		$query = "select count(*) as total_tweets from tweets where id_usuario = :id_usuario";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario',$this->__get('id'));
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	//total seguindo usuario logado
	public function totalSeguindo(){
		$query = "select count(*) as total_seguindo from usuarios_seguidores where id_usuario = :id_usuario";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario',$this->__get('id'));
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}


	//total seguidores usuario logado
	public function totalSeguidores(){
		$query = "select count(*) as total_seguidores from usuarios_seguidores where id_usuario_seguindo = :id_usuario";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario',$this->__get('id'));
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}	



}




 ?>