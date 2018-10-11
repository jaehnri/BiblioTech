<?php
	session_start();

    if (!isset($_SESSION['codUsuario']))
        header('Location:index.php');

	include_once 'Classes/conexao.class.php';

    if (isset($_POST['btnCancelar']))
    {
         unset($_SESSION['btnExcluir']);
         unset($_SESSION['btnExcluirDeTodos']);
         header('Location:perfil.php');
    }
    else
    {
        if(isset($_POST['codMaterial']))
        if($_POST['codMaterial'] != "")
        {
            $conexao = new Conexao();
            $materialADeletar = $conexao->selectMaterialCod($_POST['codMaterial']);

            foreach($materialADeletar as $i)
                $file_Path = $i['localizacaoDoArquivo'];
            //$file_Path = $materialADeletar['localizacaoDoArquivo'];

            if (file_exists($file_Path))
            {
                unlink($file_Path);
                $conexao->deleteMaterial($_POST['codMaterial']);
                header("Location:perfil.php");
                die();
            } 
            else {
                header("Location:perfil.php?erro=erroDeletarArquivo");
            }
        }



        //Cai aqui se a pessoa escrever este endereço de URL após fazer login;
        header('Location:perfil.php');
    }
?>