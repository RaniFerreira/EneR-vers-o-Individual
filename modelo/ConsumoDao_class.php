<?php
include_once(__DIR__ . "/ConnectionFactory_class.php");

class ConsumoDAO {

    private $con;

    public function __construct() {
        $cf = new ConnectionFactory();
        $this->con = $cf->getConnection();
    }

     // Cadastrar consumo
    public function cadastrar($id_morador, $data_registro, $consumo_kwh, $valor = null) {
        $sql = "INSERT INTO consumo (id_morador, data_registro, consumo_kwh, valor)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->con->prepare($sql);
        return $stmt->execute([$id_morador, $data_registro, $consumo_kwh, $valor]);
    }

    // Listar consumos de um morador
    // Lista consumos por morador
    public function listarPorMorador($id_morador) {
        $sql = "SELECT * FROM consumo WHERE id_morador = :id_morador ORDER BY data_registro DESC";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':id_morador', $id_morador, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Converte datas para timestamp se precisar
        foreach ($result as &$row) {
            $row['data_registro'] = strtotime($row['data_registro']);
        }

        return $result;
    }


    // Busca um consumo específico pelo id
public function buscarPorId($id_consumo) {
    $sql = "SELECT * FROM consumo WHERE id_consumo = :id_consumo";
    $stmt = $this->con->prepare($sql);
    $stmt->bindValue(':id_consumo', $id_consumo, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($resultado) {
        $resultado['data_registro'] = strtotime($resultado['data_registro']); // converte para timestamp
    }

    return $resultado;
}

// Atualiza um consumo
public function editar($id_consumo, $consumo_kwh, $data_registro, $valor) {
    $sql = "UPDATE consumo 
            SET consumo_kwh = :consumo_kwh, data_registro = :data_registro, valor = :valor
            WHERE id_consumo = :id_consumo";
    $stmt = $this->con->prepare($sql);
    $stmt->bindValue(':consumo_kwh', $consumo_kwh);
    $stmt->bindValue(':data_registro', $data_registro);
    $stmt->bindValue(':valor', $valor);
    $stmt->bindValue(':id_consumo', $id_consumo, PDO::PARAM_INT);

    return $stmt->execute();
}


    // Excluir consumo
    public function excluir($id_consumo) {
        $sql = "DELETE FROM consumo WHERE id_consumo = ?";
        $stmt = $this->con->prepare($sql);
        return $stmt->execute([$id_consumo]);
    }
}
?>
