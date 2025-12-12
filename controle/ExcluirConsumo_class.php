<?php
session_start();
require_once(__DIR__ . "/../modelo/ConsumoDAO_class.php");

class ExcluirConsumo {

    private $dao;

    public function __construct() {
        // Verifica login
        if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['id_morador'])) {
            header("Location: Logout_class.php");
            exit;
        }

        $this->dao = new ConsumoDAO();

        // Pega o ID via GET
        if (isset($_GET['id'])) {
            $this->excluir($_GET['id']);
        } else {
            echo "ID do consumo não informado.";
            exit;
        }
    }

    private function excluir($id_consumo) {
        $sucesso = $this->dao->excluir($id_consumo);

        if ($sucesso) {
            header("Location: /individualEneR/visao/painelUsuario.php?pagina=listar");
            exit;
        } else {
            echo "Erro ao excluir consumo.";
            exit;
        }
    }
}
