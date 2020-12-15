<?php

use controllers\adminController;

    define('HOST','localhost'); // Host do banco
    define('DATABASE','suporte_personalizado'); // Nome do banco
    define('USER','root');  // Usuário do banco
    define('PASSWORD','1234');  // Senha do banco

    define('BASE','http://localhost/Projetos/sistema-suporte/'); //No momento que for alterar precisa checar se todos os links irão funcionar
    
    define('EMAIL_USERNAME',''); // email que vai mandar as mensagens
    define('EMAIL_PASSWORD',''); // senha do email
    define('EMAIL_HOST','');  // host (ex: smtp.gmail.com)
    define('EMAIL_SMTPSECURE','tls');
    define('EMAIL_PORT',587);
    define('EMAIL_SENDER',''); // Nome do remetente que aparecerá no email

    define('ROUTE_CSS','styles/styles.css');
    define('ROUTE_JS','scripts/scripts.js');
    define('ROUTE_ASSETS','assets/demo/');
    
    define('LANG','pt-BR');
    define('TITLE','Sistema | Suporte');
    define('COPYRIGHT',"Copyright &copy; www.sistemasuporte.com.br | Sistema Suporte ".date("Y"));
    
    require 'vendor/autoload.php';

    $autoload = function($class){
        include($class.'.php');
    };

    spl_autoload_register($autoload);

    $ticketController = new \controllers\ticketController();
    $adminController = new \controllers\adminController();
    $loginController = new \controllers\loginController();
    
    Router::get('/abrir-chamado',function() use ($ticketController){
        $ticketController->index();
    });

    Router::get('/chamado',function() use ($ticketController){
        if(isset($_GET['token'])){
            if($ticketController->existeToken()){
                $info = $ticketController->getPergunta($_GET['token']);
                $ticketController->abrirChamado($info);
            }else{
                header('location: pagina-nao-encontrada');
            }
        }else{
            header('location: pagina-nao-encontrada');
        }
    });

    Router::get('/pagina-nao-encontrada',function() use ($adminController){
        $adminController->error();
    });

    Router::get('/login',function() use ($loginController){
        $loginController->index();
    });

    Router::get('/admin',function() use ($adminController){
        $adminController->index();
    });

    Router::get('/admin/chamados',function() use ($adminController){
        $adminController->chamados();
    });

    Router::get('/admin/chamados/abrir',function() use ($adminController){
        if(isset($_GET['token'])){
            if($adminController->existeToken()){
                $info = $adminController->getPergunta($_GET['token']);
                $adminController->abrirChamado($info);
            }else{
                header('location: ../../pagina-nao-encontrada');
            }
        }else{
            header('location: ../../pagina-nao-encontrada');
        }
    });

    Router::get('/admin/inventario',function() use ($adminController){
        $adminController->inventario();
    });

    Router::get('/admin/usuarios',function() use ($adminController){
        $adminController->usuarios();
    });

?>