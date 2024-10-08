let nomeUsuarioAtual; 

function atualizarNomeUsuario() {
    fetch('../../backend/verificaSessao.php')
        .then(response => response.json())
        .then(data => {
            const nomeElemento = document.getElementById('nomeUsuario'); // Obtenha o elemento aqui

            if (data.sessaoAtiva) {
                const nomeUsuario = data.user.nome;

                // Verifica se o nome do usuário mudou
                if (nomeUsuario !== nomeUsuarioAtual) {
                    nomeUsuarioAtual = nomeUsuario; // Atualiza a variável global
                    nomeElemento.textContent = nomeUsuario; // Atualiza o texto do elemento
                }
            } else {
                window.location.href = './login.html';  // Mensagem padrão
            }
        })
        .catch(error => console.error('Erro ao obter o nome do usuário:', error));
}

document.addEventListener("DOMContentLoaded", atualizarNomeUsuario);
