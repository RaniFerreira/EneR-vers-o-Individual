<?php
session_start();

// Destrói todas as variáveis da sessão
session_unset();

// Destrói a sessão
session_destroy();

// Redireciona para a página de Login
header("Location: /individualEneR/visao/Login.php");
exit;
