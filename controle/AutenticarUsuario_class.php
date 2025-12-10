<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
ob_start();

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once(__DIR__ . "/../modelo/ConnectionFactory_class.php");

    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    // Campos obrigatórios
    if (empty($email) || empty($senha)) {
        $mensagem = urlencode("❌ E-mail e senha são obrigatórios!");
        header("Location: ../visao/Login.php?erro=$mensagem");
        exit;
    }

    // Conexão
    $factory = new ConnectionFactory();
    $conn = $factory->getConnection();

    try {
        // Buscar usuário pelo e-mail
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se não existe usuário ou senha incorreta
        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            $mensagem = urlencode("❌ E-mail ou senha incorretos!");
            header("Location: ../visao/Login.php?erro=$mensagem");
            exit;
        }

        // Login ok
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nome_usuario'] = $usuario['nome'];
        $_SESSION['email_usuario'] = $usuario['email'];

        // Direciona SEMPER ao painel do morador
        header("Location: ../Morador.php?fun=listar");
        exit;

    } catch (PDOException $e) {
        error_log("Erro no login: " . $e->getMessage());
        $mensagem = urlencode("❌ Erro no login, tente novamente!");
        header("Location: ../visao/Login.php?erro=$mensagem");
        exit;
    }
}
?>
