<?php

// Função para cadastrar um tipo de projeto
function cadastrarTipoProjeto($nomeTipoProjeto, $conexao) {
    
    // Verifica se o tipo de projeto já existe
    $check_nome_query = "SELECT * FROM TB_TIPO_PROJETO WHERE NOME_TIPO_PROJETO = ?";
    $stmt = $conexao->prepare($check_nome_query);
    $stmt->bind_param("s", $nomeTipoProjeto);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        return ['status' => false, 'message' => 'Tipo de projeto já cadastrado.'];
    }
    
    // Insere o novo tipo de projeto
    $insert_query = "INSERT INTO TB_TIPO_PROJETO (NOME_TIPO_PROJETO) VALUES (?)";
    $stmt = $conexao->prepare($insert_query);
    $stmt->bind_param("s", $nomeTipoProjeto);

    if ($stmt->execute()) {
        $id_tipo_projeto = $stmt->insert_id;
        $stmt->close();
        
        // Retorna o status de sucesso
        return ['status' => true, 'message' => 'Tipo de projeto cadastrado com sucesso!', 'id_tipo_projeto' => $id_tipo_projeto];
    } else {
        return ['status' => false, 'message' => 'Erro ao cadastrar tipo de projeto: ' . $stmt->error];
    }
}

?>
