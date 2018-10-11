<?php
    
    session_start();
    
    if(!isset($_SESSION['codUsuario']))
        header('Location:Index.php');

    include_once 'Classes/conexao.class.php';

    header('Content-Type: text/html; charset=ISO-8859-1');

?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Blevers.css">
        <link rel="stylesheet" type="text/css" href="Categorias.css">
            <link rel="icon" type="image/png" href="icon.png"/>
        <meta charset="utf-8">
        <script type="text/javascript" src="jquery-3.2.1.js"></script>
        <title>BiblioTech | Categorias</title>
    </head>
    <body>
        <?php
        
            include_once("menublevers.inc.php");
            if (isset($_SESSION['busca']))
                echo "<script>$('input[name=busca]').val('".$_SESSION['busca']."')</script>";
            else
                echo "<script>$('input[name=busca]').val('')</script>";
        ?>
        <div id="filler"></div>
        <h1 style="text-align:center; font-family: Font-Menu; font-size: 36px;">Categorias</h1>
        <hr class="hrEstiloso">
        <center>
        <div class="selecoes">
        <form action="Categorias.php" method="get">
            <label>Ordem:</label>
            <select id="filtro" name='Filtro'>
                <option value="A-Z">A-Z</option>
                <option value="Z-A">Z-A</option>
            </select>
            
            <label>Tipo:</label>
            <select id="tipo" name="Tipo">
                <option value="1">M&eacute;dio</option>
                <option value="2">Inform&aacute;tica</option>
            </select>
            <input type="submit" name="filtrar" value="Filtrar">
        </form>
        </div>
        </center>
        <div class='categoria'>
            <ul id="headerCategoria">
                <li>Nome da Categoria</li>
            </ul>
        
        <?php
            
            if(isset($_GET['filtrar']))
            {
                
                switch ($_GET['Filtro'])
                {
                    case 'A-Z': $filtro = "";       break;
                    case 'Z-A': $filtro = "Desc";   break;
                    default   : $filtro = "";       break;
                }
                
                $tipo = ($_GET['Tipo']);
                
                $obj_con = new Conexao();
    
                $categorias = $obj_con->selectCategoria($tipo, $filtro);
                
                if(!empty($categorias))
                {
                    foreach($categorias as $i)
                    {
                        echo "<ul>";
                        echo    "<a class='aPadrao' href='Materiais.php?Categoria=".$i['codCategoria']."'>";
                        echo    "<li>".$i['nome']."</li>";
                        echo    "</a>";
                        echo "</ul>";                
                    }
                    
                }
                else
                    echo "<p id='noResult'>Nenhum resultado encontrado :c</p>";
                
                echo "<script>$('#filtro').val('".$_GET['Filtro']."')</script>";
                echo "<script>$('#tipo').val('".$_GET['Tipo']."')</script>";
            }
            
        ?>
        </div>
        <?php
        
            if ($_SESSION['acessoAdm'] == 1)
            {
                echo "<center>";
                echo "<form id='acessoAdmCategorias' method='post' action='Categorias.php'>";
                echo    "<input class='btnPadrao' type='submit' name='btnEditar'    id='btnEditar'    value='Editar'>";
                echo    "<input class='btnPadrao' type='submit' name='btnExcluir'   id='btnExcluir'   value='Excluir'>";
                echo    "<input class='btnPadrao' type='submit' name='btnAdicionar' id='btnAdicionar' value='Adicionar'>";
                echo "</form>";
                echo "</center>";
            }            
        
        ?>
        <div class="edits">
            <?php
                if (isset($_POST['btnCancelar']))
                {
                    if (isset($_SESSION['btnEditar']))
                        unset($_SESSION['btnEditar']);
                    
                    if (isset($_SESSION['categoria']))
                        unset($_SESSION['categoria']);
                    
                    if (isset($_SESSION['btnExcluir']))
                        unset($_SESSION['btnExcluir']);
                    
                    if (isset($_SESSION['btnAdicionar']))
                        unset($_SESSION['btnAdicionar']);
                    
                    echo "<script>$('.edits').fadeOut(100)</script>";
                }
            
                if (isset($_POST['btnEditar']) || isset($_SESSION['btnEditar']))
                {
                    if (isset($_POST['btnEditar']))
                        $_SESSION['btnEditar'] = $_POST['btnEditar'];
            
                    include_once 'Forms Edicao/formeditar.inc.php';
                    echo "<script>$('.edits').fadeIn(100);</script>";
                }
            
                if (isset($_POST['btnExcluir']) || isset($_SESSION['btnExcluir']))
                {
                    if (isset($_POST['btnExcluir']))
                        $_SESSION['btnExcluir'] = $_POST['btnExcluir'];
                    
                    include_once 'Forms Edicao/formexcluir.inc.php';
                    echo "<script>$('.edits').fadeIn(100);</script>";
                }
            
                if (isset($_POST['btnAdicionar']) || isset($_SESSION['btnAdicionar']))
                {
                    if (isset($_POST['btnAdicionar']))
                        $_SESSION['btnAdicionar'] = $_POST['btnAdicionar'];
                    
                    include_once 'Forms Edicao/formadicionar.inc.php';
                    echo "<script>$('.edits').fadeIn(100);</script>";
                }
                
            ?>   
        </div>
    </body>
</html>
    