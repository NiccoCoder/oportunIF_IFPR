<?php
session_start(); // Inicia a sessão

// Verifica se a sessão está ativa
if (isset($_SESSION['sessao_ativa'])) {
    // Destrói a sessão
    session_destroy();
}

// Redireciona para a página de login ou outra página desejada
header("Location: ../frontend/pages/paginavisitante.html");
exit();
?>
