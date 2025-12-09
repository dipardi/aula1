<?php
session_start();

include_once "../class/usuario.class.php";
include_once "../class/usuario.DAO.class.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../login.php");
    exit;
}

$email = $_POST["email"] ?? "";
$senha = $_POST["senha"] ?? "";

$usuario = new usuario();
$usuario->setUniversal("email", $email);
$usuario->setUniversal("senha", $senha);

$dao = new UsuarioDAO();
$retorno = $dao->login($usuario);

if ($retorno === 0) {
    // Email não encontrado
    header("Location: ../login.php?erro=0");
    exit;
} elseif ($retorno === 1) {
    // Senha incorreta
    header("Location: ../login.php?erro=1");
    exit;
} else {
    // Sucesso: cria sessão
    $_SESSION["login"] = true;
    $_SESSION["id"]    = $retorno["id"];
    $_SESSION["nome"]  = $retorno["nome"];
    $_SESSION["email"] = $retorno["email"];

    // Redireciona para o INDEX (página inicial logada)
    header("Location: ../index.php");
    exit;
}