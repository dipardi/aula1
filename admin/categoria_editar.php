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
    <title>Editar Categoria</title>
</head>
<body>
    <h1>Editar Categoria</h1>

    <form method="post" action="categoria_editarOK.php">
        <input type="hidden" name="id" value="<?= $categoria["id"] ?>">

        <label>Nome da categoria:</label><br>
        <input type="text" name="nome" value="<?= htmlspecialchars($categoria["nome"]) ?>" required>

        <button type="submit">Salvar</button>
        <a href="categorias.php">Cancelar</a>
    </form>

</body>
</html>
