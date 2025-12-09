<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
     header("Location: ../site/Login.php?erro=2");
     exit;
 }

include_once "../class/usuario.DAO.class.php";

$dao = new UsuarioDAO();
$usuarios = $dao->listar();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- ADICIONAR -->
</head>
<body>
<div class="container"> <!-- ADICIONAR -->


    <h1>Lista de Usuários (teste)</h1>

    <p><a href="../site/home.php">Voltar para a Home</a></p>

    <?php if (count($usuarios) === 0): ?>
        <p>Nenhum usuário cadastrado.</p>
    <?php else: ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>LinkedIn</th>
                <th>Imagem</th>
            </tr>

            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= $u["id"] ?></td>
                    <td><?= htmlspecialchars($u["nome"]) ?></td>
                    <td><?= htmlspecialchars($u["email"]) ?></td>
                    <td>
                        <?php if (!empty($u["linkedin"])): ?>
                            <a href="<?= htmlspecialchars($u["linkedin"]) ?>" target="_blank">
                                Perfil
                            </a>
                        <?php else: ?>
                            Não informado
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($u["imagem"])): ?>
                            <img src="../uploads/<?= htmlspecialchars($u["imagem"]) ?>" 
                                 alt="Foto de <?= htmlspecialchars($u["nome"]) ?>" 
                                 width="60">
                        <?php else: ?>
                            Sem foto
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
    <?php endif; ?>

    <!-- tabela de usuários -->
</div> <!-- ADICIONAR -->
</body>
</html>

