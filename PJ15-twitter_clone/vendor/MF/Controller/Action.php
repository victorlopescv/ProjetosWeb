<?php  
namespace MF\Controller;

class Action{

	protected $view;

	public function __construct(){
		$this->view = new \stdClass(); 
		
	}

	protected function render($viewsIndex,$layout = 'layout'){ 

		$this->view->namePage = $viewsIndex; 

		if (file_exists("../App/Views/".$layout.".phtml")){	 
			require_once "../App/Views/".$layout.".phtml";
		}else { 
			$this->content();
		}
		
		
	}

	protected function content(){
		$classAtual = get_class($this); 
		
		$classAtual = str_replace("App\\Controllers\\", '', $classAtual); 
	
		
		$classAtual = strtolower(str_replace("Controller", '', $classAtual)); 
				
		require_once "../App/Views/".$classAtual."/".$this->view->namePage.".phtml"; 



	}



}


?>