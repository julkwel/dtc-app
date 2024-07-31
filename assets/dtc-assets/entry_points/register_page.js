require('../styles/register.css');

$(document).ready(function () {
    $('.toggle_password').on('click', function() {
        let passInput = $(this).closest('.form-group').find('.password-input');

        if (passInput && passInput.attr('type') === 'password') {
            passInput.attr('type', 'text');
            $(this).removeClass('bi-eye-fill').addClass('bi-eye-slash')
        } else {
            passInput.attr('type', 'password');
            $(this).removeClass('bi-eye-slash').addClass('bi-eye-fill')
        }
    })
})