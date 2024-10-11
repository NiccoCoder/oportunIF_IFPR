<?php
include_once "config.php";
session_start();

$chave = htmlspecialchars(filter_input(INPUT_GET, "chave"));
$tipoUsuario = htmlspecialchars(filter_input(INPUT_GET, "tipoUsuario"));

if (!empty($chave) && !empty($tipoUsuario)) {
    // Defina a tabela com base no tipo de usuário
    $tabela = '';
    
    if ($tipoUsuario === 'Docente') {
        $tabela = 'TB_DOCENTE';
    } elseif ($tipoUsuario === 'Discente') {
        $tabela = 'TB_DISCENTE';
    } else {
        $_SESSION['mensagem'] = "<div class='alert alert-danger' role='alert'> Erro: Tipo de usuário inválido</div>";
        header("Location: ../../frontend/pages/login.html");
        exit();
    }

    // Deletar o registro correspondente
    $deleteUsuario = "DELETE FROM $tabela WHERE CHAVE = ?";
    $stmt = $conexao->prepare($deleteUsuario);
    $stmt->bind_param("s", $chave);

    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "<div class='alert alert-success' role='alert'> Conta rejeitada e registro removido com sucesso!</div>";
        header("Location: ../../frontend/pages/visitantePrincipal.html");
        exit();
    } else {
        $_SESSION['mensagem'] = "<div class='alert alert-danger' role='alert'> Erro: Não foi possível excluir a conta</div>";
        header("Location: ../../frontend/pages/visitantePrincipal.html");
        exit();
    }
} else {
    $_SESSION['mensagem'] = "<div class='alert alert-danger' role='alert'> Erro: Chave ou tipo de usuário não fornecidos</div>";
    header("Location: ../../frontend/pages/visitantePrincipal.html");
    exit();
}
?>
