<?php
session_start();

// Pega a função
$fun = $_GET["fun"] ?? null;

// Se não informar função → mandar para cadastrar (ou listar)
if ($fun === null) {
    header("Location: /individualEneR/Morador.php?fun=cadastrar");
    exit;
}

// Apenas ROTAS que exigem login
$rotasQuePrecisamLogin = ["listar", "editar"];

// Verifica se precisa login
if (in_array($fun, $rotasQuePrecisamLogin)) {
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: /individualEneR/visao/Login.php");
        exit;
    }
}

switch ($fun) {

    case "listar":
        require_once(__DIR__ . "/controle/ListarMorador_class.php");
        new ListarMorador();
        break;

    case "cadastrar":
        require_once(__DIR__ . "/controle/CadastrarUsuarioMorador_class.php");
        new CadastrarMorador(); // sem login permitido
        break;

    case "editar":
        require_once(__DIR__ . "/controle/EditarMorador_class.php");
        new EditarMorador(); // exige login
        break;
    case "excluir":
        require_once(__DIR__ . "/controle/ExcluirMorador_class.php");
        new ExcluirMorador(); 
        break;

    default:
        echo "Rota inválida.";
        break;
}
