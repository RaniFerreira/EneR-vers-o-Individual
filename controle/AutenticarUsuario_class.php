<?php
session_start();
include_once(__DIR__ . "/../modelo/ConnectionFactory_class.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $msg = urlencode("❌ E-mail e senha são obrigatórios!");
        header("Location: ../visao/Login.php?erro=$msg");
        exit;
    }

    $factory = new ConnectionFactory();
    $conn = $factory->getConnection();

    try {
        // Busca usuário
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            $msg = urlencode("❌ E-mail ou senha incorretos!");
            header("Location: ../visao/Login.php?erro=$msg");
            exit;
        }

        // Login OK
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nome_usuario'] = $usuario['nome'];
        $_SESSION['email_usuario'] = $usuario['email'];

        // Busca morador vinculado
        $stmt2 = $conn->prepare("SELECT * FROM morador WHERE id_usuario = ?");
        $stmt2->execute([$usuario['id_usuario']]);
        $morador = $stmt2->fetch(PDO::FETCH_ASSOC);

        if (!$morador) {
            $msg = urlencode("❌ Morador não cadastrado para este usuário!");
            header("Location: ../visao/Login.php?erro=$msg");
            exit;
        }

        // Salva morador na sessão
        $_SESSION['id_morador'] = $morador['id_morador'];
        $_SESSION['usuario'] = $morador; // array completo

        header("Location: ../Morador.php?fun=listar");
        exit;

    } catch (PDOException $e) {
        error_log($e->getMessage());
        $msg = urlencode("❌ Erro no login, tente novamente!");
        header("Location: ../visao/Login.php?erro=$msg");
        exit;
    }
}
?>
