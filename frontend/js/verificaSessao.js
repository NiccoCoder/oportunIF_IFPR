fetch('verifica_sessao.php')  
    .then(response => response.json())  
    .then(data => {  
        if (data.sessaoAtiva) {  
            console.log("Sessão ativa");  
        } else {  
            console.log("Sessão não está ativa");  
        }  
    })  
    .catch(error => console.error('Erro:', error));