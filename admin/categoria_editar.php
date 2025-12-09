<?php
include_once "../class/categoria.class.php";
include_once "../class/CategoriaDAO.php";

$id = $_GET["id"] ?? null;

if ($id === null) {
    header("Location: categorias.php");
    exit;
}

$dao = new CategoriaDAO();
$categoria = $dao->buscarPorId((int)$id);

if (!$categoria) {
    header("Location: categorias.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoria | IFsul Vagas</title>
    <link rel="stylesheet" href="../assets/style_ifsul.css">
    <style>
        body {
            background: #f0f2f5;
        }
        
        .container {
            max-width: 700px;
            margin: 80px auto;
            padding: 32px;
        }
        
        .form-card {
            background: white;
            padding: 36px;
            border-radius: 16px;
            box-shadow: var(--sombra-lg);
            border-top: 6px solid var(--ifsul-verde);
        }
        
        .form-card h1 {
            color: var(--ifsul-verde-escuro);
            font-size: 1.8rem;
            margin-bottom: 24px;
            text-align: center;
        }
        
        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }
        
        .btn-group .btn {
            flex: 1;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-card">
        <h1>✏️ Editar Categoria</h1>

        <form method="post" action="categoria_editarOK.php">
            <input type="hidden" name="id" value="<?= $categoria["id"] ?>">

            <label>Nome da categoria:</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($categoria["nome"]) ?>" required>

            <div class="btn-group">
                <button type="submit" class="btn btn-success">✅ Salvar Alterações</button>
                <a href="categorias.php" class="btn btn-outline">❌ Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>