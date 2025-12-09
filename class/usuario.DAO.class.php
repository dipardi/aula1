<?php
include_once "usuario.class.php";

class UsuarioDAO {
    private $conexao;

    public function __construct() {
        $this->conexao = new PDO(
            "mysql:host=localhost;dbname=pqp",
            "root",
            ""
        );
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

   public function inserir(Usuario $usuario): bool {
    $sql = $this->conexao->prepare("
        INSERT INTO bruninho (nome, email, senha, imagem, linkedin)
        VALUES (:nome, :email, :senha, :imagem, :linkedin)
    ");

    $sql->bindValue(":nome",     $usuario->getUniversal("nome"));
    $sql->bindValue(":email",    $usuario->getUniversal("email"));
    $sql->bindValue(":senha",    $usuario->getUniversal("senha"));
    $sql->bindValue(":imagem",   $usuario->getUniversal("imagem"));
    $sql->bindValue(":linkedin", $usuario->getUniversal("linkedin"));

    return $sql->execute();
}


    public function listar() {
        $sql = $this->conexao->prepare("
            SELECT * FROM bruninho
        ");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function login(Usuario $usuario) {

        $sql = $this->conexao->prepare("
            SELECT * FROM bruninho
            WHERE email = :email
        ");
        $sql->bindValue(":email", $usuario->getUniversal("email"));
        $sql->execute();

        $retorno = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$retorno) {
            return 0;
        }

        if ($retorno["senha"] != $usuario->getUniversal("senha")) {

            return 1;
        }

        return $retorno;
    }
}
