/****************************************************************************
 **  JavaScript for disabling form submissions if there are invalid fields **
 ****************************************************************************/
// Fetch all the forms we want to apply custom Bootstrap validation styles to
const forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
var validation = Array.prototype.filter.call(forms, function(form) {
    form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }

        form.classList.add('was-validated');
    });
});


Array.prototype.filter.call(forms, function(form) {
    // Checking emails fields.
    const mails = form.querySelectorAll('input[type="email"]');
    const mailPattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if(mails) {
        const msg = mailInput.parentElement.querySelector('.invalid-feedback');

        mails.forEach(mailInput => {
            mailInput.setCustomValidity('');
            msg.style.display = 'none';

            mailInput.addEventListener('keyup', () => {
                if (!mailPattern.test(mailInput.value)) {
                    msg.style.display = 'block';
                    mailInput.setCustomValidity(msg.innerText);
                } else {
                    msg.style.display = 'none';
                    mailInput.setCustomValidity('');
                }
            });
        });
    }

    // Checking password fields.
    const password = form.querySelector('#password');
    const passwordRepeat = form.querySelector('#passwordConfirm');

    // Si un champs mot de passe existe.
    if(password) {
        // In user edition mode, password can be omitted.
        if (password.getAttribute('required') === true || password.getAttribute('required') === 'required') {
            const passwordMsg = password.parentElement.querySelector('.invalid-feedback');
            const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/;

            password.addEventListener('keyup', () => {
                password.setCustomValidity('');
                passwordMsg.style.display = 'none';
                if (password.value.length > 0) {
                    if (!passwordPattern.test(password.value)) {
                        console.log("Pattern does not match");
                        passwordMsg.style.display = 'block';
                        password.setCustomValidity(passwordMsg.innerText);
                    }
                }
            });

            // Si la confirmation du mot de passe existe.
            if(passwordRepeat) {
                const passwordRepeatMsg = passwordRepeat.parentElement.querySelector('.invalid-feedback');
                // Checking password matching.
                passwordRepeat.addEventListener('keyup', () => {
                    passwordRepeat.setCustomValidity('');
                    if (passwordRepeat.value.length > 0) {
                        if (passwordRepeat.value === passwordRepeat.value) {
                            passwordRepeatMsg.style.display = 'none';
                            passwordRepeat.setCustomValidity('');
                        } else {
                            passwordRepeatMsg.style.display = 'block';
                            passwordRepeat.setCustomValidity(passwordRepeatMsg.innerText);
                        }
                    }
                });
            }
        }
    }

    // Checking phone fields.
    const phones = form.querySelectorAll('input[type="tel"]');
    const phonePattern = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/i;
    phones.forEach(phoneInput => {
        const msg = phoneInput.parentElement.querySelector('.invalid-feedback');
        if(!phonePattern.test(phoneInput.value)) {
            msg.style.display = 'block';
            phoneInput.setCustomValidity(msg.innerText);
        }
        else {
            msg.style.display = 'none';
            phoneInput.setCustomValidity('');
        }
    });
});
