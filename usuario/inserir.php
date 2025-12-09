<?php
// cadastro do USUÁRIO COMUM (CANDIDATO)
// não precisa estar logado pra acessar

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- ADICIONAR -->
</head>
<body>
<div class="container"> <!-- ADICIONAR -->

    <h1>Cadastro de Usuário</h1>

    <form method="post" action="inserirOK.php" enctype="multipart/form-data">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>E-mail:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>

        <label>Imagem (foto do usuário):</label><br>
        <input type="file" name="imagem" accept="image/*"><br><br>

        <label>Link do LinkedIn:</label><br>
        <input type="url" name="linkedin" placeholder="https://www.linkedin.com/in/seu-perfil"><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <p>Já tem cadastro? <a href="../site/Login.php">Faça login</a></p>

    <!-- formulário de cadastro -->
</div> <!-- ADICIONAR -->
</body>
</html>

