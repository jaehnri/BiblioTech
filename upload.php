<?php
    session_start();

    include_once 'Classes/conexao.class.php';

    if(!isset($_SESSION['codUsuario'])){
        //die("Clique <a href='Index.php'>aqui</a> para fazer login");
        header('Location:Index.php');
    }

    if(!isset($_FILES["fileUpload"]["size"]))
    {
    	header('Location:Materiais.php');
    }



    if(isset($_POST["btnUpload"])) {
    	$nomeDoMaterial = $_POST["nomeMaterial"];
    	$descricaoDoMaterial = $_POST["descricaoMaterial"];
        
        if(isset($_POST['codCategoria']))
            $aux = $_POST['codCategoria'];
        else
            $aux = $_SESSION['categoria'];
        
        $target_dir = "uploads/$aux";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_dir.='/';

        $target_file = $target_dir . basename($_FILES["fileUpload"]["name"]);
        $uploadOk = 1;
        if ($_FILES["fileUpload"]["size"] > 5000000) {
            header("Location:perfil.php?erroEnvioArquivo=arquivoGrande");
            $uploadOk = 0;
        }

        $allowed =  array('png','pdf','jpg', 'jpeg');
        $filename = $_FILES['fileUpload']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array($ext,$allowed) ) {
        	header("Location:perfil.php?erroEnvioArquivo=extensaoNaoPermitida");
            //echo 'Extensão de arquivo não permitida. Envie apenas arquivos pdf, png e jpg.';
            $uploadOk = 0;
        }
    

	    if (file_exists($target_file)) {
	        //echo "Este arquivo ja existe!.";
	        header("Location:perfil.php?erroEnvioArquivo=arquivoJaExiste");
	        $uploadOk = 0;
	    }
	        
	    if ($uploadOk != 0) {
	        if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {
	        	$obj_con = new Conexao();
	        	$obj_con->insertMaterial($nomeDoMaterial, $target_file,
	        							 $_SESSION['codUsuario'], $aux, $descricaoDoMaterial);

	            header("Location:perfil.php?sucessoEnvioArquivo=true");
	        } else {
	        	header("Location:perfil.php?erroEnvioArquivo=erro");
	            //echo "Desculpe, ouve um erro ";
	        }
	    }
	}
    
    if(isset($_POST['btnCancelar']))
    {
        unset($_SESSION['btnAdicionar']);
        header ('Location:perfil.php');
    } 
?>