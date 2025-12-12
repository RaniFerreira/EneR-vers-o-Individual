<?php
require_once(__DIR__ . "/../modelo/ConsumoDao_class.php");
session_start();

class CadastrarConsumo {
    private $dao;

    public function __construct() {
        $this->dao = new ConsumoDAO();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->cadastrar();
        }
    }

    private function cadastrar() {
        $id_morador = $_POST['id_morador'] ?? null;
        $consumo_kwh = $_POST['consumo_kwh'] ?? null;
        $data_input = $_POST['data_registro'] ?? null;

        if (!$id_morador || !$consumo_kwh || !$data_input) {
            echo "Todos os campos obrigatórios devem ser preenchidos.";
            exit;
        }

        $data_registro = strtotime($data_input);
        $valor = $consumo_kwh * 0.99;

        $ok = $this->dao->cadastrar($id_morador, $data_registro, $consumo_kwh, $valor);

        if ($ok) {
            header("Location: /individualEneR/Consumo.php?fun=listar");
            exit;
        } else {
            echo "Erro ao cadastrar consumo.";
        }
    }
}

new CadastrarConsumo();
