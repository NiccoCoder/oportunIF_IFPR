// sessionCheck.js

function verificarSessao() {
    fetch('../../backend/verificaSessao.php')
    .then(response => response.json())
    .then(data => {        
        if (data.sessaoAtiva) {
                if (data.user.tipoUsuario === 'discente') {
                    // Se o usuário é um discente, redireciona para a página do discente
                    window.location.href = './discenteVisualizar.html'; 
                } else if (data.user.tipoUsuario === 'docente') {
                    // Se o usuário é docente, verifica o super usuário
                    if (data.user.superUsuario === 1) {
                        window.location.href = './superUsuarioPrincipal.html'; // Redireciona para a página de gerenciamento
                    } else {
                        window.location.href = './docenteVisualizar.html'; // Redireciona para a página do docente
                    }
                } else {
                    // Para outros tipos de usuário, redireciona para login com mensagem de erro
                    window.location.href = './login.html?error=' + encodeURIComponent('Acesso negado. Você não tem permissão para acessar esta página.');
                }
            }
        })
        .catch(error => {
            console.error(error);
            document.getElementById("loader").style.display = "none"; // Esconde o loader em caso de erro
        });
}

document.addEventListener("DOMContentLoaded", verificarSessao);
