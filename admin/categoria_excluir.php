<?php
include_once "../class/CategoriaDAO.php";

$id = $_GET["id"] ?? null;

if ($id === null) {
    header("Location: categorias.php");
    exit;
}

$dao = new CategoriaDAO();
$dao->excluir((int)$id);

header("Location: categorias.php?msg=excluida");
exit;
