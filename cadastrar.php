<?php

    $usnForm = $_POST['username'];
    $nmForm = $_POST['nome'];
    $emailForm = $_POST['email'];
    $senhaForm = $_POST['senha'];
    $senhaConfirmarForm = $_POST['confirmarSenha'];
    $botao = $_POST['cadastrar'];
    $parar=false;
    
    require_once'classes/validaCampos.class.php';

    $validarCampos = new ValidaCampos();

    if (!$validarCampos->validaSenha($senhaForm)) {
        header('Location:Index.php?erroCadastro=senhaFraca'); $parar=true;}

    if (!$validarCampos->validaEmail($emailForm)) {
        header('Location:Index.php?erroCadastro=emailInvalido'); $parar=true;}

    if ($senhaForm != $senhaConfirmarForm) {
        header('Location:Index.php?erroCadastro=senhasNaoCorrespondem'); $parar=true;}

    $aux=strlen($usnForm);
    if (($aux==0) || ($aux>25)) {
        header('Location:Index.php?erroCadastro=camposNaoPreenchidosCorretamente'); $parar=true; }
    $aux=strlen($nmForm);
    if (($aux==0) || ($aux>100)) {
        header('Location:Index.php?erroCadastro=camposNaoPreenchidosCorretamente'); $parar=true;}
    $aux=strlen($emailForm);
    if (($aux==0) || ($aux>64)) {
        header('Location:Index.php?erroCadastro=camposNaoPreenchidosCorretamente'); $parar=true;}
    $aux=strlen($senhaForm);
    if (($aux==0) || ($aux>64)) {
        header('Location:Index.php?erroCadastro=camposNaoPreenchidosCorretamente'); $parar=true;}
    $aux=strlen($senhaConfirmarForm);
    if (($aux==0) || ($aux>64)) {
        header('Location:Index.php?erroCadastro=camposNaoPreenchidosCorretamente'); $parar=true;}

    // Se o programa chegou aqui sem a variavel $parar receber true, o usuario pode ser incluido

    if (!$parar)
    {
        $senhaCriptografada=password_hash($senhaForm, PASSWORD_DEFAULT);

        require_once'classes/conexao.class.php';

        foreach($_POST as $i)
            trim($i);

        if ($botao == "Cadastrar")
        {
            $obj_con = new Conexao();
            
            if(!$obj_con->usuarioJaExiste($usnForm))
            {
                $usuario = array('NomeU' => $usnForm, 'NomeP' => $nmForm, 'Email' => $emailForm, 'Senha' => $senhaCriptografada);

                $obj_con->insertUsuario($usuario);
            }
        }

        header('Location:Index.php');
    }

?>