<?php
session_start();

$fun = $_GET['fun'] ?? null;

if ($fun === null) {
    header("Location: /individualEneR/Consumo.php?fun=cadastrar");
    exit;
}

$rotasQuePrecisamLogin = ["cadastrar", "listar", "editar", "excluir"];
if (in_array($fun, $rotasQuePrecisamLogin)) {
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: /individualEneR/visao/Login.php");
        exit;
    }
}

switch($fun) {
    case "cadastrar":
        require_once(__DIR__ . "/controle/CadastrarConsumo_class.php");
        new CadastrarConsumo();
        break;

    case "listar":
        require_once(__DIR__ . "/controle/ListarConsumo_class.php");
        new ListarConsumo();
        break;
    case "editar":
        require_once(__DIR__ . "/controle/EditarConsumo_class.php");
        new EditarConsumo();
        break;

    case "excluir":
        require_once(__DIR__ . "/controle/ExcluirConsumo_class.php");
        new ExcluirConsumo();
        break;

    default:
        echo "Rota inválida.";
        break;
}

