<?php
include_once "candidatura.class.php";

class CandidaturaDAO {
    private $conexao;

    public function __construct() {
        $this->conexao = new PDO(
            "mysql:host=localhost;dbname=pqp",
            "root",
            ""
        );
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Inserir candidatura
    public function inserir(Candidatura $c): bool {
        $sql = $this->conexao->prepare("
            INSERT INTO candidaturas (id_usuario, id_vaga)
            VALUES (:id_usuario, :id_vaga)
        ");
        $sql->bindValue(":id_usuario", $c->getUniversal("id_usuario"), PDO::PARAM_INT);
        $sql->bindValue(":id_vaga",    $c->getUniversal("id_vaga"),    PDO::PARAM_INT);

        return $sql->execute();
    }

    // Ver se o usuário já se candidatou a uma vaga
    public function jaCandidatou(int $idUsuario, int $idVaga): bool {
        $sql = $this->conexao->prepare("
            SELECT COUNT(*) AS total
            FROM candidaturas
            WHERE id_usuario = :id_usuario
              AND id_vaga = :id_vaga
        ");
        $sql->bindValue(":id_usuario", $idUsuario, PDO::PARAM_INT);
        $sql->bindValue(":id_vaga",    $idVaga,    PDO::PARAM_INT);
        $sql->execute();

        $linha = $sql->fetch(PDO::FETCH_ASSOC);
        return $linha["total"] > 0;
    }

    // Listar inscritos de uma vaga (para admin)
    public function listarPorVaga(int $idVaga): array {
        $sql = $this->conexao->prepare("
            SELECT c.*, u.nome, u.email, u.imagem, u.linkedin
            FROM candidaturas c
            JOIN bruninho u ON c.id_usuario = u.id
            WHERE c.id_vaga = :id_vaga
            ORDER BY c.data_candidatura DESC
        ");
        $sql->bindValue(":id_vaga", $idVaga, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // NOVO: Listar candidaturas de um usuário
    public function listarPorUsuario(int $idUsuario): array {
        $sql = $this->conexao->prepare("
            SELECT c.*, v.titulo as vaga_titulo
            FROM candidaturas c
            JOIN vagas v ON c.id_vaga = v.id
            WHERE c.id_usuario = :id_usuario
            ORDER BY c.data_candidatura DESC
        ");
        $sql->bindValue(":id_usuario", $idUsuario, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Remover candidatura
    public function remover(int $idUsuario, int $idVaga): bool {
        $sql = $this->conexao->prepare("
            DELETE FROM candidaturas
            WHERE id_usuario = :id_usuario
              AND id_vaga = :id_vaga
        ");
        $sql->bindValue(":id_usuario", $idUsuario, PDO::PARAM_INT);
        $sql->bindValue(":id_vaga",    $idVaga,    PDO::PARAM_INT);

        return $sql->execute();
    }
}