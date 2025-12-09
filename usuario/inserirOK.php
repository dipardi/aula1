<?php
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

// tratamento da imagem (opcional)
$nomeImagem = "";
if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] === UPLOAD_ERR_OK) {
    $nomeOriginal = $_FILES["imagem"]["name"];
    $extensao = pathinfo($nomeOriginal, PATHINFO_EXTENSION);

    $nomeImagem = uniqid("user_") . "." . $extensao;

    $caminhoDestino = "../uploads/" . $nomeImagem;
    move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoDestino);
}

// cria objeto usuário
$usuario = new Usuario();
$usuario->setUniversal("nome", $nome);
$usuario->setUniversal("email", $email);
$usuario->setUniversal("senha", $senha);
$usuario->setUniversal("imagem", $nomeImagem);
$usuario->setUniversal("linkedin", $linkedin);

$dao = new UsuarioDAO();

if ($dao->inserir($usuario)) {
    header("Location: ../site/Login.php?msg=cadastrado");
    exit;
} else {
    echo "Erro ao cadastrar usuário.";
}
