<?php
include_once "vaga.class.php";

class VagaDAO {
    private $conexao;

    public function __construct() {
        $this->conexao = new PDO(
            "mysql:host=localhost;dbname=pqp",
            "root",
            ""
        );
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // INSERT: criar vaga nova
    public function inserir(Vaga $vaga): bool {
        $sql = $this->conexao->prepare("
            INSERT INTO vagas 
            (titulo, descricao, contato, imagem, ativa, id_categoria)
            VALUES
            (:titulo, :descricao, :contato, :imagem, :ativa, :id_categoria)
        ");

        $sql->bindValue(":titulo",       $vaga->getUniversal("titulo"));
        $sql->bindValue(":descricao",    $vaga->getUniversal("descricao"));
        $sql->bindValue(":contato",      $vaga->getUniversal("contato"));
        $sql->bindValue(":imagem",       $vaga->getUniversal("imagem"));
        $sql->bindValue(":ativa",        $vaga->getUniversal("ativa"));
        $sql->bindValue(":id_categoria", $vaga->getUniversal("id_categoria"), PDO::PARAM_INT);

        return $sql->execute();
    }

    // SELECT: listar todas as vagas (com nome da categoria)
    public function listarTodas(): array {
        $sql = $this->conexao->prepare("
            SELECT v.*, c.nome AS categoria
            FROM vagas v
            JOIN categorias c ON v.id_categoria = c.id
            ORDER BY v.id DESC
        ");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // SELECT: listar só vagas ativas (para o usuário comum depois)
    public function listarAtivas(): array {
        $sql = $this->conexao->prepare("
            SELECT v.*, c.nome AS categoria
            FROM vagas v
            JOIN categorias c ON v.id_categoria = c.id
            WHERE v.ativa = 1
            ORDER BY v.id DESC
        ");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE: ativar/desativar vaga
    public function atualizarAtiva(int $id, int $ativa): bool {
        $sql = $this->conexao->prepare("
            UPDATE vagas
            SET ativa = :ativa
            WHERE id = :id
        ");
        $sql->bindValue(":ativa", $ativa, PDO::PARAM_INT);
        $sql->bindValue(":id",    $id,    PDO::PARAM_INT);
        return $sql->execute();
    }

    // SELECT por id (para ver detalhes / editar)
    public function buscarPorId(int $id): ?array {
        $sql = $this->conexao->prepare("
            SELECT * FROM vagas
            WHERE id = :id
        ");
        $sql->bindValue(":id", $id, PDO::PARAM_INT);
        $sql->execute();
        $ret = $sql->fetch(PDO::FETCH_ASSOC);
        return $ret ?: null;
    }
}
