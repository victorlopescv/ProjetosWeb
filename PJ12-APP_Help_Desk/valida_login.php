 <?php
    //abrindo uma nova sessao, esta tem q ser declarada antes de qualquer input (echo,print_r,etc..)
    //sessão dura aproximadamente 3horas. Sessao é um ip digamos assim que o navegador guarda no cookies
    session_start();

//VARIAVEL QUE VERIFICA SE A AUTENTICAÇÃO FOI REALIZADA
$usuario_autenticado = false;
$usuario_id = null;
$usuario_perfil_id = null;

$perfis = [1 => 'Administrativo', 2 => 'Usuário'];

//USUARIOS DO SISTEMA
$usuarios_app = array(
    array('id'=>1 ,'email' => 'adm@teste.com.br', 'senha' => '123456','perfil'=>1),
    array('id'=>2 ,'email' => 'user@teste.com.br', 'senha' => 'abcd','perfil'=>1),
    array('id'=>3 ,'email' => 'jose@teste.com.br', 'senha' => '1234','perfil'=>2),
    array('id'=>4 ,'email' => 'maria@teste.com.br', 'senha' => '0000','perfil'=>2)
);
/*

echo '<pre>';
print_r($usuarios_app);
echo '</pre>';

*/

foreach($usuarios_app as $user){
    /*
    echo 'Usuario app: ' . $user['email'] . '/' . $user['senha'];
    echo '<br />';
    echo 'Usuario form: ' . $_POST['email'] . '/' . $_POST['senha'];
    echo '<hr />';
    */
    if($user['email'] == $_POST['email'] && $user['senha'] == $_POST['senha']){
        $usuario_autenticado = true;
        $usuario_id = $user['id'];
        $usuario_perfil_id = $user['perfil'];
    }
}

    if($usuario_autenticado){
  
        $_SESSION['autenticado']='SIM';
        $_SESSION['id'] = $usuario_id;
        $_SESSION['perfil'] = $usuario_perfil_id;
        header('Location: home.php');
    }else{
        $_SESSION['autenticado']='NAO';
        header('Location: index.php?login=erro'); //manda para a pagina indicada e envia junto um parametro após a '?'
    }


/*
print_r($_GET)

echo '<br />'
echo $_GET['email']
echo '<br />'
echo $_GET['senha']
print_r($_POST);
*/

?>