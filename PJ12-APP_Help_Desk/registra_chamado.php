<?php 
	session_start();
//	echo "<pre>";
//	print_r($_POST);
//	echo "</pre>";

//------- TRATANDO TEXTO

	foreach ($_POST as $indice => $valor) {

 	
 	 $_POST[$indice] = str_replace('#','-', $valor);

 	

	
 	// O CODIGO ACIMA FAZ PRATICAMENTE MSM COISA QUE ABAIXO, PORÉM DENTRO DE UM FOREACH
	//$_POST['titulo'] = str_replace('#','-', $_POST['titulo']); 
	// $_POST['categoria'] = str_replace('#','-', $_POST['categoria']);
	// $_POST['descricao'] = str_replace('#','-', $_POST['descricao']);
	}

	//implode junta tudo de um array em uma variavel separando os indices, neste caso por '#'
	$texto = $_SESSION['id'].'#'.implode('#', $_POST).PHP_EOL; //PHP_OEL insere uma quebra de linha como marcação
	
//------- ABRINDO ARQUIVO 
  	//abrindo arquivo
  	$arquivo = fopen('/arquivo.hd', 'a');
  	//escrevendo no arquivo
  	fwrite($arquivo, $texto);
  	//fechando o arquivo
  	fclose($arquivo);


  	header('Location: abrir_chamado.php');
 ?>