<?php  

namespace App\Controllers;
//recursos miniframework
use MF\Controller\Action;
use MF\Model\Container;


class IndexController extends Action{
	
	public function index() {
		
		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		$this->render('index');
	}

	public function inscreverse() {
		
		$this->view->erroCadastro = false;
		
		$this->render('inscreverse');
	}

	public function registrar(){
		
		//receber dados formulario
		$usuario = Container::getModel('Usuario');

		$usuario->__set('nome',$_POST['nome']);     
		$usuario->__set('email',$_POST['email']);
		$usuario->__set('senha',md5($_POST['senha']));
		
		if ($usuario->validarCadastro() && count($usuario->getUsuarioPorEmail()) == 0) {
			
			$usuario->salvar();
			$this->render('cadastro');
								
		}else {

			$this->view->erroCadastro = true;

			$this->view->usuario = array(
				"nome" => $_POST['nome'],
				"email" => $_POST['email'],
				"senha" => $_POST['senha']	
			);
			
			$this->render('inscreverse');
		}

	}


	
}

?>
