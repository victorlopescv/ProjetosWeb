<?require_once 'validador_acesso.php';?>
<?php 
  //array para receber os chamados do arquivo.hd
  $chamados = array();
  //abrindo o arquivo
  $arquivo = fopen('../../app_help_desk/arquivo.hd', 'r');
  
  //percorre todo o arquivo áté o fim e pega suas informações 
  //funcao feof()procura pelo fim do arquivo feof=(nome arquivo) => end of file
  //
  while (!feof($arquivo)) { // retorna true se achou o fim do arquivo e false se não achou

    //fgets recupera as informações do arquivo contido na linha atual do loop e para na quebra de linha
    //linha
   $registros = fgets($arquivo);
   $registro_detalhes = explode('#', $registros);

   if ($_SESSION['perfil']==2) {

   if($_SESSION['id']!= $registro_detalhes[0]){
    continue;
   }else{
      $chamados[]= $registros;
   }

 }else{
      $chamados[]= $registros;
   }
}

//fechar arquivo aberto
 fclose($arquivo);

 ?>


<html>
  <head>
    <meta charset="utf-8" />
    <title>App Help Desk</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
      .card-consultar-chamado {
        padding: 30px 0 0 0;
        width: 100%;
        margin: 0 auto;
      }
    </style>
  </head>

  <body>

    <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="#">
        <img src="logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
        App Help Desk
      </a>
      <ul class="navbar-nav" style="margin-right: 100px">
        <li class="nav-item">
          <a href="logoff.php" class="nav-link">SAIR</a>
        </li>
      </ul>      
    </nav>

    <div class="container">    
      <div class="row">

        <div class="card-consultar-chamado">
          <div class="card">
            <div class="card-header">
              Consulta de chamado
            </div>
            
            <div class="card-body">
              
              <? foreach ($chamados as $chamado) {?>
                
              <?php 
                // estamos pegando cada string dentro de cada indice do chamado e fazendo um explode, ou seja ara cada string separando em um indice por #
                //  pegando a string por ex: teste#teste#teste
                //   e realocando dentro do array $chamados_dados[0] = teste  
                //                                $chamados_dados[1] = teste
                //                                $chamados_dados[2] = teste   
                // separando por #

                  $chamado_dados = explode('#',$chamado);
                 
                ?>

              <?  
              //estamos verificando se cada indice do array $chamados_dados possui menos de 3 itens por exemplo: titulo,categoria e conteudo. Caso possui é pq não está preenchido completamente ou chegou na ultima linha do arquivo que terá nenhum item
              if (count($chamado_dados)<3) {
                continue;            
                  }
              ?>
                
             <div class="card mb-3 bg-light">
                <div class="card-body">
                  <h5 class="card-title"> <?=$chamado_dados[1]?> </h5>
                  <h6 class="card-subtitle mb-2 text-muted"> <?=$chamado_dados[2]?> </h6>
                  <p class="card-text"> <?=$chamado_dados[3]?> </p>

                </div>
              </div>

              
             <?}?> 

              <div class="row mt-5">
                <div class="col-6">

                  <a class="btn btn-lg btn-warning btn-block" href="home.php">Voltar</a>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>