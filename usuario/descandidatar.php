<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: ../site/Login.php?erro=2");
    exit;
}

$idUsuario = (int)$_SESSION["id"];
$idVaga    = isset($_GET["id_vaga"]) ? (int)$_GET["id_vaga"] : 0;

if ($idVaga <= 0) {
    header("Location: vagas.php");
    exit;
}

include_once "../class/CandidaturaDAO.php";

$dao = new CandidaturaDAO();
$dao->remover($idUsuario, $idVaga);

header("Location: vagas.php?msg=removida");
exit;
