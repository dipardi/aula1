<?php
include_once "categoria.class.php";

class CategoriaDAO {
    private $conexao;

    public function __construct() {
        $this->conexao = new PDO(
            "mysql:host=localhost;dbname=pqp",
            "root",
            ""
        );
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // INSERT: cria categoria nova
    public function inserir(Categoria $categoria): bool {
        $sql = $this->conexao->prepare("
            INSERT INTO categorias (nome)
            VALUES (:nome)
        ");

        $sql->bindValue(":nome", $categoria->getUniversal("nome"));

        return $sql->execute();
    }

    // SELECT: lista todas as categorias
    public function listar(): array {
        $sql = $this->conexao->prepare("
            SELECT * FROM categorias
            ORDER BY nome
        ");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // SELECT por id (para edição futura)
    public function buscarPorId(int $id): ?array {
        $sql = $this->conexao->prepare("
            SELECT * FROM categorias
            WHERE id = :id
        ");
        $sql->bindValue(":id", $id, PDO::PARAM_INT);
        $sql->execute();

        $retorno = $sql->fetch(PDO::FETCH_ASSOC);
        return $retorno ?: null;
    }

    // UPDATE: editar categoria
    public function atualizar(Categoria $categoria): bool {
        $sql = $this->conexao->prepare("
            UPDATE categorias
            SET nome = :nome
            WHERE id = :id
        ");

        $sql->bindValue(":nome", $categoria->getUniversal("nome"));
        $sql->bindValue(":id",   $categoria->getUniversal("id"), PDO::PARAM_INT);

        return $sql->execute();
    }

    // DELETE: excluir categoria
    public function excluir(int $id): bool {
        $sql = $this->conexao->prepare("
            DELETE FROM categorias
            WHERE id = :id
        ");
        $sql->bindValue(":id", $id, PDO::PARAM_INT);
        return $sql->execute();
    }
}
