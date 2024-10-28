<?php
session_start(); // Inicia a sessão para acessar as variáveis
header('Content-Type: application/json');

$response = array();

//Tempo de expiração da sessão em segundos
$session_lifetime = 15 * 60; // 15 minutos

// Verifica se a sessão já está ativa e se o tempo de expiração foi alcançado
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $session_lifetime) {
    // Se a sessão expirou
    session_unset();     // Limpa as variáveis de sessão
    session_destroy();   // Destroi a sessão
    $response['sessaoAtiva'] = false; // Define que a sessão não está ativa
} else {
    // Atualiza a hora da última atividade
    $_SESSION['LAST_ACTIVITY'] = time();

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
}

// Retorna a resposta em JSON
echo json_encode($response);
?>
