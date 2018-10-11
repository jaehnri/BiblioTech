<form class="Login" action="validarAcesso.php" method="post">
    <h1>Login</h1>
    <hr style="border: solid black thin">
    <?php
        if (isset($_GET['entrou'])) {
                    if($_GET['entrou'] == 'NOK') {
                        echo "<p style='color: white; text-decoration: underline;text-shadow: 2px 2px black;'>Usuário ou Senha Incorreta</p>";
                    }
                }
    ?>
    <ul>
        <li>
            <label>Usuário:</label>
        </li>
        <li>
            <input type="text" name="username" maxlength="25"
            autocomplete="on" autofocus required>
       </li>
        <li>
            <label>Senha:</label>
        </li>
        <li>
            <input type="password" name="senha" required maxlength="64">
        </li>
        <li>
            <input type="submit" id="Enviar" name="enviar" value="Entrar">
        </li>
    </ul>
    <hr style="border: solid black thin">
    <p>Não possui uma conta ainda?</p>
    <p>Clique <a onclick="trocar(false)">aqui</a></p>
</form>