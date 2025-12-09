<?php

class usuario{
    private $id;

    private $nome;

    private $email;

    private $senha;

    public function setUniversal($variavel, $valor): void{
         $this->$variavel = $valor;
    }

    public function getUniversal($variavel): mixed{ 
        return $this->$variavel;
    }

}

