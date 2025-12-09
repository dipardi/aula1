<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: Login.php?erro=2");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Área do Usuário</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- ADICIONAR -->
</head>
<body>
<div class="container"> <!-- ADICIONAR -->

    <h1>Bem-vindo, <?= htmlspecialchars($_SESSION["nome"]) ?>!</h1>

    <p>Você está logado no sistema.</p>

    <h2>Área do Usuário</h2>
    <ul>
        <li><a href="../usuario/vagas.php">Ver vagas disponíveis</a></li>
        <!-- depois podemos criar "Minhas candidaturas" aqui -->
    </ul>

    <hr>

    <!-- Esses links aqui embaixo são só pra você testar o ADM por enquanto -->
    <h3>(Somente para testes / professor)</h3>
    <ul>
        <li><a href="../admin/vagas_cadastrar.php">Área do Admin - Vagas</a></li>
        <li><a href="../admin/categorias.php">Área do Admin - Categorias</a></li>
        <li><a href="../usuario/listar.php">Listar usuários (teste)</a></li>
    </ul>

    <p><a href="logout.php">Sair</a></p>
    <!-- resto do conteúdo da home -->
</div> <!-- ADICIONAR -->
</body>
</html>

