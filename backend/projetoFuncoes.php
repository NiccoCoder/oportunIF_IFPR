<?php

function cadastrarProjeto($id_docente, $titulo, $id_tipo_projeto, $criterios_selecao, $resumo, $conexao, $bolsa_disponivel, $descricao_bolsa = null, $requisito_bolsa = null) {
    
    // Verificação de registros vazios com id 
    $check_docente_query = "SELECT * FROM TB_DOCENTE WHERE ID_DOCENTE = ?";
    $stmt = $conexao->prepare($check_docente_query);
    $stmt->bind_param("i", $id_docente);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows < 1) {
        return ['status' => false, 'message' => 'Este docente não está cadastrado.'];
    }
    
    // Prepare a query de inserção com os novos campos
    $insert_script = "INSERT INTO TB_PROJETO (ID_DOCENTE, TITULO, ID_TIPO_PROJETO, CRITERIOS_SELECAO, RESUMO, POSSUI_BOLSA, BOLSA_DESCRICAO, BOLSA_REQUISITOS) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Se a bolsa não estiver disponível, passar null para os campos relacionados à bolsa
    if ($bolsa_disponivel == '1') {
        $stmt = $conexao->prepare($insert_script);
        $stmt->bind_param("issssssss", $id_docente, $titulo, $id_tipo_projeto, $criterios_selecao, $resumo, $bolsa_disponivel, $descricao_bolsa, $requisito_bolsa);
    } else {
        // Se não há bolsa, os campos de descrição e requisitos ficam nulos
        $descricao_bolsa = null;
        $requisito_bolsa = null;
        $insert_script = "INSERT INTO TB_PROJETO (ID_DOCENTE, TITULO, ID_TIPO_PROJETO, CRITERIOS_SELECAO, RESUMO, POSSUI_BOLSA, BOLSA_DESCRICAO, BOLSA_REQUISITOS) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($insert_script);
        $stmt->bind_param("isssssss", $id_docente, $titulo, $id_tipo_projeto, $criterios_selecao, $resumo, $bolsa_disponivel, $descricao_bolsa, $requisito_bolsa);
    }

    if ($stmt->execute()) {
        $stmt->close(); // Fechar o stmt
        return ['status' => true, 'message' => 'Projeto cadastrado com sucesso'];
    } else {
        return ['status' => false, 'message' => 'Falha ao registrar projeto: ' . $stmt->error];
    } 
}
?>
