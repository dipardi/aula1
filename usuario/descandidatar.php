<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: ../login.php?erro=2");
    exit;
}

$idUsuario = (int)$_SESSION["id"];
$idVaga    = isset($_GET["id_vaga"]) ? (int)$_GET["id_vaga"] : 0;

// Pega o referer para saber de onde veio
$referer = $_SERVER['HTTP_REFERER'] ?? '../index.php';

if ($idVaga <= 0) {
    header("Location: " . $referer);
    exit;
}

include_once "../class/CandidaturaDAO.php";

$dao = new CandidaturaDAO();
$dao->remover($idUsuario, $idVaga);

// Redireciona para onde veio (index ou minhas candidaturas)
if (strpos($referer, 'minhas_candidaturas') !== false) {
    header("Location: minhas_candidaturas.php?msg=removida");
} else {
    header("Location: ../index.php?msg=removida");
}
exit;