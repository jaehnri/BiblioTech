<?php

    include_once 'Classes/conexao.class.php';

?>
<form id="excluir" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <input type="submit" name="btnCancelar" id='cancelar'value="X" style="background-color: #fa7242;">
    <h1 class='tituloformsEdicao'>Edi&ccedil;&atilde;o</h1>
    <hr class="hrEstiloso" id="forms">
    <?php
        
        if (!isset($_POST['btnBuscarEdit']))
        {
    ?>
        <label>Material a ser editado:</label>
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
                echo "<option>Voc&ecirc n&atilde;o tem nenhum material :c</option>"
        
        ?>
    </select>
        <input type="submit" name="btnBuscarEdit" value="Buscar">
    <?php
            
        }
        if (isset($_POST['btnBuscarEdit']))
        {            
            $_SESSION['material'] = $_POST['codMaterial'];
            
    ?>
    <label>Nome:</label>
    <input type="text" placeholder="Nome da Material..." name="novoNome">
    <select name="novaCategoria">
        <?php
            $tipo = '';
            $filtro = '';
            $categorias = $obj_con->selectCategoria($tipo, $filtro);
            
            if (!empty($categorias))
            foreach($categorias as $i)
                echo "<option value='".$i['codCategoria']."'>".$i['nome']."</option>";
        
        ?>
    </select>
    <input type="submit" name="btnAlterar" value="Alterar">
    <?php
        }
        if (isset($_POST['btnAlterar']))
        {
            $obj_con = new Conexao();
            
            $cod = $_SESSION['material'];
            
            $obj_con->updateMaterial($cod, $_POST['novoNome'], $_POST['novaCategoria']);
            
            echo "<br><label style='font-size: 24px;margin-top:10px;'>Altera&ccedil;&atilde;o efetuada com sucesso</label>";
        }
    ?>
</form>