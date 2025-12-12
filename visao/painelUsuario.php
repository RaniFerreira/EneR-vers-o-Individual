<?php
session_start();
require_once(__DIR__ . "/../modelo/ConsumoDAO_class.php");

// Verifica login
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['id_morador'])) {
    header("Location: ../controle/Logout_class.php");
    exit;
}

$usuario = $_SESSION['usuario'];
$id_morador = $_SESSION['id_morador'];
$lista = $_SESSION['lista_consumos'] ?? [];
$pagina = $_GET['pagina'] ?? 'listar';

// Se for editar consumo e tiver o id, carrega o consumo
$consumo = null;
if ($pagina === 'editarConsumo' && isset($_GET['id'])) {
    $dao = new ConsumoDAO();
    $consumo = $dao->buscarPorId($_GET['id']);
    if (!$consumo) {
        echo "Consumo não encontrado.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Usuário</title>
    <link rel="stylesheet" href="/individualEneR/visao/css/estiloPainelUsuario.css">
</head>
<body>

<nav>
    <a href="../Consumo.php?fun=listar">Listar Consumos</a>
    <a href="PainelUsuario.php?pagina=cadastrar">Cadastrar Consumo</a>
    <a href="PainelUsuario.php?pagina=dados">Dados do Morador</a>
    <a href="../controle/Logout_class.php" style="margin-left:auto;">Sair</a>
</nav>

<div class="container">

<?php if ($pagina === 'listar'): ?>
    <h2>Consumos Registrados</h2>
    <?php if (empty($lista)): ?>
        <p>Nenhum consumo cadastrado.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Consumo (kWh)</th>
                <th>Valor (R$)</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
           <?php foreach ($lista as $linha): ?>
            <tr>
                <td><?= $linha['id_consumo'] ?></td>
                <td><?= $linha['consumo_kwh'] ?></td>
                <td><?= number_format($linha['valor'], 2, ',', '.') ?></td>
                <td><?= date('d/m/Y', strtotime($linha['data_registro'])) ?></td>
                <td>
                    <a class="btn" href="PainelUsuario.php?pagina=editarConsumo&id=<?= $linha['id_consumo'] ?>">Editar</a>
                    <a class="btn btn-danger"
                       onclick="return confirm('Excluir consumo?');"
                       href="../Consumo.php?fun=excluir&id=<?= $linha['id_consumo'] ?>">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

<?php elseif ($pagina === 'cadastrar'): ?>
    <h2>Cadastrar Novo Consumo</h2>
    <form method="post" action="../Consumo.php?fun=cadastrar">
        <input type="hidden" name="id_morador" value="<?= $id_morador ?>">

        <label>Consumo (kWh):</label><br>
        <input type="number" step="0.01" name="consumo_kwh" id="consumo_kwh" required><br><br>

        <label>Data do registro:</label><br>
        <input type="date" name="data_registro" required><br><br>

        <p>Valor aproximado: R$ <span id="valor_calculado">0,00</span></p>
           <!-- Inclui o arquivo JS externo -->
        <script src="/individualEneR/visao/js/calculoConsumo.js"></script>

        <button class="btn">Cadastrar</button>
    </form>
 

<?php elseif ($pagina === 'dados'): ?>
    <h2>Dados do Morador</h2>
    <p><strong>Nome:</strong> <?= $usuario['nome'] ?></p>
    <p><strong>Condomínio:</strong> <?= $usuario['nome_condominio'] ?></p>
    <a class="btn" href="PainelUsuario.php?pagina=editarDados">Editar Dados</a>
    <a class="btn btn-danger"
       onclick="return confirm('Deseja realmente excluir sua conta?');"
       href="../Morador.php?fun=excluir&id=<?= $id_morador ?>">Excluir Conta</a>

<?php elseif ($pagina === 'editarDados'): ?>
    <h2>Editar Dados do Morador</h2>
    <form method="post" action="../Morador.php?fun=editar">
        <input type="hidden" name="id_morador" value="<?= $id_morador ?>">

        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?= $usuario['nome'] ?>" required><br><br>

        <label>Condomínio:</label><br>
        <input type="text" name="nome_condominio" value="<?= $usuario['nome_condominio'] ?>" required><br><br>

        <button class="btn">Salvar</button>
    </form>

<?php elseif ($pagina === 'editarConsumo' && $consumo): ?>
    <h2>Editar Consumo</h2>
    <form method="post" action="../Consumo.php?fun=editar">
        <input type="hidden" name="id_consumo" value="<?= $consumo['id_consumo'] ?>">
        <input type="hidden" name="id_morador" value="<?= $id_morador ?>">

        <label>Consumo (kWh):</label><br>
        <input type="number" step="0.01" name="consumo_kwh" id="consumo_kwh" value="<?= $consumo['consumo_kwh'] ?>" required><br><br>

        <label>Data:</label><br>
        <input type="date" name="data_registro" value="<?= date('Y-m-d', strtotime($consumo['data_registro'])) ?>" required><br><br>

        <p>Valor aproximado: R$ <span id="valor_calculado">0,00</span></p>
           <!-- Inclui o arquivo JS externo -->
        <script src="/individualEneR/visao/js/calculoConsumo.js"></script>

        <button class="btn">Salvar Alterações</button>
    </form>
<?php endif; ?>

</div>
</body>
</html>
