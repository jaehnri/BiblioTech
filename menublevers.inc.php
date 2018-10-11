<link rel="icon" type="image/png" href="icon.png"/>
<ul class="menu">
    <a href="Home.php"><li>Home</li></a>
    <a href="Categorias.php?Filtro=A-Z&Tipo=1&filtrar=Filtrar"><li>Categorias</li></a>  
    <li id="liZuado"><form action="menublevers.inc.php" method="post" name="btnbuscar">
            <input type="text" name="busca" id="buscar">
            <input type="submit" name="btnBuscar" value="Buscar">
        </form>
    </li>
    <a href="perfil.php"><li>Perfil</li></a>
    <a href="logoff.php" id="logoff"><li>Log Off</li></a>
</ul>
<?php

    if(isset($_POST['btnBuscar']))
    {
        $busca = $_POST['busca'];
        $link = "Materiais.php?Busca=$busca";
        header("Location:$link");  
    }

?>