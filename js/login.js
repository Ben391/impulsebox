$(document).ready(function() {
    $('#loginForm').on('submit', function(event) {
        event.preventDefault();
        const email = $('#email').val();
        const password = $('#password').val();
		const role = $('#role').val();
        const login_button = $('#login_button');  // ID ist einzigartig, also direkt selektieren
		let ajax_url;
		let redirect_url;

		if (role == 2) {
			ajax_url = '../auth/login-handler.php';
			redirect_url = '/admin/';
		} else {
			ajax_url = 'auth/login-handler.php';
			redirect_url = '/konto/';
		}
        // reCAPTCHA v3 Token generieren
        grecaptcha.ready(function() {
            grecaptcha.execute(PUBLIC_KEY, {action: 'submit'}).then(function(token) {
                $.ajax({
                    url: ajax_url,
                    method: 'POST',
                    data: JSON.stringify({
                        email: email,
                        password: password,
						role: role,
                        'g-recaptcha-response': token
                    }),
                    contentType: 'application/json',
                    success: function(response) {
                        if (response.success) {
                            $('#message-login').show().addClass("text-success").text(response.message);
                            login_button.find('.spinner-border').show();
                            login_button.find('.btn-text').hide();
                            setTimeout(function() {
                                login_button.prop('disabled', false);
                                login_button.find('.spinner-border').hide();
                                login_button.find('.btn-text').show();
								window.location.href = redirect_url;
                            }, 1200);
                        } else {
                            $('#message-login').show().addClass("text-danger").text(response.message);
                            login_button.prop('disabled', false);
                            login_button.find('.spinner-border').hide();
                            login_button.find('.btn-text').show();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        const response = JSON.parse(jqXHR.responseText);
                        if (response && response.message) {
                            console.log("Serverantwort:", response.message);  // Detaillierte Fehlermeldung
                        } else {
                            console.log("Fehlerstatus:", textStatus);       // Allgemeiner Fehlerstatus, z.B. "timeout", "error", "abort" etc.
                            console.log("Fehlertext:", errorThrown);         // Der Text des aufgetretenen Fehlers, z.B. "Not Found" oder "Internal Server Error"
                        }
                        login_button.prop('disabled', false);
                        login_button.find('.spinner-border').hide();
                        login_button.find('.btn-text').show();
                        $('#message-login').show().addClass("text-danger").text('Ein Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.');
                    }
                });
            });
        });
    });
});