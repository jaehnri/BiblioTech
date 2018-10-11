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
        <label>Categoria a ser editada:</label><br>
        <input type="text" name="nomeCategoria" placeholder="Nome da categoria...">
        <input type="submit" name="btnBuscarEdit" value="Buscar">
    <?php
            
        }
        if (isset($_POST['btnBuscarEdit']))
        {
            $obj_con = new Conexao();
            $categoria = $obj_con->selectCategoriaNome($_POST['nomeCategoria']);
            
            if (!empty($categoria))
            foreach($categoria as $i)
                $_SESSION['categoria'] = $i['codCategoria'];
            
            if (!empty($_SESSION['categoria']))
            {
    ?>
    <label>Nome:</label><br>
    <input type="text" placeholder="Nome da Categoria..." name="novoNome">

    <select name="novoTipo">
        <?php
                
            $tipos = $obj_con->selectTipo();
            
            if (!empty($tipos))
            foreach($tipos as $i)
                echo "<option value='".$i['codTipo']."'>".$i['nome']."</option>";
        
        ?>
    </select>
    <input type="submit" name="btnAlterar" value="Alterar">
    <?php
            
        } else {
        
    ?>
    <label>Nenhuma Categoria com esse nome encontrada :c</label>
    <?php
        }}
        if (isset($_POST['btnAlterar']))
        {
            $obj_con = new Conexao();
            
            $cod = $_SESSION['categoria'];
            
            $obj_con->updateCategoria($cod, $_POST['novoNome'], $_POST['novoTipo']);
            
            echo "<br><label style='font-size: 24px;margin-top:10px;'>Altera&ccedil;&atilde;o efetuada com sucesso</label>";
        }
    ?>
</form>