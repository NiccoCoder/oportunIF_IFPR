<?php
session_start();
include_once('config.php');
include_once('usuarioFuncoes.php');

if (isset($_POST['submit'])) {
    $novaSenha = $_POST['nova_senha'];
    $confirmarSenha = $_POST['confirmar_senha'];
    $id = $_POST['id']; // ID do usuário
    $tipoUsuario = $_POST['tipoUsuario']; // Tipo do usuário

    // Verifica se as senhas coincidem
    if ($novaSenha !== $confirmarSenha) {
        header("Location: ../../frontend/pages/redefinirSenha.html?error=" . urlencode("As senhas não coincidem") . "&id=" . urlencode($id) . "&tipoUsuario=" . urlencode($tipoUsuario));
        exit();
    }

    // Gera o hash da nova senha
    $hashNovaSenha = password_hash($novaSenha, PASSWORD_BCRYPT);

    // Define a tabela com base no tipo de usuário
    $tabela = $tipoUsuario === 'Docente' ? 'TB_DOCENTE' : 'TB_DISCENTE';
    $idColumn = $tipoUsuario === 'Docente' ? 'ID_DOCENTE' : 'ID_DISCENTE';

    // Atualiza a senha no banco de dados
    $updateQuery = "UPDATE $tabela SET SENHA = ? WHERE $idColumn = ?";
    $updateStmt = $conexao->prepare($updateQuery);
    $updateStmt->bind_param("si", $hashNovaSenha, $id); // Use "i" para inteiro

    if ($updateStmt->execute()) {
        header("Location: ../../frontend/pages/login.html?success=" . urlencode("Senha redefinida com sucesso!"));
    } else {
        header("Location: ../../frontend/pages/redefinirSenha.html?error=" . urlencode("Erro ao atualizar a senha."));
    }
    exit();
} else {
    header("Location: ../../frontend/pages/redefinirSenha.html?error=" . urlencode("Erro ao processar a solicitação."));
    exit();
}
?>
