function verificarSessao() {
    document.getElementById("loader").style.display = "block"; // Mostra o loader
    fetch('../../backend/verificaSessao.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById("loader").style.display = "none"; // Esconde o loader
            
            if (!data.sessaoAtiva) {
                // Se a sessão não está ativa, redireciona para login
                window.location.href = './login.html?error=' + encodeURIComponent('Você precisa estar logado para acessar esta página.');
            } else if (data.user.tipoUsuario === 'discente') {
                // Se o usuário é um discente, mostra o conteúdo
                window.location.href = './discenteVisualizar.html'; // Redireciona para a página do discente
            } else if (data.user.tipoUsuario === 'docente') {
                // Se o usuário é docente, verifica o super usuário
                if (data.user.superUsuario === 1) {
                    // Docente com super usuário
                    document.getElementById("content").style.display = "block"; // Mostra o conteúdo
                } else {
                    // Docente sem super usuário, redireciona
                    window.location.href = './docenteVisualizar.html'; 
                }
            } else {
                // Para outros tipos de usuário, redireciona
                window.location.href = './login.html?error=' + encodeURIComponent('Acesso negado. Você não tem permissão para acessar esta página.');
            }
        })
        .catch(error => {
            console.error(error);
            document.getElementById("loader").style.display = "none"; // Esconde o loader em caso de erro
        });
}

document.addEventListener("DOMContentLoaded", verificarSessao);
