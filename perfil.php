<?php

    session_start();

    if(!isset($_SESSION['codUsuario']))
        header('Location:Index.php');

    include ('Classes/conexao.class.php');

    header('Content-Type: text/html; charset=ISO-8859-1');

?>

<html>
    <head>
        <title>BiblioTech | Usu&aacute;rio</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="Blevers.css">
            <link rel="icon" type="image/png" href="icon.png"/>
        <script src="jquery-3.2.1.js" ></script>
    </head>
    <body>
        <?php include("menublevers.inc.php") ?>
        <div id="filler"></div>
        <h1 id="PerfilTitle">Seus Materiais</h1>
        <hr class='hrEstiloso'>
        <div class="materiais">
            <ul class="material" >
                <li style="background-color: #fa7242;" class="headerMateriais">Nome Material</li>
                <li style="background-color: #fa7242;" class="headerMateriais">Data de Envio</li>
                <li style="background-color: #fa7242;" class="headerMateriais">Categoria</li>
            </ul>
            <?php

                $obj_con = new Conexao();

                $materiais = $obj_con->selectMaterialUsuario($_SESSION['codUsuario']);
                
                if (!empty($materiais))
                foreach ($materiais as $i)
                {
                    $codMaterial = $i['codMaterial'];
                    $nomeMaterial = $i['nomeMaterial'];
                    $nomeCategoria = $i['nome'];
                    $local = $i['localizacaoDoArquivo'];
                    $data = date_format($i['data'], "Y/m/d H:i:s");
                    echo "<a href='$local'>";
                    echo "<ul class='material'>";
                    echo    "<li>$nomeMaterial</li>";
                    echo    "<li>$data</li>";
                    echo    "<li>$nomeCategoria</li>";
                    echo "</ul>";
                    echo "</a>";
                }
                else
                    echo "<p id='noResult'>Nenhum resultado encontrado :c</p>";
            ?>
        </div>
        <center>
            <form id="acessoADMCategorias" action="perfil.php" method="post">
                <input class="btnPadrao" type="submit" name="btnEditar" value="Editar">
                <input class="btnPadrao" type="submit" name="btnExcluir" value="Excluir">
                <input class="btnPadrao" type="submit" name="btnAdicionar" value="Adicionar">
            </form>
        </center>
        <div class="edits" id="edicao1">
            <?php
            if (isset($_POST['btnCancelar']))
            {
                if (isset($_SESSION['btnEditar']))
                    unset($_SESSION['btnEditar']);

                if (isset($_SESSION['material']))
                    unset($_SESSION['material']);

                if (isset($_SESSION['btnExcluir']))
                    unset($_SESSION['btnExcluir']);
                
                if (isset($_SESSION['btnAdicionar']))
                    unset($_SESSION['btnAdicionar']);
                
                if (isset($_SESSION['btnExclurDeTodos']))
                    unset($_SESSION['btnExclurDeTodos']);

                echo "<script>$('#edicao1').fadeOut(100);</script>";
                echo "<script>$('#edicao2').fadeOut(100);</script>";
            }
        
            if (isset($_POST['btnEditar']) || isset($_SESSION['btnEditar']))
            {
                if (isset($_POST['btnEditar']))
                    $_SESSION['btnEditar'] = $_POST['btnEditar'];

                include_once 'Forms Edicao/formeditarMaterial.inc.php';
                echo "<script>$('#edicao1').fadeIn(100);</script>";
            }

            if (isset($_POST['btnExcluir']) || isset($_SESSION['btnExcluir']))
            {
                if (isset($_POST['btnExcluir']))
                    $_SESSION['btnExcluir'] = $_POST['btnExcluir'];

                include_once 'Forms Edicao/formexcluirMaterial.inc.php';
                echo "<script>$('#edicao1').fadeIn(100);</script>";
            }
            
            if (isset($_POST['btnAdicionar']) || isset($_SESSION['btnAdicionar']))
            {
                if (isset($_POST['btnAdicionar']))
                    $_SESSION['btnAdicionar'] = $_POST['btnAdicionar'];
                
                include_once 'Forms Edicao/formadicionarMateriais.inc.php';
                echo "<script>$('#edicao1').fadeIn(100);</script>";
            }
        ?>
        </div>
        <?php
        
            if ($_SESSION['acessoAdm'] == 1)
            {
                echo "<hr class='hrEstiloso'>";
                echo "<h1 style='font-family: Font-Menu; text-align: center; font-size: 36px;'>Todos os Materiais</h1>";
                echo "<hr class='hrEstiloso'>";
                
                $busca = "";
                $filtro = "A-Z";
                $categoria = "";
                
                $materiais = $obj_con->selectMaterial($busca, $categoria, $filtro);
                
                echo "<div class='materiais'>";
                echo "<ul class='material'>";
                echo    "<li style='background-color: #fa7242;' class='headerMateriais'>Nome</li>";
                echo    "<li style='background-color: #fa7242;' class='headerMateriais'>Data</li>";
                echo    "<li style='background-color: #fa7242;' class='headerMateriais'>Autor</li>";
                echo "</ul>";
                if (!empty($materiais))
                foreach ($materiais as $i)
                {
                    $nomeMaterial = $i['nomeMaterial'];
                    $locArquivo   = $i['localizacaoDoArquivo'];
                    $data = date_format($i['data'], "Y/m/d H:i:s");
                    $nomeUsuario = $i['nomeUsuario'];
                    echo "<a href='$locArquivo'>";
                    echo "<ul class='material'>";
                    echo    "<li>$nomeMaterial</li>";
                    echo    "<li>$data</li>";
                    echo    "<li>$nomeUsuario</li>";
                    echo "</ul>";
                    echo "</a>";
                }
                else
                    echo "<p>Nenhum resultado encontrado :c</p>";
                echo "</div>";
                echo "<center>
            <form id='acessoADMCategorias' action='perfil.php' method='post'>
                <input class='btnPadrao' type='submit' name='btnExcluirDeTodos' value='Excluir'>
            </form>";
                
                echo "<div class='edits' id='edicao2'>";
                
                if (isset($_POST['btnExcluirDeTodos']) || isset($_SESSION['btnExcluirDeTodos']))
                {
                    if (isset($_POST['btnExcluirDeTodos']))
                        $_SESSION['btnExcluirDeTodos'] = $_POST['btnExcluirDeTodos'];
                    
                    include_once 'Forms Edicao/formexcluirDeTodos.inc.php';
                    echo "<script>$('#edicao2').fadeIn(100);</script>";
                    
                }
                
                echo "</div>";
            }
        
        ?>
    </body>    
</html>