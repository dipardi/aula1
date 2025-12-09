<?php
session_start();

include_once "usuario.class.php";
include_once "UsuarioDAO.php"; // ajusta o nome se o arquivo for diferente

// Verifica se veio via POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

$email = $_POST["email"] ?? "";
$senha = $_POST["senha"] ?? "";

// Cria o objeto usuário e preenche
$usuario = new Usuario();
$usuario->setUniversal("email", $email);
$usuario->setUniversal("senha", $senha);

// Chama o DAO
$dao = new UsuarioDAO();
$retorno = $dao->login($usuario);

/*
   Retornos possíveis do login():
   0 -> email não cadastrado
   1 -> senha incorreta
   array -> login OK (dados do usuário)
*/

if ($retorno === 0) {
    header("Location: login.php?erro=0");
    exit;
} elseif ($retorno === 1) {
    header("Location: login.php?erro=1");
    exit;
} else {
    // Sucesso: cria sessão
    $_SESSION["login"] = true;
    $_SESSION["id"]    = $retorno["id"];
    $_SESSION["nome"]  = $retorno["nome"];
    $_SESSION["email"] = $retorno["email"];

    // Redireciona para a área logada (a gente cria depois)
    // por enquanto, joga pra uma página "home" simples
    header("Location: home.php");
    exit;
}
