<?php
    session_start();
    
    require_once 'Classes/conexao.class.php';
    require_once 'Classes/validaCampos.class.php';

    foreach($_POST as $i)
        trim($i);

    //$validar = new ValidaCampos();

    $logForm = $_POST['username'];
    $senhaForm = $_POST['senha'];
    $botao = $_POST['enviar'];

    password_hash($senhaForm, PASSWORD_DEFAULT);

    if ($botao == "Entrar")
    {    
        $obj_con = new Conexao();
        

        $dados = $obj_con->select($logForm,$senhaForm);
                      
        //Testa se retornou dados do SELECT
        //print_r($dados);
        //verifica se array $dados está vazio
        // se estiver vazio, não achou login/senha no BD
        //if (sizeof($dados)!=0) {
        if (!empty($dados) && $dados!=false) {
            //echo "Usuário autenticado.";
            foreach($dados as $i)    
                $_SESSION['codUsuario']    =   $i['codUsuario'];
                $_SESSION['nomeUsuario']   =   $i['nomeUsuario'];
                $_SESSION['nomePessoa']    =   $i['nomePessoa'];
                $_SESSION['email']         =   $i['email'];
                $_SESSION['acessoAdm']     =   $i['acessoADM'];
                $_SESSION['qtosMateriais'] =   $i['qtosMateriais'];
            
                //print_r($_SESSION);
            
            header('Location:Home.php');

        }
        else {
            //echo "Acesso negado.";
            header('Location:Index.php?entrou=NOK');
        }
    }
?>