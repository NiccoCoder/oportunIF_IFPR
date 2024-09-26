<?php 
try {
    session_destroy();

    header("Location: ../frontend/pages/login.html?error=" . urlencode('Sessão finalizada com sucesso'));
    exit();
} catch (Exception $e) {
    // Você pode logar o erro ou redirecionar para uma página de erro
    header("Location: ../frontend/pages/login.html?error=" . urlencode('Erro ao finalizar a sessão.'));
    exit();
}
?>
