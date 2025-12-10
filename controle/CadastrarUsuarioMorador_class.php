<?php
include_once(__DIR__ . "/../modelo/Usuario_class.php");
include_once(__DIR__ . "/../modelo/UsuarioDao_class.php");

include_once(__DIR__ . "/../modelo/Morador_class.php");
include_once(__DIR__ . "/../modelo/MoradorDao_class.php");

class CadastrarMorador {
    public function __construct() {
        $status = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nomeUsuario = trim($_POST["nome_usuario"]);
            $email = trim($_POST["email"]);
            $senha = $_POST["senha"];

            $nomeMorador = trim($_POST["nome_morador"]);
            $condominio = trim($_POST["condominio"]);

            $usuarioDAO = new UsuarioDAO();

            // Verifica email
            if ($usuarioDAO->emailExiste($email)) {
                $status = "⚠️  <b>{$email}</b> já está cadastrado, tente outro e-mail!";
            } else {

                // Cadastra usuário
                $u = new Usuario();
                $u->setNome($nomeUsuario);
                $u->setEmail($email);
                $u->setSenha($senha);

                $idUsuario = $usuarioDAO->cadastrar($u);

                if ($idUsuario) {

                    $m = new Morador();
                    $m->setIdUsuario($idUsuario);
                    $m->setNome($nomeMorador);
                    $m->setNomeCondominio($condominio);

                    $moradorDAO = new MoradorDAO();
                    $moradorDAO->cadastrar($m);

                    $status = "✅ Morador cadastrado com sucesso!";
                } else {
                    $status = "❌ Erro ao cadastrar usuário.";
                }
            }
        }

        include_once("visao/Cadastro.php");
    }
}
?>
