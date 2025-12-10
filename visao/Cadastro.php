
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Síndico</title>
    <link rel="stylesheet" href="/individualEneR/visao/css/estiloCadastro.css">




</head>
<body>

    <div class="container">
        <h2>Cadastre-se no EneR</h2>

        <!-- 🔹 Mensagem de sucesso ou erro -->
        <?php if (isset($status)) { ?>
            <p style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; 
                      padding: 10px; border-radius: 5px; text-align: center;">
                <?= $status ?>
            </p>
        <?php } ?>

        <form action="/individualEneR/Morador.php?fun=cadastrar" method="POST">
            <!-- Dados do Usuário -->
            <label for="nome_usuario">Nome de Usuário:</label>
            <input type="text" name="nome_usuario" placeholder="Ex.:user123"id="nome_usuario" required>

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>

            <!-- Dados do Síndico -->
            <label for="nome_sindico">Nome do Morador:</label>
            <input type="text" placeholder="Nome completo" name="nome_morador" id="nome_morador" required>


            <label for="condominio">Nome do Condomínio:</label>
            <input type="text" name="condominio" id="condominio" required>

            <input type="submit" value="Cadastrar Síndico">
            <!-- 🔹 Link para login -->
        <p style="text-align: center; margin-top: 15px;">
            Já sou cadastrado?
            <a href="/individualEneR/visao/Login.php" style="color: #007bff; text-decoration: none;">Fazer login</a>
        </p>
        </form>
    </div>
</body>
</html>