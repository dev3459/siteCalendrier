/*modal window with calendar*/
$('#btnOpen').click(function () {
    $('#modal-1').style.display = 'flex';
})

$('#modal-1').modal({
    closeExisting: false
});

/*calendar*/
let months = [
    'Janvier',
    'Février',
    'Mars',
    'Avril',
    'Mai',
    'Juin',
    'Juillet',
    'Août',
    'Septembre',
    'Octobre',
    'Novembre',
    'Décembre'
];

let days = [
    'ld',
    'md',
    'mcd',
    'jd',
    'vdd',
    'smd',
    'dmc'
];




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

