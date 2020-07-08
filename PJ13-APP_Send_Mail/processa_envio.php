<?php 
	
	//importando os arquivos de envio de e-mail (PHPMailer)
	require "bibliotecas/PHPMailer/Exception.php";
	require "bibliotecas/PHPMailer/OAuth.php";
	require "bibliotecas/PHPMailer/PHPMailer.php";
	require "bibliotecas/PHPMailer/POP3.php"; //protocolo de recebimento de email
	require "bibliotecas/PHPMailer/SMTP.php";//protocolo de envio de email

	//importa namespace PHPMailer
	use  PHPMailer \ PHPMailer \ PHPMailer ; 
	use  PHPMailer \ PHPMailer \ Exception ;

	class Mensagem {
		private $para = null;
		private $assunto = null;
		private $mensagem = null;
		public $status = Array('codigo_status'=>null,'descricao_status'=>'');

		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo,$valor){
			$this->$atributo=$valor;
		}

		public function mensagemValida(){
			//empty verifica se variavel é vazia
			// true se a variavel for vazia ou false se ela não for vazia
			if (empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
				//se algum valor da variavel estiver vazio a mensagem não é valida
				return false;
			}else{
				return true;
			}

		}
	}

	$mensagem = new Mensagem();
	$mensagem->__set('para',$_POST['para']);
	$mensagem->__set('assunto',$_POST['assunto']);
	$mensagem->__set('mensagem',$_POST['mensagem']);
	
//se o retorno for false é pq a mensagem não é valida então temos que inverter o valor para forçar que entre no if e de a mensagem "mensgem invalida"
	if(!$mensagem->mensagemValida()){
		echo 'Mensagem inválida';
		header('Location: index.php'); //caso tente acessar direto pagina processa_envio ira redirecionar para index.php, ou caso mensagem seja invalida.
		//die(); //comando nativo do PHP que descarta todo script abaixo
	}


	//instanciando objeto da classe PHPMailer
	$mail = new PHPMailer(true);
	try {
		
		//Configurando caracteres especiais
		$mail->CharSet = 'UTF-8';
		$mail->Encoding = 'base64';

	    //// Configurações do servidor
	    $mail->SMTPDebug = false;                                 // Habilita a saída de depuração detalhada caso valor seja 2 / para desabilitar podemos por false
	    $mail->isSMTP();                                      // Defina o mailer para usar SMTP
	    $mail->Host = 'smtp.gmail.com';  // Especifique os servidores SMTP principais e de backup
	    $mail->SMTPAuth = true;                               // Ativar autenticação SMTP 
	    $mail->Username = 'webenviocurso@gmail.com';                 // Nome de usuário SMTP
	    $mail->Password = '!@#$4321';                           // Senha SMTP
	    $mail->SMTPSecure = 'tls';                            // Habilite a criptografia TLS, `ssl` também aceita
	    $mail->Port = 587;                                    // porta TCP à qual se conectar

	    //Destinatários
	    $mail->setFrom('webenviocurso@gmail.com', 'Web Completo Remetente');			//define remetente
	    $mail->addAddress($mensagem->__get('para'));     // Adicione um destinatário
	    //$mail->addReplyTo('info@example.com', 'Information'); //enviar resposta do destinatario, caso haja, para email informado
	    //$mail->addCC('webenviocurso@gmail.com');    //enviar copia para email informado
	    //$mail->addBCC('bcc@example.com');  //enviar copia para email oculto informado		

	    // Adicionar Anexos 
	    //$mail->addAttachment('/var/tmp/file.tar.gz');          // Adiciona anexos
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // nome opcional 

	    // Conteúdo 
	    $mail->isHTML(true);                     // Defina o formato do email como HTML
	    $mail->Subject = $mensagem->__get('assunto'); //Assunto do e-mail
	    $mail->Body    = $mensagem->__get('mensagem'); //corpo do email. Client que aceite tags html
	    $mail->AltBody = 'É necessario um client que suporte HTML para verificar este e-mail'; //caso client email use o body alternativo(não aceita tags html) não renderiza tags html

	    $mail->send();

	    $mensagem->status['codigo_status']= 1;
	    $mensagem->status['descricao_status']= 'Mensagem enviada com sucesso';

	} catch (Exception $e) {
		$mensagem->status['codigo_status']= 2;
	    $mensagem->status['descricao_status']='Não foi possivel enviar este e-mail, por favor tente mais tarde'.$mail->ErrorInfo;
	   
	}
	//Podemos implementar uma logica que armazene o erro em um banco de dados para uma tratativa posterior


 ?>


 <html>
	<head>
		<meta charset="utf-8" />
    	<title>App Mail Send</title>

    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	</head>

<body>
	<div class="container">
		<div class="py-3 text-center">
				<img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
				<h2>Send Mail</h2>
				<p class="lead">Seu app de envio de e-mails particular!</p>
		</div>

		<div class="row">
			<div class="col-md-12 text-center">
				


				<? if ($mensagem->status['codigo_status']== 1) { ?>
				
					<div class="container">
						<h2 class="display-4 text-success">Sucesso</h2>
						<p><?= $mensagem->status['descricao_status'] ?></p>
						<a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
					</div>

				<?}?>


				<? if ($mensagem->status['codigo_status']== 2) { ?>
				
					<div class="container">
						<h2 class="display-4 text-danger">Ops!</h2>
						<p> <?= $mensagem->status['descricao_status']?> </p>
						<a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
					</div>
					
				<?}?>

			</div>

		</div>

	</div>	

</body>

</html	

