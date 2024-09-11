<?php
    echo "Paginas:"
?>
<!DOCTYPE html>
<style>
      body {
        background-color: #2f9e41;
        font-family: Arial, sans-serif;
        text-align: center;
        margin: 0;
        display: flex;
        /* justify-content: center; */
        align-items: center;
        height:100vh;
      }
      a {
        margin: 10px;
        border: 2px solid green;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 5px;
        transition: all 0.3s ease;
        border-color: #fff;
      }
      a:hover {
        background-color: green;
        color: #fff;
        border-color: #fff;
      }
</style>
<html>
    <body>
        <br>
        <a href = "./backend/config.php">Testar conexão com o BD</a>
        <br>
        <a href="./frontend/pages/cadastroProfessor.html">Cadastro: Docente</a>
        <br>
        <a href = "./frontend/pages/cadastroAluno.html">Cadastro: Discente</a>
        <br>
        <a href = "./backend/enviar_email.php">Enviar email</a>
        <br>
        <a href = "./frontend/pages/logindocente.html">Login: Docente</a>
        <br>
        <a href = "./frontend/pages/paginavisitante.html">Visualização Projetos</a>
        <br>
        <a href = "./frontend/pages/paginadebolsavisitante.html">Pagina de bolsa (visitante)</a>
        <br>
        <a href = "./frontend/pages/projetoEditar.html">Pagina editar projetos (Docente) </a>
        <br>
        <a href = "./frontend/pages/projetoVisualizar.html">Pagina visualizar projetos </a>
        <br>
        <a href = "./frontend/pages/teladereport.html">Pagina report</a>
        <br>
        <a href = "./frontend/pages/paginagerenciamento.html">Pagina Gerenciamento</a>
        
    </body>
<html>