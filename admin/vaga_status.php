<?php
include_once "../class/VagaDAO.php";

$id    = $_GET["id"]    ?? null;
$ativa = $_GET["ativa"] ?? null;

if ($id === null || $ativa === null) {
    header("Location: vagas_cadastrar.php");
    exit;
}

// converte para int (0 ou 1)
$id    = (int)$id;
$ativa = (int)$ativa;

$dao = new VagaDAO();
$dao->atualizarAtiva($id, $ativa);

$msg = $ativa === 1 ? "ativada" : "desativada";

header("Location: vagas_cadastrar.php?msg={$msg}");
exit;
