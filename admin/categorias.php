<?php
session_start();

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
    <title>Admin - Categorias | IFsul Vagas</title>
    <link rel="stylesheet" href="../assets/style_ifsul.css">
    <style>
        body {
            background: #f0f2f5;
        }
        
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 32px;
        }
        
        .page-title {
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: var(--sombra);
            border-left: 6px solid var(--ifsul-verde);
            margin-bottom: 28px;
        }
        
        .page-title h1 {
            color: var(--ifsul-verde-escuro);
            font-size: 2rem;
            margin-bottom: 8px;
        }
        
        .page-title .breadcrumb {
            color: var(--cinza);
            font-size: 0.9rem;
        }
        
        .page-title .breadcrumb a {
            color: var(--ifsul-verde);
            text-decoration: none;
        }
        
        .form-section {
            background: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: var(--sombra);
            margin-bottom: 28px;
        }
        
        .form-section h2 {
            color: var(--ifsul-verde-escuro);
            font-size: 1.4rem;
            margin-bottom: 20px;
        }
        
        .table-section {
            background: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: var(--sombra);
        }
        
        .table-section h2 {
            color: var(--ifsul-verde-escuro);
            font-size: 1.4rem;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="page-title">
        <h1>📂 Gerenciar Categorias</h1>
        <p class="breadcrumb">
            <a href="dashboard.php">Dashboard</a> / Categorias
        </p>
    </div>

    <?php
    if (isset($_GET["msg"])) {
        if ($_GET["msg"] === "cadastrada") {
            echo '<div class="alert alert-success">✅ Categoria cadastrada com sucesso!</div>';
        } elseif ($_GET["msg"] === "excluida") {
            echo '<div class="alert alert-success">✅ Categoria excluída com sucesso!</div>';
        } elseif ($_GET["msg"] === "atualizada") {
            echo '<div class="alert alert-success">✅ Categoria atualizada com sucesso!</div>';
        }
    }
    ?>

    <div class="form-section">
        <h2>➕ Cadastrar Nova Categoria</h2>
        <form method="post">
            <label>Nome da categoria:</label>
            <input type="text" name="nome" required placeholder="Ex: Tecnologia, Educação, Saúde...">
            <button type="submit" class="btn btn-success">✅ Cadastrar Categoria</button>
        </form>
    </div>

    <div class="table-section">
        <h2>📋 Categorias Cadastradas</h2>

        <table>
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
                        <a href="categoria_editar.php?id=<?= $cat["id"] ?>" class="btn btn-primary btn-small">✏️ Editar</a>
                        <a href="categoria_excluir.php?id=<?= $cat["id"] ?>" 
                           class="btn btn-danger btn-small"
                           onclick="return confirm('Tem certeza que deseja excluir esta categoria?');">
                            🗑️ Excluir
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>
</body>
</html>