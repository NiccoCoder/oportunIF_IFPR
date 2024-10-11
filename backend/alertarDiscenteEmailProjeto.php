<?php
include_once('config.php');
include_once('usuarioFuncoes.php');

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);

    if (empty($id)) {
        header("Location: ../../frontend/pages/login.html?error=ID não fornecido");
        exit;
    }

    // Verifica se o ID existe na base de dados
    $verificaUsuario = "SELECT ID_DOCENTE, NOME, EMAIL, SITUACAO, CHAVE FROM TB_DOCENTE WHERE ID_DOCENTE = ? UNION SELECT ID_DISCENTE, NOME, EMAIL, SITUACAO, CHAVE FROM TB_DISCENTE WHERE ID_DISCENTE = ?";
    $stmt = $conexao->prepare($verificaUsuario);
    $stmt->bind_param("ii", $id, $id); // Assume que ID_DOCENTE e ID_DISCENTE são inteiros
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        
        // Verifica se o cadastro está pendente
        if ($usuario['SITUACAO'] === 'pendente') { // Corrigido para minúsculo
            $chave = $usuario['CHAVE'];
            $tipoUsuario = isset($usuario['ID_DOCENTE']) ? 'Docente' : 'Discente';

            $resposta = reenviarEmailValidacao($usuario['NOME'], $usuario['EMAIL'], $chave, $tipoUsuario); // Assume que 'EMAIL' é retornado na consulta

            if (is_array($resposta) && isset($resposta['status']) && $resposta['status']) {
                header("Location: ../../frontend/pages/login.html?success=E-mail de validação reenviado com sucesso!");
            } else {
                header("Location: ../../frontend/pages/login.html?error=" . urlencode($resposta['message']));
            }
        } else {
            header("Location: ../../frontend/pages/login.html?error=Seu cadastro já está validado.");
        }
    } else {
        header("Location: ../../frontend/pages/login.html?error=ID não encontrado.");
    }
} else {
    header("Location: ../../frontend/pages/login.html?error=ID não fornecido.");
}
?>
