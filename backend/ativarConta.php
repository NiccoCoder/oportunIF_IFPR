<?php
include_once "config.php";
session_start();

$chave = htmlspecialchars(filter_input(INPUT_GET, "chave"));
$tipoUsuario = htmlspecialchars(filter_input(INPUT_GET, "tipoUsuario")); // Obtenha o tipo de usuário

if (!empty($chave) && !empty($tipoUsuario)) {
    // Defina a tabela com base no tipo de usuário
    $tabela = '';
    
    if ($tipoUsuario === 'docente') {
        $tabela = 'TB_DOCENTE';
    } elseif ($tipoUsuario === 'discente') {
        $tabela = 'TB_DISCENTE';
    } else {
        $_SESSION['menssagem'] = "<div class='alert alert-danger' role='alert'> Erro: Tipo de usuário inválido</div>";
        header("Location: ../../frontend/pages/login.html");
        exit();
    }

    // Comparação com a chave de acesso do Usuário
    $encontrarUsuario = "SELECT ID, CHAVE, SITUACAO FROM $tabela WHERE CHAVE = ? LIMIT 1"; // Use a tabela correta
    $resultado = $conexao->prepare($encontrarUsuario);
    $resultado->bind_param("s", $chave);
    $resultado->execute();
    $resultado->store_result();

    if ($resultado->num_rows != 0) {
        // Vincule as colunas retornadas às variáveis
        $resultado->bind_result($id, $chaveUsuario, $situacao);
        $resultado->fetch();

        // Atualização na tabela correta
        $validarUsuario = "UPDATE $tabela SET SITUACAO = 'Confirmado', CHAVE = NULL WHERE ID = ?";
        $updateUsuario = $conexao->prepare($validarUsuario);

        $updateUsuario->bind_param("i", $id); // 'i' para inteiro (ID)

        if ($updateUsuario->execute()) {
            $_SESSION['menssagem'] = "<div class='alert alert-success' role='alert'> Email confirmado!</div>";
            header("Location: ../../frontend/pages/login.html");
            exit();
        } else {
            $_SESSION['menssagem'] = "<div class='alert alert-danger' role='alert'> Erro: Email não confirmado</div>";
            header("Location: ../../frontend/pages/login.html");
            exit();
        }
    } else {
        $_SESSION['menssagem'] = "<div class='alert alert-danger' role='alert'> Erro: Endereço inválido</div>";
        header("Location: ../../frontend/pages/login.html");
        exit();
    }
} else {
    $_SESSION['menssagem'] = "<div class='alert alert-danger' role='alert'> Erro: Chave ou tipo de usuário não fornecidos</div>";
    header("Location: ../../frontend/pages/login.html");
    exit();
}
?>
