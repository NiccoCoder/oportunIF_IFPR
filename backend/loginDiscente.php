<?php

require 'conexao.php'; 

// Verificar se o formulário foi enviado
if(isset($_POST['submit'])){

    // Receber os dados do formulário
    $email = $_POST['emailDiscente'];
    $senha = $_POST['senhaDiscente'];

    // Verificar se o e-mail já foi confirmado
    $query = "SELECT confirmado, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row || !$row['confirmado']) {
        echo "Por favor, confirme seu e-mail antes de acessar.";
        exit();
    }

    // Verificar a senha
    if (password_verify($senha, $row['senha'])) {
        // Iniciar a sessão e redirecionar
        session_start();
        $_SESSION['email'] = $email;
        header("Location: ../frontend/pages/paginavisitante.html");
    } else {
        // Senha incorreta
        header("Location: ../frontend/pages/logindiscente.html");
    }
} else {
    header("Location: ../frontend/pages/logindiscente.html");
    exit();
}

?>
