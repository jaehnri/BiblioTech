<?php

    include_once 'Classes/conexao.class.php';

?>

<form id="excluir" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <input type="submit" name="btnCancelar" id="cancelar" value="X" style="background-color: #fa7242;">
    <h1 class="tituloFormsEdicao">Exclus&atilde;o</h1>
    <hr class="hrEstiloso" id="forms">
    <label>Nome:</label><br>
    <input type="text" name="nomeCategoria" placeholder="Nome da Categoria...">
    <input type="submit" name="btnExclusao" value="Excluir">
<?php

    if (isset($_POST['btnExclusao']))
    {
        $obj_con = new Conexao();
        
        $categoria = $obj_con->selectCategoriaNome($_POST['nomeCategoria']);
        
        if (!empty($categoria))
        {
            $obj_con->deleteCategoria($_POST['nomeCategoria']);
            echo "<br><label>Categoria exclu&iacute;da com sucesso!</label>";
        }
        else
            echo "<br><label>Erro: Categoria n&atilde;o existe :c</label>";
    }
?>
</form>