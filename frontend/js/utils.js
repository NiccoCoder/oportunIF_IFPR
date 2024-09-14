// Função para mover automaticamente para o próximo input
function moveToNext(currentInput, nextInputId) {
    if (currentInput.value.length === 1) {
        document.getElementById(nextInputId).focus();
    }
}

// Exemplo de teste para verificar se o JS está carregando corretamente
// alert("JS carregado com sucesso!");
