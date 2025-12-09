<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: ../login.php?erro=2");
    exit;
}

$idUsuario = (int)$_SESSION["id"];
$idVaga    = isset($_GET["id_vaga"]) ? (int)$_GET["id_vaga"] : 0;

if ($idVaga <= 0) {
    header("Location: ../index.php");
    exit;
}

include_once "../class/candidatura.class.php";
include_once "../class/CandidaturaDAO.php";

$candDAO = new CandidaturaDAO();

// Verifica se já existe candidatura
if ($candDAO->jaCandidatou($idUsuario, $idVaga)) {
    header("Location: ../index.php?msg=ja");
    exit;
}

// Cria nova candidatura
$c = new Candidatura();
$c->setUniversal("id_usuario", $idUsuario);
$c->setUniversal("id_vaga",    $idVaga);

$candDAO->inserir($c);

header("Location: ../index.php?msg=ok");
exit;