<?php

class Consumo {

    private $id_consumo;
    private $id_morador;
    private $data_registro;
    private $consumo_kwh;
    private $valor;

    // id_consumo
    public function getIdConsumo() {
        return $this->id_consumo;
    }

    public function setIdConsumo($id_consumo) {
        $this->id_consumo = $id_consumo;
    }

    // id_morador
    public function getIdMorador() {
        return $this->id_morador;
    }

    public function setIdMorador($id_morador) {
        $this->id_morador = $id_morador;
    }

    // data_registro
    public function getDataRegistro() {
        return $this->data_registro;
    }

    public function setDataRegistro($data_registro) {
        $this->data_registro = $data_registro;
    }

    // consumo_kwh
    public function getConsumoKwh() {
        return $this->consumo_kwh;
    }

    public function setConsumoKwh($consumo_kwh) {
        $this->consumo_kwh = $consumo_kwh;
    }

    // valor
    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }
}

?>
