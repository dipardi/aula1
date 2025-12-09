<?php
class Vaga {
    private $id;
    private $titulo;
    private $descricao;
    private $contato;
    private $imagem;
    private $ativa;
    private $id_categoria;

    public function setUniversal($variavel, $valor) {
        $this->$variavel = $valor;
    }

    public function getUniversal($variavel) {
        return $this->$variavel;
    }
}
