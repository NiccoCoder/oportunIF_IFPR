function verificarSessao() {
    const loader = document.getElementById("loader");
    loader.style.display = "block"; // Mostra o loader

    fetch('../../backend/verificaSessao.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na resposta da rede');
            }
            return response.json();
        })
        .then(data => {
            loader.style.display = "none"; // Esconde o loader

            if (!data.sessaoAtiva) {
                // Se a sessão não está ativa, redireciona para login
                window.location.href = './login.html?error=' + encodeURIComponent('Você precisa estar logado para acessar esta página.');
            } else if (data.user.tipoUsuario === 'discente') {
                // Se o tipo de usuário for "discente"
                window.location.href = './discenteVisualizar.html';
            } else if (data.user.tipoUsuario === 'docente' && data.user.superUsuario === 1) {
                // Se o usuário é docente e é super usuário
                document.getElementById("content").style.display = "block"; // Mostra o conteúdo
            } else {
                // Para outros tipos de usuário ou docentes sem super usuário, redireciona
                document.getElementById("content").style.display = "block"; // Mostra o conteúdo
            }
        })
        .catch(error => {
            console.error('Erro ao verificar a sessão:', error);
            loader.style.display = "none"; // Esconde o loader em caso de erro
        });
}

document.addEventListener("DOMContentLoaded", verificarSessao);
