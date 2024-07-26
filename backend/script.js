function validarEmail(userEmail){
    const regex = /.+[@][A-za-z]+[.].../;
    const email = document.getElementById(userEmail).value;

    alert(regex.test(email));
}