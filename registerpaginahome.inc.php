<form class="Register" method="post" action="cadastrar.php">
    <h1>Registre-se</h1>
    <hr style="border: solid black thin">
    <?php
        if (isset($_GET['erroCadastro'])) {
                    if($_GET['erroCadastro'] == 'camposNaoPreenchidosCorretamente') {
                        echo "<p style='color: white; text-decoration: underline;text-shadow: 2px 2px black;'>Por favor, preencha todos os campos corretamente.</p><br>";
                        echo "<script>window.onload = function () {trocar(false);}</script>";
                    }
                    if($_GET['erroCadastro'] == 'senhasNaoCorrespondem') {
                        echo "<p style='color: white; text-decoration: underline;text-shadow: 2px 2px black;'>As senhas não correspondem!</p><br>";
                        echo "<script>window.onload = function () {trocar(false);}</script>";
                    }
                    if($_GET['erroCadastro'] == 'emailInvalido') {
                        echo "<p style='color: white; text-decoration: underline;text-shadow: 2px 2px black;'>O email inserido é inválido.</p><br>";
                        echo "<script>window.onload = function () {trocar(false);}</script>";
                    }
                    if($_GET['erroCadastro'] == 'senhaFraca') {
                        echo "<p style='color: white; text-decoration: underline;text-shadow: 2px 2px black;'>A senha inserida é muito fraca.<br>Tenha certeza de que ela tem letras maiúsculas e números.</p><br>";
                        echo "<script>window.onload = function () {trocar(false);}</script>";
                    }
                }
    ?>
    <ul>
        <li>
            <label>Nome Usuário:</label>
            <input type="text" autofocus required maxlength="25" name="username">
        </li>
        <li>
            <label>E-mail:</label>
            <input type="text" required maxlength="64" name="email">
        </li>
        <li>
            <label>Nome Completo:</label>
            <input type="text" required maxlength="100" name="nome">
        </li>
        <li>
            <label>Senha:</label>
            <input type="password" required maxlength="64" name="senha">
        </li>
        <li>
            <label>Confirmar Senha:</label>
            <input type="password" required maxlength="64" name="confirmarSenha">
        </li>
        <li>
            <input type="submit" id="enviar" name="cadastrar" value="Cadastrar">
        </li>
    </ul>
    
    <hr style="border: solid black thin">
    <p>Já possui uma conta?</p>
    <p>Clique <a onclick="trocar(true)">aqui</a></p>
</form>