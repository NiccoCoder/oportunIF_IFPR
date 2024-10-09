<?php
include_once('config.php');
include_once('usuarioFuncoes.php');

// Verifique se o e-mail foi enviado
if (isset($_POST['email'])) {
    $email = htmlspecialchars(trim($_POST['email'])); // Usar trim() para remover espaços em branco

    // Verificação de e-mail na tabela de docentes
    $verificaEmailDocente = "SELECT ID_DOCENTE AS ID, NOME, CHAVE, 'docente' AS TIPO FROM TB_DOCENTE WHERE EMAIL = ?";
    $stmt = $conexao->prepare($verificaEmailDocente);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Se não encontrar, verifique na tabela de discentes
    if ($resultado->num_rows === 0) {
        $verificaEmailDiscente = "SELECT ID_DISCENTE AS ID, NOME, CHAVE, 'discente' AS TIPO FROM TB_DISCENTE WHERE EMAIL = ?";
        $stmt = $conexao->prepare($verificaEmailDiscente);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
    }

    // Verifique se algum usuário foi encontrado
    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc(); // Obter o primeiro resultado

        $id = $usuario['ID']; // Armazenar o ID
        $tipoUsuario = $usuario['TIPO'];
        
        // Enviar o e-mail de redefinição de senha
        $resposta = reenviarEmailRedefinicaoSenha($usuario['NOME'], $email, $id, $tipoUsuario); // Passar ID aqui
        
        if ($resposta['status']) {
            header("Location: ../../frontend/pages/login.html?success=E-mail de redefinição de senha enviado com sucesso!");
        } else {
            header("Location: ../../frontend/pages/login.html?error=" . urlencode($resposta['message']));
        }
    } else {
        header("Location: ../../frontend/pages/login.html?error=E-mail não encontrado.");
    }
} else {
    header("Location: ../../frontend/pages/login.html?error=E-mail não fornecido.");
}
exit(); // Adiciona exit aqui para garantir que não haverá processamento adicional
?>
