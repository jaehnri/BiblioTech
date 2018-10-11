<?php

    include_once 'Classes/conexao.class.php';

?>

<form id="excluir" method="post" action="delete.php">
    <input type="submit" name="btnCancelar" id="cancelar" value="X" style="background-color: #fa7242;">
    <h1 class="tituloFormsEdicao">Exclus&atilde;o</h1>
    <hr class="hrEstiloso" id="forms">
    <select name="codMaterial">
        <?php
        
            $obj_con = new Conexao();
        
            $materiais = $obj_con->selectMaterialUsuario($_SESSION['codUsuario']);
        
            if (!empty($materiais))
                foreach ($materiais as $i)
                {
                    $nomeMaterial = $i['nomeMaterial'];
                    $codMaterial = $i['codMaterial'];
                    
                    //Criará uma option para cada material do usuário
                    echo "<option value='$codMaterial'>$nomeMaterial</option>";
                }
            else
                echo "<option value=''>Voc&ecirc n&atilde;o tem nenhum material :c</option>"
        
        ?>
    </select>
    <input type="submit" name="btnExclusao" value="Excluir">
<?php

    /*if (isset($_POST['btnExclusao']))
    {
        $obj_con = new Conexao();
        
        $material = $obj_con->selectMaterialCod($_POST['codMaterial']);
        
        if (!empty($material))
        {
            $obj_con->deleteMaterial($_POST['codMaterial']);
            echo "<br><label>Material exclu&iacute;da com sucesso!</label>";
        }
        else
            echo "<br><label>Erro: Material n&atilde;o existe :c</label>";
    }*/
?>
</form>