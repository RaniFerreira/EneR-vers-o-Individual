<?php
include_once(__DIR__ . "/ConnectionFactory_class.php");

class UsuarioDAO {
    private $con;

    public function __construct() {
        $cf = new ConnectionFactory();
        $this->con = $cf->getConnection();
    }

    // Verifica se email já existe (retorna true/false)
    public function emailExiste($email) {
        try {
            $stmt = $this->con->prepare("SELECT COUNT(*) FROM usuario WHERE email = :email");
            $stmt->bindValue(":email", $email);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return ($count > 0);
        } catch (PDOException $e) {
            // opcional: logar erro
            return false;
        }
    }

    // Cadastra usuario e retorna id inserido ou false
    public function cadastrar($usuario) {
        try {
            // hash da senha
            $senhaHash = password_hash($usuario->getSenha(), PASSWORD_DEFAULT);

            $stmt = $this->con->prepare("
                INSERT INTO usuario (nome, email, senha)
                VALUES (:nome, :email, :senha)
            ");
            $stmt->bindValue(":nome", $usuario->getNome());
            $stmt->bindValue(":email", $usuario->getEmail());
            $stmt->bindValue(":senha", $senhaHash);

            $ok = $stmt->execute();

            if ($ok) {
                return (int)$this->con->lastInsertId();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // para debug: echo "Erro: " . $e->getMessage();
            return false;
        }
    }
}
?>
