/*modal window with calendar*/

/* check password */
let password = document.getElementById("id-password");
let passwordConfirm = document.getElementById("passwordConfirm");

function checkPassword() {

    if(password.value !== passwordConfirm.value) {
        passwordConfirm.setCustomValidity("les mots de passe ne correspondent pas");
    }
    else {
        passwordConfirm.setCustomValidity('');
    }
    
}

password.addEventListener('change',checkPassword);
passwordConfirm.addEventListener('keyup',checkPassword);

