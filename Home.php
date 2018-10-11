<?php

    session_start();

    if(!isset($_SESSION['codUsuario']))
        //die("Clique <a href='Index.php'>aqui</a> para fazer login");
        header('Location:Index.php');
    
    //echo "<script>alert('Bem vindo ".$_SESSION['nomeUsuario']."')</script>"
  
    header('Content-Type: text/html; charset=ISO-8859-1');
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Blevers.css">
        <title>BiblioTech | Home</title>
            <link rel="icon" type="image/png" href="icon.png"/>
        <script type="text/javascript" src="jquery-3.2.1.js"></script>
    </head>
    <body>
        <?php
            include_once('menublevers.inc.php');
            
            if (isset($_SESSION['busca']))
                echo "<script>$('input[name=busca]').val('".$_SESSION['busca']."')</script>";
            else
                echo "<script>$('input[name=busca]').val('')</script>";
            
            $aux = $_SESSION['nomeUsuario'];
            echo "<div id='nice'>";
            echo "<h1 class='bv'>Bem vindo, $aux</h1>";
            echo "</div>"
        ?>
        <div id="alto-baixo"></div>
        <div id="meio-alto-baixo">
            <h2 class="subtitulo">O que &eacute;?</h2> 
            <p class="texto">
                A BiblioTech, feita por estudantes, para estudantes. Aqui voc&ecirc; poder&aacute; encontrar e publicar exerc&iacute;cios, materiais e outros conte&uacute;dos que procurar, sobre os mais variados assuntos.
            </p>
            <p class="texto">
                Todos os materiais neste site foram enviados por alunos. Lembre-se: qualquer um pode disponibilizar materiais aqui, ent&atilde;o voc&ecirc; tamb&ecirc;m pode contribuir!
            </p>
        </div>
        <div id="filler2"></div>
        <div id="meio">
            <h2 class="subtitulo">Comece a buscar</h2>
            <p class="texto">
                Para encontrar materiais e exerc&iacute;cios, clique em "Categorias" no menu acima e navegue, ou busque algo na barra de busca. 
            </p>
            <p class="texto">
                Para fazer upload de arquivos clique em "Perfil".
            </p>
        </div>
        <div id="regras">
            <h1 class="subtitulo">Regras e Condi&ccedil;&otilde;es</h1>
            <p class="texto">Ao utilizar nossos servi&ccedil;os, voc&ecirc; concorda com as seguintes condi&ccedil;&otilde;es:</p>
            <ul>
                <li>N&atilde;o poste pornografia e conte&uacute;dos impr&oacute;prios para o ambiente escolar</li>
                <li>Respeitar os outros usu&aacute;rios</li>
                <li>A BiblioTech n&atilde;o se rensponsabiliza pelos conte&uacute;dos postados por seus usu&aacute;rios</li>
            </ul>
        </div>
        <div id="autores">
            <h1 class="subtitulo">Autores</h1>
            <p class="texto">Eduardo Porto</p>
            <p class="texto">Jo&atilde;o Henri</p>
            <p class="texto">F&aacute;bio Fa&uacute;ndes</p>
        </div>
        <?php
            include_once('pehblevers.inc.php');
        ?>
    </body>
</html> 