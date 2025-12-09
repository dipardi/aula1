<?php
session_start();

include_once "../class/usuario.class.php";
include_once "../class/usuario.DAO.class.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Login.php");
    exit;
}

$email = $_POST["email"] ?? "";
$senha = $_POST["senha"] ?? "";

// a classe no arquivo usuario.class.php normalmente é "usuario" (minúsculo)
$usuario = new usuario();
$usuario->setUniversal("email", $email);
$usuario->setUniversal("senha", $senha);

$dao = new UsuarioDAO(); // nome da classe dentro de usuario.DAO.class.php
$retorno = $dao->login($usuario);


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
