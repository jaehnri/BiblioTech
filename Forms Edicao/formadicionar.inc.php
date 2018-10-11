<?php

    include_once 'Classes/conexao.class.php';

?>

<form id="excluir" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <input type="submit" name="btnCancelar" id="cancelar" value="X" style="background-color: #fa7242;">
    <h1 class="tituloFormsEdicao">Adi&ccedil;&atilde;o</h1>
    <hr class="hrEstiloso" id="forms">
    <label>Nome:</label><br>
    <input type="text" name="nomeCategoria" placeholder="Nome da Categoria...">
    <select name="tipo">
    <?php
    
        $obj_con = new Conexao();
    
        $tipos = $obj_con->selectTipo();
        
        if(!empty($tipos))
            foreach ($tipos as $i)
                echo "<option value='".$i['codTipo']."'>".$i['nome']."</option>";
    
    ?>
    </select>
    <input type="submit" name="btnAdicao" value="Adicionar">
<?php

    if (isset($_POST['btnAdicao']))
    {
        $obj_con = new Conexao();
        
        $categoria = $obj_con->selectCategoriaNome($_POST['nomeCategoria']);
        
        if (empty($categoria))
        {
            $obj_con->insertCategoria($_POST['nomeCategoria'], $_POST['tipo']);
            echo "<br><label>Categoria adicionada com sucesso!</label>";
        }
        else
            echo "<br><label>Erro: Categoria j&aacute; existe :c</label>";
    }
?>
</form>