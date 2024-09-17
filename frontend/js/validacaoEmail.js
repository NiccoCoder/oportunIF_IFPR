//Função para validar o email Docente 
function validarEmailDocente(userEmail) {
    
    //Regex para Dicentes que espera um padrão (nome.sobrenome.@ifpr.edu.br)
    const emailRegexToDocentes = /.+[.].+[@]ifpr+[.]edu+[.]br/;
    const email = document.getElementById(userEmail).value;
    
    //condição para evitar que o Email seja nulo ou vazio
    if(!email) {
        return alert('O campo Email é obrigatório');
    } 
    
    if (emailRegexToDocentes.test(email) !== true) {
        alert('O email informado precisa ser institucional.  ex: nome.sobrenome@ifpr.edu.br ');
        return false;
    }
    
    return true;
}

//Função para validar o email Discente 
function validarEmailDiscente(userEmail) {

    //Regex para Dicentes que espera um padrão (algumaCoisa.@algumacoisa.com)
    const emailRegexToDiscentes = /^\d{11}@estudantes\.ifpr\.edu\.br$/;
    const email = document.getElementById(userEmail).value;
    
    //condição para evitar que o Email seja nulo ou vazio
    if(!email) {
        alert('O campo Email é obrigatório para docentes');
        return false;
    }

    if(emailRegexToDiscentes.test(email) !== true) {
        alert('O email informado prescisa ser institucional. ');
        return false;
    } 

return true;
}