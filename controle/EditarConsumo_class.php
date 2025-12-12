<?php
session_start();
require_once(__DIR__ . "/../modelo/ConsumoDAO_class.php");

class EditarConsumo {
    private $dao;

    public function __construct() {
        if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['id_morador'])) {
            header("Location: Logout_class.php");
            exit;
        }

        $this->dao = new ConsumoDAO();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->salvarAlteracoes();
        } elseif (isset($_GET['id'])) {
            $this->abrirFormulario($_GET['id']);
        } else {
            echo "ID do consumo não informado.";
            exit;
        }
    }

    private function abrirFormulario($id_consumo) {
        // Redireciona para o painel passando o ID na URL
        header("Location: ../visao/painelUsuario.php?pagina=editarConsumo&id=" . $id_consumo);
        exit;
    }

    private function salvarAlteracoes() {
        $id_consumo = $_POST['id_consumo'];
        $consumo_kwh = $_POST['consumo_kwh'];
        $data_registro = date('Y-m-d', strtotime($_POST['data_registro']));

        // Calcula valor automaticamente
        $valor = $consumo_kwh * 0.99;

        $sucesso = $this->dao->editar($id_consumo, $consumo_kwh, $data_registro, $valor);

        if ($sucesso) {
            header("Location: /individualEneR/Consumo.php?fun=listar");
            exit;
        } else {
            echo "Erro ao atualizar consumo.";
            exit;
        }
    }
}
?>
