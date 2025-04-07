<div class="container py-5">
	<div class="row justify-content-center py-5">
		<div class="col-md-4 text-center">
			<form class="form p-md-4 p-3 mb-3 bg-light-grey rounded-4" id="forgotPasswordForm">
				<h1 class="h3 mb-4">Passwort zurücksetzen</h1>
				<div class="col mb-4">
					<input class="form-control form-control-lg" type="email" id="email" name="email" placeholder="Ihre E-Mail-Adresse" for="email" required>
					<?php if (defined('IS_ADMIN') AND IS_ADMIN === true): ?>
					<input type="hidden" id="admin_area" value="1">
					<?php endif; ?>
				</div>
				<div class="col">
					<button type="submit" class="custom-btn custom-btn-md <?php echo BTN_PRIMARY ?> w-100">
						<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
						<span class="btn-text">Zurücksetzungslink senden</span>
					</button>
					<script src="https://www.google.com/recaptcha/api.js?render=<?php echo PUBLIC_KEY ?>"></script>
				</div>
				<div class="col-12 text-center font-weight-400">
					<div id="message" class="mt-md-4 mt-3 mb-3" style="display: none"></div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
    $("#forgotPasswordForm").submit(function(e) {
        e.preventDefault();
        const email = $("#email").val();
		const admin_area = $("#admin_area").val() || null;

        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo PUBLIC_KEY ?>', {action: 'forgot_password'}).then(function(token) {
                // Füge das Token dem AJAX-Request hinzu
                $.ajax({
                    url: <?php $_SERVER['DOCUMENT_ROOT'] ?>'/pages/forgot_password/send_forgot_password.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ 
						email,
						admin_area: admin_area,
						recaptcha_token: token
					}),
					success: function(data) {
						//console.log("Antwortdaten: ", data);  // Zum Debuggen
						if (data && data.message) {
							$("#message").show().html(data.message);
						} else {
							 $("#message").show().addClass("text-danger").html("Unerwartete Serverantwort");
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						if (jqXHR.status === 500 && jqXHR.responseJSON && jqXHR.responseJSON.message) {
							$("#message").show().addClass("text-danger").html(jqXHR.responseJSON.message);
						} else {
							$("#message").show().addClass("text-danger").html("Fehler: " + textStatus + " " + errorThrown);
						}
					}
                });
            });
        });
    });
});
</script>