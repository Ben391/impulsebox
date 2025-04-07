<div class="container">
	<div class="row">
		<div class="col-md-7 px-md-2 px-1 mb-3">
			<form id="form-data" class="p-md-4 p-3 mb-3 bg-light-grey rounded-4">
				<h1 class="h2 mb-md-4 mb-2">Konto erstellen</h3>
				<?php 
				include_once "inc/user_type.php";
				include_once "inc/email.php";
				include_once "inc/agreements.php";
				?>
				<div class="row">
					<?php
					if(!isset($entry_data)) {
						include_once "inc/proceed_create_account.php";
					} else {
						include_once "inc/proceed_update_account.php";
					}
					?>
					<div class="col-12 text-center font-weight-400">
						<div id="message" class="mt-md-4 mt-3" style="display: none"></div>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-5 px-md-2 px-1 mb-md-3 mb-2 order-md-last order-first"><?php include_once "views/your-box.php" ?></div>
	</div>
</div>
<script>
$(document).ready(function() {	
    // Funktion zur Überprüfung der E-Mail-Adresse
    function checkEmailMatch() {
        var email = $('#user_email').val();
        var confirmEmail = $('#confirm_user_email').val();
        if (email !== confirmEmail) {
            $('#message').text('Die E-Mail-Adressen stimmen nicht überein').addClass('text-danger').show();
            return false;
        } else {
            $('#message').text('').hide();
            return true;
        }
    }
	
    // Erscheinen des Eingabefeldes zum Bestätigen der E-Mail-Adresse
    $('#user_email').on('input', function() {
        if ($(this).val().length > 0) {
            $('#confirm-email-row').show();
        } else {
            $('#confirm-email-row').hide();
        }
    });
	var form = $('#form-data');
    $("button[name='proceed']").on('click', function(e) {
        e.preventDefault();
		
        if ($(form)[0].checkValidity() === false || !checkEmailMatch()) {
            e.stopPropagation();
            $(form).addClass('was-validated');
            return;
        }
		
        form.addClass('was-validated');
        if (form[0].checkValidity()) {
			var clickedButton = $(this);
            $.ajax({
                url: 'pages/application/create-account/save-create-account.php',
                type: 'post',
                dataType: 'json',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
						clickedButton.find('.spinner-border').show();
						clickedButton.find('.btn-text').hide();
                        $('#message').text(response.message).removeClass('text-danger').addClass('text-success').show();
                        setTimeout(function() {
                            window.location.href = "<?php echo $next_page_url ?>";
                        }, 1000);
                    } else {
						clickedButton.find('.btn-text').hide();
						clickedButton.find('.fa-triangle-exclamation').show();
						clickedButton.removeClass('custom-btn-primary').addClass('custom-btn-danger');
                        $('#message').text(response.message + response.details).addClass('text-danger').show();
						setTimeout(function() {
							clickedButton.find('.btn-text').show();
							clickedButton.find('.fa-triangle-exclamation').hide();
							clickedButton.removeClass('custom-btn-danger').addClass('custom-btn-primary');
						}, 2000);
                    }
                },
               error: function(jqXHR, textStatus, errorThrown) {
				   $('#message').text('Ein Fehler ist beim Senden aufgetreten.'+textStatus + errorThrown).addClass('text-danger').show();
			   }
            });
        }
    });
});
</script>