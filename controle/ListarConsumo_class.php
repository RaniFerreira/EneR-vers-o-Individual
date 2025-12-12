<?php
require_once(__DIR__ . "/../modelo/ConsumoDAO_class.php");
require_once(__DIR__ . "/../modelo/MoradorDAO_class.php");

class ListarConsumo {

    private $consumoDAO;
    private $moradorDAO;

    public function __construct() {
        session_start();

        if (!isset($_SESSION['id_usuario'])) {
            header("Location: /individualEneR/visao/Login.php");
            exit;
        }

        $this->consumoDAO = new ConsumoDAO();
        $this->moradorDAO = new MoradorDAO();

        $this->listar();
    }

    private function listar() {
        $id_usuario = $_SESSION['id_usuario'];

        // Buscar o morador ligado ao usuário
        $morador = $this->moradorDAO->listarPorUsuario($id_usuario);

        if (!$morador) {
            $_SESSION['lista_consumos'] = [];
            header("Location: /individualEneR/visao/painelUsuario.php?pagina=listar");
            exit;
        }

        // Pega o ID do morador
        $id_morador = $morador['id_morador'];

        // Busca os consumos do morador
        $lista = $this->consumoDAO->listarPorMorador($id_morador);

        // Salva na sessão
        $_SESSION['lista_consumos'] = $lista;
        $_SESSION['id_morador'] = $id_morador;
        $_SESSION['usuario'] = $morador;

        // Redireciona para o painel
        header("Location: /individualEneR/visao/painelUsuario.php?pagina=listar");
        exit;
    }
}
