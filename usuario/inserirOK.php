<?php
session_start();

include_once "../class/usuario.class.php";
include_once "../class/usuario.DAO.class.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: inserir.php");
    exit;
}

$nome     = trim($_POST["nome"] ?? "");
$email    = trim($_POST["email"] ?? "");
$senha    = trim($_POST["senha"] ?? "");
$linkedin = trim($_POST["linkedin"] ?? "");

// Tratamento da imagem (opcional)
$nomeImagem = "";
if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] === UPLOAD_ERR_OK) {
    $nomeOriginal = $_FILES["imagem"]["name"];
    $extensao = pathinfo($nomeOriginal, PATHINFO_EXTENSION);
    $nomeImagem = uniqid("user_") . "." . $extensao;
    $caminhoDestino = "../uploads/" . $nomeImagem;
    move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoDestino);
}

// Cria objeto usuário
$usuario = new Usuario();
$usuario->setUniversal("nome", $nome);
$usuario->setUniversal("email", $email);
$usuario->setUniversal("senha", $senha);
$usuario->setUniversal("imagem", $nomeImagem);
$usuario->setUniversal("linkedin", $linkedin);

$dao = new UsuarioDAO();

if ($dao->inserir($usuario)) {
    // Busca o usuário recém-criado para fazer login automático
    $usuarioLogin = new Usuario();
    $usuarioLogin->setUniversal("email", $email);
    $usuarioLogin->setUniversal("senha", $senha);
    
    $retorno = $dao->login($usuarioLogin);
    
    if ($retorno && is_array($retorno)) {
        // Cria sessão automaticamente
        $_SESSION["login"] = true;
        $_SESSION["id"]    = $retorno["id"];
        $_SESSION["nome"]  = $retorno["nome"];
        $_SESSION["email"] = $retorno["email"];
        
        // Redireciona para o INDEX já logado
        header("Location: ../index.php");
        exit;
    } else {
        // Se por algum motivo o login automático falhar, vai para a tela de login
        header("Location: ../login.php?msg=cadastrado");
        exit;
    }
} else {
    echo "Erro ao cadastrar usuário.";
}