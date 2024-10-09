function verificarSessao() {
    document.getElementById("loader").style.display = "block"; // Mostra o loader

    fetch('../../backend/verificaSessao.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById("loader").style.display = "none"; // Esconde o loader

            if (!data.sessaoAtiva) {
                window.location.href = './login.html?error=' + encodeURIComponent('Você precisa estar logado para acessar esta página.');
            } else {
                document.getElementById("content").style.display = "block"; // Mostra o conteúdo se a sessão estiver ativa
            }
        })
        .catch(error => {
            console.error(error);
            document.getElementById("loader").style.display = "none"; // Esconde o loader em caso de erro
        });
}

document.addEventListener("DOMContentLoaded", verificarSessao);
