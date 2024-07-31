//Função para comparar o dado email de Docente e Aluno usando Expressões Regulares
function validarEmailDocente(userEmail){
    //Regex para Dicentes que espera um padrão (algumaCoisa.@algumacoisa.com)
    const EmailRegexToDicentes = /.+[@].+[.].../;
    //Regex para Dicentes que espera um padrão (nome.sobrenome.@ifpr.edu.br)
    const EmailRegexToDocentes = /.+[.].+[@]....+[.]...+[.]../;
    const email = document.getElementById(userEmail).value;
    //condição para evitar que o Email seja nulo ou vazio
    if(!userEmail) {
        return ('O campo Email é obrigatório');
    } 
     if (EmailRegexToDocentes.test(email) !== true) {
        return alert('O email informado não esta em um formato válido.  ex:XXXX.XXXX@XXXX.XXX ');
    }
return alert('Passei');
}
function validarEmailDicente(userEmail){
    //Regex para Dicentes que espera um padrão (algumaCoisa.@algumacoisa.com)
    const EmailRegexToDicentes = /.+[@].+[.].../;
    //Regex para Dicentes que espera um padrão (nome.sobrenome.@ifpr.edu.br)
    const EmailRegexToDocentes = /.+[.].+[@]....+[.]...+[.]../;
    const email = document.getElementById(userEmail).value;
    //condição para evitar que o Email seja nulo ou vazio
    if(!userEmail) {
        return ('O campo Email é obrigatório');
    }

    if(EmailRegexToDicentes.test(email) !== true) {
        return alert('O email informado não esta em um formato válido. ex:XXXXXXXX@XXXX.XXX ');
    } 

return alert('Passei');
}