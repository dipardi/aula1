<?php
session_start();

// Se já estiver logado, pode redirecionar, se quiser
if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
    // header("Location: area_restrita.php");
    // exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Vagas</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- ADICIONAR -->
</head>
<body>
    <div class="container"> <!-- ADICIONAR -->
    <h1>Login</h1>

    <?php
    // Mensagens de erro simples vindo por GET (opcional)
    if (isset($_GET["erro"])) {
        if ($_GET["erro"] == 0) {
            echo "<p style='color:red;'>E-mail não cadastrado.</p>";
        } elseif ($_GET["erro"] == 1) {
            echo "<p style='color:red;'>Senha incorreta.</p>";
        } elseif ($_GET["erro"] == 2) {
            echo "<p style='color:red;'>Você precisa estar logado para acessar essa página.</p>";
        }
    }
    ?>

    <?php
if (isset($_GET["msg"]) && $_GET["msg"] === "cadastrado") {
    echo "<p style='color:green;'>Cadastro realizado com sucesso! Faça login.</p>";
}
?>


    <form action="loginOk.php" method="post">
        <label for="email">E-mail:</label><br>
        <input type="email" name="email" id="email" required><br><br>

        <label for="senha">Senha:</label><br>
        <input type="password" name="senha" id="senha" required><br><br>

        <button type="submit">Entrar</button>
    </form>
    </div> <!-- ADICIONAR -->
</body>
</html>
