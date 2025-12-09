<?php
session_start();

// Aqui no futuro podemos checar se é admin
// if (!isset($_SESSION["login"])) { header("Location: ../site/Login.php"); exit; }

include_once "../class/categoria.class.php";
include_once "../class/CategoriaDAO.php";

$dao = new CategoriaDAO();

// Se veio formulário (POST), cadastra nova categoria
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");

    if ($nome !== "") {
        $categoria = new Categoria();
        $categoria->setUniversal("nome", $nome);
        $dao->inserir($categoria);

        header("Location: categorias.php?msg=cadastrada");
        exit;
    }
}

// Lista todas as categorias para mostrar na tabela
$categorias = $dao->listar();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Admin - Categorias</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- ADICIONAR -->
</head>
<body>
<div class="container"> <!-- ADICIONAR -->

    <h1>Admin - Categorias de Vagas</h1>

    <?php
    if (isset($_GET["msg"])) {
        if ($_GET["msg"] === "cadastrada") {
            echo "<p style='color:green;'>Categoria cadastrada com sucesso!</p>";
        } elseif ($_GET["msg"] === "excluida") {
            echo "<p style='color:green;'>Categoria excluída com sucesso!</p>";
        } elseif ($_GET["msg"] === "atualizada") {
            echo "<p style='color:green;'>Categoria atualizada com sucesso!</p>";
        }
    }
    ?>

    <h2>Cadastrar nova categoria</h2>
    <form method="post">
        <label>Nome da categoria:</label><br>
        <input type="text" name="nome" required>
        <button type="submit">Cadastrar</button>
    </form>

    <hr>

    <h2>Categorias cadastradas</h2>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>

        <?php foreach ($categorias as $cat): ?>
            <tr>
                <td><?= $cat["id"] ?></td>
                <td><?= htmlspecialchars($cat["nome"]) ?></td>
                <td>
                    <a href="categoria_editar.php?id=<?= $cat["id"] ?>">Editar</a> |
                    <a href="categoria_excluir.php?id=<?= $cat["id"] ?>" 
                       onclick="return confirm('Tem certeza que deseja excluir esta categoria?');">
                        Excluir
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- formulário + tabela de categorias -->
</div> <!-- ADICIONAR -->
</body>
</html>

