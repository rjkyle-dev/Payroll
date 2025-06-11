document.addEventListener('DOMContentLoaded', function () {
    // Initialize AOS (Make sure AOS library is included in HTML before this script)
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            offset: 70,
            easing: 'ease-in-out',
            once: true
        });
    }

    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    if (togglePassword && passwordField) {
        togglePassword.addEventListener('click', function () {
            const icon = this.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    }

    // Show spinner and change button text when form is submitted
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function (e) {
            if (form.checkValidity()) {
                const spinner = document.getElementById('spinner');
                const loginText = document.getElementById('loginText');
                const loggingInText = document.getElementById('loggingInText');

                if (spinner && loginText && loggingInText) {
                    spinner.classList.remove('hidden');
                    loginText.classList.add('hidden');
                    loggingInText.classList.remove('hidden');
                }
            } else {
                e.preventDefault();
                form.reportValidity();
            }
        });
    }

    // Fade out error messages
    const errorMessage = document.getElementById('errorMessage');
    if (errorMessage) {
        setTimeout(() => {
            errorMessage.classList.add('fade-out');
            errorMessage.addEventListener('transitionend', () => {
                errorMessage.remove();
                if (typeof AOS !== 'undefined') AOS.refresh();
            }, { once: true });
        }, 3000);
    }
});
