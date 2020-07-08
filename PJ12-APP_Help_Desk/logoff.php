<?php 
 
 session_start();
 
//  echo "<pre>";
//  print_r($_SESSION);
//  echo "</pre>";

// //excluir de qualquer array passando o indice que deseja excluir
// //nesete caso removendo indice da sessão 
//  unset($_SESSION['x']); // caso nao haja a variavel continua executando e nao apresenta erro

//  echo "<pre>";
//  print_r($_SESSION);
//  echo "</pre>";

//  //exclui toda a sessão e caso não haja sessão apresenta erro 
//  session_destroy(); // só apresenta a exclusão após a proxima atualização por isso é comum atualizarmos a pagia ou redirecionala em seguida deste comando
//  header('Location: index.php');

//  echo "<pre>";
//  print_r($_SESSION);
//  echo "</pre>";

//exclui toda a sessão e caso não haja sessão apresenta erro 
 session_destroy(); // só apresenta a exclusão após a proxima atualização por isso é comum atualizarmos a pagia ou redirecionala em seguida deste comando
 header('Location: index.php') //só fica disponivel o comando de destruição da sessao após uma nova requisição ao servidor  por isso atualizamos para a index.php q ja vai atualizada

 ?>	