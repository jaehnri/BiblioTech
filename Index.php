<?php
    session_start();

    if(isset($_SESSION['codUsuario']))
        header('Location:Home.php');

?>
<html>
    <link rel="icon" type="image/png" href="icon.png"/>
    <head>
        <meta charset="utf-8">
        <title>BiblioTech</title>
        <link rel="stylesheet" style="text/css" href="Bibs.css">
        <script src="jquery-3.2.1.js"></script>
        <script type="text/javascript">
            
            
            <?php
                if (!isset($_GET['erroCadastro'])) {
            ?>
            $(document).ready(function(){
                $(".Register").hide();
            })
            <?php
                }
            ?>
            
                
            function trocar(n){
                if(n == true){
                    $(".Login").fadeIn(600);
                    $(".Register").fadeOut(600);  
                }
                else{
                    $(".Login").fadeOut(600);
                    $(".Register").css({"visibility":"visible"});
                    $(".Register").fadeIn(600);
                }                                        
            }
        </script>
    </head>
    <body>
        <h1 id="BemVindo">Bem vindo à BiblioTech</h1>
        <h2 id="LinhaFina">Somos sua biblioteca virtual acadêmica</h2>
        <?php    
            require_once("loginpaginahome.inc.php");
            require_once("registerpaginahome.inc.php");        
        ?>
    </body>
</html>