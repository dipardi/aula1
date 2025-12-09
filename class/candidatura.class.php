<?php
class Candidatura {
    private $id;
    private $id_usuario;
    private $id_vaga;
    private $data_candidatura;

    public function setUniversal($variavel, $valor) {
        $this->$variavel = $valor;
    }

    public function getUniversal($variavel) {
        return $this->$variavel;
    }
}
