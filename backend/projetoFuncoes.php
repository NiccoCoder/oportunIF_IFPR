<?php

// require '../PHPMailer/src/Exception.php';
// require '../PHPMailer/src/PHPMailer.php';
// require '../PHPMailer/src/SMTP.php';

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
// use PHPMailer\PHPMailer\SMTP;

include_once('config.php');

function cadastrarProjeto($id_docente, $titulo, $id_tipo_projeto, $criterios_selecao, $resumo, $conexao) {
    
    // Verificação de registros vazios com id 
    $check_docente_query = "SELECT * FROM TB_DOCENTE WHERE ID_DOCENTE = ?";
    $stmt = $conexao->prepare($check_docente_query);
    $stmt->bind_param("i", $id_docente);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows < 1) {
        return ['status' => false, 'message' => 'Este docente não está cadastrado.'];
    }
    
    $insert_script = "INSERT INTO TB_PROJETO (ID_DOCENTE, TITULO_PROJETO, ID_TIPO_PROJETO, CRITERIOS_SELECAO, RESUMO) VALUES (?, ?, ?, ?, ?)";
    
    // Preparar e executar a query de forma segura
    $stmt = $conexao->prepare($insert_script);
    $stmt->bind_param("isiss", $id_docente, $titulo, $id_tipo_projeto, $criterios_selecao, $resumo);
    
    if ($stmt->execute()) {
        $stmt->close(); // Fechar o stmt
        return ['status' => true, 'message' => 'Projeto cadastrado com sucesso'];
    } else {
        return ['status' => false, 'message' => 'Falha ao registrar projeto: ' . $stmt->error];
    } 
}

function cadastrarBolsaProjeto($bolsaDescricao, $bolsaRequisitos, $conexao) {
    
    // Verificar se a conexão é válida
    if ($conexao === null) {
        return ['status' => false, 'message' => 'Conexão inválida.'];
    }

    $insert_script = "INSERT INTO TB_PROJETO (BOLSA_DESCRICAO, BOLSA_REQUISITOS) VALUES (?, ?)";

    // Preparar e executar a query de forma segura
    $stmt = $conexao->prepare($insert_script);
    
    if ($stmt === false) {
        return ['status' => false, 'message' => 'Erro ao preparar a query: ' . $conexao->error];
    }

    $stmt->bind_param("ss", $bolsaDescricao, $bolsaRequisitos);
    
    if ($stmt->execute()) {
        $stmt->close(); // Fechar o stmt
        return ['status' => true];
    } else {
        return ['status' => false, 'message' => 'Falha ao registrar bolsa do projeto: ' . $stmt->error];
    } 
}


?>
