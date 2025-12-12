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

     // Lista informações do morador pelo ID do usuário
   /* ============================
       LISTAR POR ID DO USUÁRIO
       ============================ */
    public function listarPorUsuario($idUsuario) {
        try {
            $sql = "
                SELECT 
                    id_morador,
                    id_usuario,
                    nome,
                    nome_condominio
                FROM morador
                WHERE id_usuario = :idUsuario
                LIMIT 1
            ";

            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(":idUsuario", $idUsuario);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Erro ao buscar morador: " . $e->getMessage();
            return null;
        }
    }

     // BUSCAR POR ID
    public function buscarPorId($id_morador) {
        $sql = "SELECT * FROM morador WHERE id_morador = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$id_morador]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ATUALIZAR — versão correta
    public function atualizar($id_morador, $nome, $nome_condominio) {

        $sql = "UPDATE morador 
                   SET nome = ?, nome_condominio = ?
                 WHERE id_morador = ?";

        $stmt = $this->con->prepare($sql);

        return $stmt->execute([
            $nome,
            $nome_condominio,
            $id_morador
        ]);
    }

    
   public function excluir($id_morador) {

    $sql = "DELETE FROM morador WHERE id_morador = ?";

    $stmt = $this->con->prepare($sql);

    return $stmt->execute([$id_morador]);
}

}

    



?>
