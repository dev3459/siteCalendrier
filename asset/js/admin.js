// Initiate datatables in roles, tables, users page
$('#dataTables-example').DataTable({
    responsive: true,
    pageLength: 20,
    lengthChange: false,
    searching: true,
    ordering: true
});


// Toggle sidebar on Menu button click
$('#sidebarCollapse').on('click', function() {
    $('#sidebar').toggleClass('active');
    $('#body').toggleClass('active');
});

// Auto-hide sidebar on window resize if window size is small
$(window).on('resize', function () {
     if ($(window).width() <= 768) {
         $('#sidebar, #body').addClass('active');
     }
});

// Starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                // Checking emails fields.
                const mails = form.querySelectorAll('input[type="email"]');
                let pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                mails.forEach(mailInput => {
                    const msg = mailInput.parentElement.querySelector('.invalid-feedback');
                    if(!pattern.test(mailInput.value)) {
                        msg.style.display = 'block';
                        mailInput.setCustomValidity(msg.innerText);
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    else {
                        msg.style.display = 'none';
                        mailInput.setCustomValidity('');
                    }
                });

                // Checking password fields.
                const password = form.querySelector('#password');
                const passwordRepeat = form.querySelector('#passwordConfirm');
                const passwordMsg = password.parentElement.querySelector('.invalid-feedback');
                pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,30}$/;

                password.addEventListener('keyup', () => {
                    password.setCustomValidity('');
                    if(password.value.length > 0) {
                        if(!pattern.test(password.value)) {
                            passwordMsg.style.display = 'block';
                            password.setCustomValidity(passwordMsg.innerText);
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        else {
                            passwordMsg.style.display = 'none';
                            password.setCustomValidity('');
                        }
                    }
                });

                const passwordRepeatMsg = passwordRepeat.parentElement.querySelector('.invalid-feedback');
                // Checking password matching.
                passwordRepeat.addEventListener('keyup', () => {
                    passwordRepeat.setCustomValidity('');
                    if(passwordRepeat.value.length > 0) {
                        if(passwordRepeat.value === passwordRepeat.value) {
                            passwordRepeatMsg.style.display = 'none';
                            passwordRepeat.setCustomValidity('');
                        }
                        else {
                            passwordRepeatMsg.style.display = 'block';
                            passwordRepeat.setCustomValidity(passwordRepeatMsg.innerText);
                            event.preventDefault();
                            event.stopPropagation();
                        }
                    }
                });

                // Checking phone fields.
                const phones = form.querySelectorAll('input[type="tel"]');
                pattern = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/i;
                phones.forEach(phoneInput => {
                    const msg = phoneInput.parentElement.querySelector('.invalid-feedback');
                    if(!pattern.test(phoneInput.value)) {
                        msg.style.display = 'block';
                        phoneInput.setCustomValidity(msg.innerText);
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    else {
                        msg.style.display = 'none';
                        phoneInput.setCustomValidity('');
                    }
                });

                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();