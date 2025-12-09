<?php
class Categoria {
    private $id;
    private $nome;

    public function setUniversal($variavel, $valor) {
        $this->$variavel = $valor;
    }

    public function getUniversal($variavel) {
        return $this->$variavel;
    }
}
