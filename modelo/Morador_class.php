<?php

class Morador{

    private $id_morador;
    private $id_usuario;
    private $nome;
    private $nome_condominio;

    public function getIdMorador() {
        return $this->id_morador;
    }

    
    public function setIdMorador($id_morador) {
        $this->id_morador = $id_morador;
    }


    public function getIdUsuario() {
        return $this->id_usuario;
    }

    
    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }


    public function getNome() {
        return $this->nome;
    }

     public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getNomeCondominio() {
        return $this->nome_condominio;
    }

    public function setNomeCondominio($nome_condominio) {
        $this->nome_condominio = $nome_condominio;
    }


}


?>