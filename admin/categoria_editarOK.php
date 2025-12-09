<?php
include_once "../class/categoria.class.php";
include_once "../class/CategoriaDAO.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: categorias.php");
    exit;
}

$id   = $_POST["id"] ?? null;
$nome = trim($_POST["nome"] ?? "");

if ($id === null || $nome === "") {
    header("Location: categorias.php");
    exit;
}

$categoria = new Categoria();
$categoria->setUniversal("id", (int)$id);
$categoria->setUniversal("nome", $nome);

$dao = new CategoriaDAO();
$dao->atualizar($categoria);

header("Location: categorias.php?msg=atualizada");
exit;
