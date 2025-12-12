<?php

require_once(__DIR__ . "/../modelo/MoradorDAO_class.php");

class ListarMorador {

    public function __construct() {
        session_start();
        $this->listar();
    }

    private function listar() {

        if (!isset($_SESSION['id_usuario'])) {
            header("Location: Login.php");
            exit;
        }

        $idUsuario = $_SESSION["id_usuario"];

        $dao = new MoradorDAO();
        $usuario = $dao->listarPorUsuario($idUsuario);

        // Salva o morador na sessão
        $_SESSION["usuario"] = $usuario;

       // Caminho ABSOLUTO corrigido
        header("Location: /individualEneR/visao/painelUsuario.php?pagina=dados");

        exit;
    }
}

?>
