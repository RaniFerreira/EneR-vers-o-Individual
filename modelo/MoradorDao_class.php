<?php
include_once(__DIR__ . "/ConnectionFactory_class.php");

class MoradorDAO {
    private $con;

    public function __construct() {
        $cf = new ConnectionFactory();
        $this->con = $cf->getConnection();
    }

    public function cadastrar($morador) {
        try {
            $stmt = $this->con->prepare("
                INSERT INTO morador (id_usuario, nome, nome_condominio)
                VALUES (:id_usuario, :nome, :nome_condominio)
            ");

            $stmt->bindValue(":id_usuario", $morador->getIdUsuario());
            $stmt->bindValue(":nome", $morador->getNome());
            $stmt->bindValue(":nome_condominio", $morador->getNomeCondominio());

            $stmt->execute();

            return true;

        } catch (PDOException $e) {
            echo "Erro ao cadastrar morador: " . $e->getMessage();
            return false;
        }
    }
}
?>
