<?php

// Função para cadastrar um curso
function cadastrarCurso($nomeCurso, $conexao) {
    
    // Verificação se o nome do curso já existe no banco
    $check_nome_query = "SELECT * FROM TB_CURSO WHERE NOME_CURSO = ?";
    $stmt = $conexao->prepare($check_nome_query);
    $stmt->bind_param("s", $nomeCurso);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        return ['status' => false, 'message' => 'Curso já cadastrado.'];
    }
    
    // Prepare a query de inserção do curso
    $insert_script = "INSERT INTO TB_CURSO (NOME_CURSO) VALUES (?)";
    
    // Prepare o statement
    $stmt = $conexao->prepare($insert_script);
    $stmt->bind_param("s", $nomeCurso);

    // Executa a query de inserção
    if ($stmt->execute()) {
        // Captura o ID do curso inserido
        $id_curso = $stmt->insert_id;
        $stmt->close(); // Fechar o stmt
        
        return ['status' => true, 'message' => 'Curso cadastrado com sucesso', 'id_curso' => $id_curso];
    } else {
        return ['status' => false, 'message' => 'Falha ao registrar o curso: ' . $stmt->error];
    }
}

?>
