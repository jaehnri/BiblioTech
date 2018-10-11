<?php

    include_once 'Classes/conexao.class.php';

?>
        
<form method="post" action="upload.php" id="excluir" enctype="multipart/form-data">
    <input type="submit" name="btnCancelar" id="cancelar" value="X" style="background-color: #fa7242;">
    <h1>Upload</h1>
    <hr class="hrEstiloso" id="forms">
    <input type="file" id="fileUpload" name="fileUpload">
    <?php

        $obj_con = new Conexao();

        $filtro = "";
        $tipo = "";

        $categorias = $obj_con->selectCategoria($tipo, $filtro);

        echo "<select name='codCategoria'>";
        foreach($categorias as $i)
            echo "<option value='".$i['codCategoria']."'>".$i['nome']."</option>";

        echo "</select>";
        
    ?>
    <br>
    <input type="text" name="nomeMaterial" placeholder="Nome Material">
    <textarea name="descricaoMaterial" placeholder="Descri&ccedil;&atilde;o..." form="excluir"></textarea>
    <input type="submit" value="Upload" name="btnUpload" id="btnUpload">
</form>