$(document).ready(function () {
    $('#buttonLogin').on('click', function () {
        if(!validateInputs($('#inputEmail').val(), $('#inputPassword').val())) {
            return;
        }

        $.ajax({
            url: `${url_login}`,
            type: 'POST',
            data: {
                email: $('#inputEmail').val(),
                password: $('#inputPassword').val(),
                _token: $('input[name=_token]').val()
            },
            success: function (data, textStatus, jqXHR) {
                if(jqXHR.getResponseHeader('Content-Type') === 'application/json') {
                    if(data.status === 'success') {
                        location.reload();
                    }
                } else {
                    $('#errorText').text(data.message);
                    $('#buttonLogin').attr('disabled', false);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#errorText').text(jqXHR.status + ': ' + jqXHR.responseJSON.message);
                $('#buttonLogin').attr('disabled', false);
            },
        })
    });
});

function validateInputs(email, password) {
    var reEmail = /\S+@\S+\.\S+/;

    if(reEmail.test(email)) {
        $('#validation-email').attr('hidden', true);
    } else {
        $('#validation-email').attr('hidden', false);
        return false;
    }

    if(password.length >= 8 && password.length <= 16) {
        $('#validation-password-length').attr('hidden', true);
    } else {
        $('#validation-password-length').attr('hidden', false);
        return false;
    }

    return true;
}

