<?php

require_once(__DIR__ . "/../modelo/MoradorDao_class.php");

class EditarMorador {

    private $dao;

    public function __construct() {
        $this->dao = new MoradorDAO();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->atualizar();
        } else {
            $this->carregarFormulario();
        }
    }

    private function carregarFormulario() {

        $id_morador = $_GET["id_morador"] ?? null;

        if ($id_morador === null) {
            echo "ID do morador não informado.";
            exit;
        }

        $morador = $this->dao->buscarPorId($id_morador);

        if (!$morador) {
            echo "Morador não encontrado.";
            exit;
        }

        $dados = $morador;

        include(__DIR__ . "/../visao/EditarMorador.php");
    }

    private function atualizar() {

        $id_morador      = $_POST["id_morador"] ?? null;
        $nome            = $_POST["nome"] ?? "";
        $nome_condominio = $_POST["nome_condominio"] ?? "";

        if ($id_morador === null) {
            echo "Erro: ID não informado.";
            exit;
        }

        $ok = $this->dao->atualizar($id_morador, $nome, $nome_condominio);

        if ($ok) {
            header("Location: /individualEneR/Morador.php?fun=listar&msg=editado");
            exit;
        } else {
            echo "Erro ao atualizar morador.";
        }
    }
}
