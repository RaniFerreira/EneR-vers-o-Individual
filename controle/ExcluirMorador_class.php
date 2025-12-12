<?php
require_once(__DIR__ . "/../modelo/MoradorDao_class.php");
require_once(__DIR__ . "/../modelo/UsuarioDao_class.php");

class ExcluirMorador {

    private $moradorDAO;
    private $usuarioDAO;

    public function __construct() {

        // Inicia a sessão apenas se ainda não estiver ativa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->moradorDAO = new MoradorDAO();
        $this->usuarioDAO = new UsuarioDAO();

        $this->excluir();
    }

    private function excluir() {

        // ID enviado pela URL → Morador.php?fun=excluir&id=3
        $id_morador = $_GET["id"] ?? null;

        if ($id_morador === null) {
            echo "ID do morador não informado.";
            exit;
        }

        // Busca os dados do morador
        $morador = $this->moradorDAO->buscarPorId($id_morador);

        if (!$morador) {
            echo "Morador não encontrado.";
            exit;
        }

        // Recupera o ID do usuário
        $id_usuario = $morador["id_usuario"];

        // Exclui o usuário → morador é deletado automaticamente (CASCADE)
        $ok = $this->usuarioDAO->excluir($id_usuario);

        if ($ok) {

            // Encerra sessão
            session_destroy();

            // Redireciona corretamente para o logout ou login
            header("Location: /individualEneR/visao/Login.php");
            exit;

        } else {
            echo "Erro ao excluir conta.";
        }
    }
}
