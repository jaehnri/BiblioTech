<ul class="menuForum">
    <a href="Blevers.php"><li>Home</li></a>
    <a href="Categorias.php?Filtro=A-Z&Tipo=1&filtrar=Filtrar"><li>Categorias</li></a>  
    <a href="Forum.php"><li>F&oacute;rum</li></a>
    <li id="liZuado"><form action="menublevers.inc.php" method="post" name="btnbuscar" value="Ir">
            <input type="text" name="busca" id="buscar">
            <input type="submit" name="btnBuscar" value="Buscar">
        </form>
    </li>
    <a href="perfil.php"><li>Perfil</li></a>
    <li><a href="logoff.php" id="logoff">Log Off</a></li>
</ul>
<?php

    if(isset($_POST['btnBuscar']))
    {
        $busca = $_POST['busca'];
        $link = "Materiais.php?Busca=$busca";
        header("Location:$link");  
    }

?>