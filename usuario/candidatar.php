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

include_once "../class/candidatura.class.php";
include_once "../class/CandidaturaDAO.php";

$candDAO = new CandidaturaDAO();

// verifica se já existe candidatura desse usuário pra essa vaga
if ($candDAO->jaCandidatou($idUsuario, $idVaga)) {
    header("Location: vagas.php?msg=ja");
    exit;
}

// cria nova candidatura
$c = new Candidatura();
$c->setUniversal("id_usuario", $idUsuario);
$c->setUniversal("id_vaga",    $idVaga);

$candDAO->inserir($c);

header("Location: vagas.php?msg=ok");
exit;
