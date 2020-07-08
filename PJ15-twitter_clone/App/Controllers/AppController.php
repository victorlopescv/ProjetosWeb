<?php  

namespace App\Controllers;
//recursos miniframework
use MF\Controller\Action;
use MF\Model\Container;


class AppController extends Action{
	
	public function timeline() {
		
		$this->validaAutenticacao();		

		$tweet = Container::getModel("Tweet");
		$tweet->__set('id_usuario',$_SESSION['id']);

		$tweets = $tweet->getAll();

		$this->view->tweets = $tweets;

		$usuario = Container::getModel('Usuario');	
		$usuario->__set('id',$_SESSION['id']);

		$this->view->nomeUsuario = $usuario->nomeUsuarioLogado();	
		$this->view->totalTweets = $usuario->totalTweets();
		$this->view->totalSeguindo = $usuario->totalSeguindo();
		$this->view->totalSeguidores = $usuario->totalSeguidores();

		$this->render("timeline");
			
	}

	public function tweet(){

		$this->validaAutenticacao();	
			
		$tweet = Container::getModel('Tweet');

		if ($_POST['tweet'] != '') {
			
		$tweet->__set('tweet',$_POST['tweet']); 
		$tweet->__set('id_usuario',$_SESSION['id']);

		$tweet->salvar();
		
		}

		header("Location: /timeline");	
	}

	public function validaAutenticacao(){

		session_start();

		if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '' ) {
			header("Location: /?login=erro");
		}
	}

	public function quemSeguir(){

		$this->validaAutenticacao();

		$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';
		$usuarios = array();

		$usuario = Container::getModel('Usuario');
		$usuario->__set('id',$_SESSION['id']);
			
		if ($pesquisarPor != '') {
		$usuario->__set('nome',$pesquisarPor);
		$usuarios = $usuario->getAll();

		}

		$this->view->nomeUsuario = $usuario->nomeUsuarioLogado();	
		$this->view->totalTweets = $usuario->totalTweets();
		$this->view->totalSeguindo = $usuario->totalSeguindo();
		$this->view->totalSeguidores = $usuario->totalSeguidores();
		$this->view->usuarios = $usuarios;		
		
		$this->render('quemSeguir');
	}

	public function acao(){
		
		$this->validaAutenticacao();

		$acao = isset($_GET['acao']) ? $_GET['acao'] : '';
		$id_usuario_seguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';
		$id_tweet = isset($_GET['id_tweet']) ? $_GET['id_tweet'] : '';

		$usuario = Container::getModel('Usuario');        
        $usuario->__set('id',$_SESSION['id']);

        if ($acao == 'seguir') {
        	$usuario->seguirUsuario($id_usuario_seguindo);
        	header("Location: /quem_seguir");

        } if ($acao == 'deixar_de_seguir') {
        	$usuario->deixarseguirUsuario($id_usuario_seguindo);
        	header("Location: /quem_seguir");
        	
        }if ($acao == 'remover_tweet') {
        	$usuario->remover_tweet($id_tweet);
        	header("Location: /timeline");
        	

        }


	}

}

?>
