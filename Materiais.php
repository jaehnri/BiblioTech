<?php

    session_start();
    if(!isset($_SESSION['codUsuario']))
        header('Location:Index.php');

    include_once 'Classes/conexao.class.php';

    header('Content-Type: text/html; charset=ISO-8859-1');

    if(isset($_GET['btnReset']))
    {
        unset ($_SESSION['busca']);
        unset ($_SESSION['ordem']);
        unset ($_SESSION['CodCategoria']);
    }   

    //Dá um valor para a variável caso ela não exista ainda
    if(!isset($_SESSION['CodCategoria']))
        $_SESSION['CodCategoria']  = "";
    
    //Dá um valor para a variável caso ela não exista ainda
    if(!isset($_SESSION['busca']))
        $_SESSION['busca']      = "";

    //Dá um valor para a variável caso ela não exista ainda
    if(!isset($_SESSION['ordem']))
        $_SESSION['ordem']      = "";

    //Pega o valor das variaveis $_GET, ou não
    if(isset($_GET['Categoria']))
        $_SESSION['CodCategoria'] = $_GET['Categoria'];
    else
        if($_SESSION['categoria'] == "")
            $_SESSION['categoria'] = "";

    //Pega o valor das variaveis $_GET, ou não
    if(isset($_GET['Busca']))
        $_SESSION['busca'] = $_GET['Busca'];
    else
        if($_SESSION['busca'] == "")
            $_SESSION['busca'] = "";

    //Pega o valor das variaveis $_GET, ou não
    if(isset($_GET['Ordem']))
        $_SESSION['ordem'] = $_GET['Ordem'];
    else
        if($_SESSION['ordem'] == "")
            $_SESSION['ordem'] = '';
?>
<html>
    <head>
        <title>BiblioTech | Materiais</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="Blevers.css">
        <link rel="stylesheet" type="text/css" href="Categorias.css">
        <link rel="icon" type="image/png" href="icon.png"/>
        <script src="jquery-3.2.1.js"></script>
    </head>
    <body>
        <?php
            include_once ('menublevers.inc.php');
            if (isset($_SESSION['busca']))
                echo "<script>$('input[name=busca]').val('".$_SESSION['busca']."')</script>";
            else
                echo "<script>$('input[name=busca]').val('')</script>";
        ?>
        <div id="filler"></div>
        <center>
            <h1 style="font-family: Font-Menu; font-size: 36px">Materiais</h1>
            <hr class="hrEstiloso">
            <div class="selecoes">                
                <p>Fa&ccedil;a uploads de arquivos <a href="perfil.php">aqui</a></p>
            <form action="Materiais.php" method="get" id="filtros">
                <label>Categoria atual:</label>
                <input id="catAtual" type="text" value="" readonly>
                <?php
                
                    if ($_SESSION['CodCategoria'] != "")
                    {                    
                        $obj_con = new Conexao();

                        $filtro = "";
                        $tipo = "";

                        $categorias = $obj_con->selectCategoriaCod($_SESSION['CodCategoria']);

                        if (!empty($categorias))
                            foreach($categorias as $i)
                                echo "<script>$('#catAtual').val('".$i['nome']."');</script>";
                    }
                
                ?>
                <label>Ordem:</label>
                <select id="ordem" name="Ordem">
                    <option value="A-Z">A-Z</option>
                    <option value="Z-A">Z-A</option>
                    <option value="maisRecente">Data + Recente</option>
                    <option value="menosRecente">Data - Recente</option>
                </select>
                <input type="submit" name="btnFiltrar" value="Filtrar">
                <input type="submit" name="btnReset" value="Reset"> 
            </form>
            </div>
        </center>
        <div class="materiais">
            <ul class="material">
                <li style="background-color: #fa7242;" class="headerMateriais">Nome</li>
                <li style="background-color: #fa7242;" class="headerMateriais">Data</li>
                <li style="background-color: #fa7242;" class="headerMateriais">Nome do Autor</li>
            </ul>
            <?php
                
                    $busca = $_SESSION['busca'];
                    $categoria = $_SESSION['CodCategoria'];
                    $filtro = $_SESSION['ordem'];

                    $obj_con = new Conexao();

                    $materiais = $obj_con->selectMaterial($busca, $categoria, $filtro);

                    if(!empty($materiais))
                    {
                        foreach($materiais as $i)
                        {
                            $codMaterial = $i['codMaterial'];
                            $descricao = $i['descricao'];
                            $data = date_format($i['data'], "Y/m/d H:i:s");
                            //$function = "\"dropar('descricao$codMaterial');\"";
                            //$function2 = "\"voltar('descricao$codMaterial');\"";
                            //echo "<div onmouseover=$function style='{padding:0;margin:0;}'>";
                            $locArquivo = $i['localizacaoDoArquivo'];
                            echo "<a href='$locArquivo'><ul class='material'>";
                            echo    "<li>".$i['nomeMaterial']."</li>";
                            echo    "<li>$data</li>";
                            echo    "<li>".$i['nomeUsuario']."</li>";
                            echo "</ul>";
                            echo "</a>";
                            echo "<div style='display: block;' id='descricao$codMaterial' class='dropdown'>$descricao</div>";
                            echo "<hr class='hrEstiloso' id='hrMateriais'>";
                            //echo "</div>";
                        }
                        
                    }
                    echo "<script>$('#ordem').val('".$_SESSION['ordem']."');</script>";            
            ?>
        </div>
            <?php
                if (empty($materiais))
                    echo "<p id='noResult'>Nenhum resultado encontrado :c</p>";
        
                //Teoricamente muda o tamanho do form para ficar mais bonitinho
                if (!$_SESSION['CodCategoria'] == "")
                {
                    echo "<script>$('#upload').width('500px');</script>";
                }
            ?>
    </body>
</html>
















