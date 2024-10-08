<?php
session_start(); // Inicia a sessão para acessar as variáveis
header('Content-Type: application/json');

$response = array();

// Verifica se a sessão está ativa
if (isset($_SESSION['sessao_ativa']) && $_SESSION['sessao_ativa'] === true) {
    $response['sessaoAtiva'] = true;
    $response['user'] = array(
        'id' => $_SESSION['id'],
        'nome' => $_SESSION['nome'],
        'email' => $_SESSION['email'],
        'tipoUsuario' => $_SESSION['tipoUsuario'],
        'superUsuario' => ($_SESSION['tipoUsuario'] === 'docente') ? ($_SESSION['super_usuario'] ?? 0) : null
    );
} else {
    $response['sessaoAtiva'] = false; // Define que a sessão não está ativa
}

// Retorna a resposta em JSON
echo json_encode($response);
?>
