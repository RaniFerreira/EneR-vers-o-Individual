<?php

if (isset($_GET["fun"])) {

    $fun = $_GET["fun"];

    // --- ROTA CADASTRAR ---
    if ($fun == "cadastrar") {

        include_once(__DIR__ . "/controle/CadastrarUsuarioMorador_class.php");

        $pag = new CadastrarMorador();
    }

    // --- ROTA LISTAR ---
    else if ($fun == "listar") {

        include_once(__DIR__ . "/controle/ListarConsumo_class.php");

        //$pag = new ListarConsumo();
    }
}

?>
