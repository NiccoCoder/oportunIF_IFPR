//Função para validar o email Docente 
function validarEmailDocente(userEmail) {
    
    //Regex para Dicentes que espera um padrão (nome.sobrenome.@ifpr.edu.br)
    const emailRegexToDocentes = /.+[.].+[@]....+[.]...+[.]../;
    const email = document.getElementById(userEmail).value;

    //condição para evitar que o Email seja nulo ou vazio
    if(!email) {
        return alert('O campo Email é obrigatório');
    } 
    
    if (emailRegexToDocentes.test(email) !== true) {
        return alert('O email informado não esta em um formato válido.  ex:XXXX.XXXX@XXXX.XXX ');
    }
    
return true;
}

//Função para validar o email Discente 
function validarEmailDiscente(userEmail) {

    //Regex para Dicentes que espera um padrão (algumaCoisa.@algumacoisa.com)
    const emailRegexToDiscentes = /.+[@].+[.].../;
    const email = document.getElementById(userEmail).value;
    
    //condição para evitar que o Email seja nulo ou vazio
    if(!email) {
        return alert('O campo Email é obrigatório para docentes');
    }

    if(emailRegexToDiscentes.test(email) !== true) {
        return alert('O email informado não esta em um formato válido. ex:XXXXXXXX@XXXX.XXX ');
    } 

return true;
}