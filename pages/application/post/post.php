<div class="container">
	<div class="row justify-content-center">
		<form id="form-data" class="col-md-8 p-4 mb-3 bg-light-grey rounded-4">
			<h1 class="mb-4">Antrag per Post erhalten</h1>
			<div class="row mb-3">
				<div class="col">
					<h2 class="h5">Bestellformular und Antrag zur Kostenübernahme</h2>
					<p>Mit allen Angaben zu Ihren gewünschten Pflegehilfsmitteln und zur Genehmigung der Kostenübernahme durch die Pflegekasse des Versicherten.</p>
				</div>
			</div>
			<?php if(isset($supplier_change) AND !empty($supplier_change)) { ?>
			<div class="row mb-3">
				<div class="col">
					<h2 class="h5">Formular zum Wechsel des Versorgers</h2>
					<p>Zur Bearbeitung der Umversorgung mit Pflegehilfsmitteln von einem anderen Versorger zur curabox.</p>
				</div>
			</div>
			<?php } ?>
			<div class="row mb-3">
				<div class="col-12 mb-3">
					
				</div>
			</div>
			<div class="row text-center">
				<div class="col-12">
					<input type="hidden" name="entry_id" value="<?php echo $entry_id ?>">
					<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
					<input type="hidden" name="user_email" value="<?php echo $user_email ?>">
					<button name="submit-digital" class="custom-btn custom-btn-md <?php echo BTN_PRIMARY ?>">
						<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
						<span class="btn-text">Antrag per Post erhalten</span>
					</button>
				</div>
				<div id="message" class="col-12 d-flex align-items-center fs-1125 p-3" style="display: none;"></div>
			</div>
		</form>
	</div>
</div>
<script>
$(document).ready(function() {
	var form = $('#form-data');
	var clickedButton = $(this);
    $("button[name='submit-digital']").on('click', function(e) {
        e.preventDefault(); // Verhindert das Standard-Formularabsenden
		
		if (form[0].checkValidity() === false) {
			e.stopPropagation();
		}
		
		form.addClass('was-validated');

		if (form[0].checkValidity()) {
			$.ajax({
				url: 'pages/application/signature/complete-digital.php',
				type: 'post',
				dataType: 'json',
				data: form.serialize(),

				success: function(response) {
					if (response.success) {
						$('#message').text(response.message).addClass('text-success').show();
						setTimeout(function() {
							window.location.href = 'abschluss/';
						}, 1000);
					} else {
						console.log(response);
						$('#message').text(response.message + "\nDetails: " + response.details).addClass('text-danger').show();
						clickedButton.find('.spinner-border').hide();
						clickedButton.find('.btn-text').show();
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.error('Ein Fehler ist beim Senden aufgetreten. Status: ' + textStatus + '. Fehler: ' + errorThrown);
					$('#message').text('Ein Fehler ist beim Senden aufgetreten. Status: ' + textStatus + '. Fehler: ' + errorThrown).addClass('text-danger').show();
					clickedButton.find('.spinner-border').hide();
					clickedButton.find('.btn-text').show();
				}
			});
		}
    });
});
</script>
