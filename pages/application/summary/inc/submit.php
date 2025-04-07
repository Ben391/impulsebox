<?php if($insurance_type == 2) { ?>
	<form class="row mb-0" id="form-data">
	<div class="col-12">
		<div class="form-check mb-3">
			<input class="form-check-input" type="checkbox" name="agb" value="1" required>
			<label class="form-check-label">
				Ich stimme den <a href="<?php echo BASEHREF.'agb/' ?>">Allgemeinen Geschäftsbedingungen</a> der <?php echo $company["company"] ?> zum Produkt <?php echo $company["servicename"] ?> zu und habe die Hinweise zum <a href="<?php echo BASEHREF.'widerrufsrecht/' ?>">Widerrufsrecht</a> zur Kenntnis genommen.
			</label>
		</div>
		<div class="form-check mb-3">
			<input class="form-check-input" type="checkbox" name="datenschutz" value="1" required>
			<label class="form-check-label">
				Ich stimme den <a href="<?php echo BASEHREF.'datenschutz/' ?>">Datenschutzhinweisen</a> sowie der Verarbeitung meiner Daten sowie meiner Angaben zu Pflegegrad und Pflege/Krankenkasse zu Bearbeitungs-, Beratungs- und Marketingzwecken und der Kontaktaufnahme per Telefon und E-Mail zu. Ein Widerruf ist jederzeit möglich.
			</label>
		</div>
		<div class="row">
			<div class="col-12">
				<input type="hidden" name="entry_id" value="<?php echo $entry_id ?>">
				<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
				<input type="hidden" name="user_email" value="<?php echo $user_email ?>">
				<input type="hidden" name="insurance_type" value="<?php echo $insurance_type ?>">
				<button name="submit-digital" class="custom-btn custom-btn-md <?php echo BTN_GRADIENT ?> w-100">
					<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
					<span class="btn-text">Jetzt kostenpflichtig bestellen</span>
				</button>
			</div>
			<div id="message" class="col-12 d-flex align-items-center fs-1125" style="display: none;"></div>
		</div>
	</div>
	</form>
	<script>
	$(document).ready(function() {
		var form = $('#form-data');
		$("button[name='submit-digital']").on('click', function(e) {
			e.preventDefault();
			
			if (form[0].checkValidity() === false) {
				e.stopPropagation();
			}

			form.addClass('was-validated');
			
			if (form[0].checkValidity()) {
				var clickedButton = $(this);
				clickedButton.find('.spinner-border').show();
				clickedButton.find('.btn-text').hide();
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
	<?php } else { ?>
	<div class="col-12">
		<div class="row">
			<div class="col-12 text-center mb-3">
				<a class="custom-btn custom-btn-md <?php echo BTN_GRADIENT ?> w-100" href="<?php echo BASEHREF ?>unterschrift/">
					<i class="fa-solid fa-file-signature fa-lg me-3"></i> 
					Jetzt digital unterschreiben
				</a>
			</div>
			<div class="col-12 text-center mb-3 fs-1125 text-muted">oder</div>
			<div class="col mb-3">
				<!-- TODO: Status markieren und zum Konto weiterleiten -->
				<a href="<?php echo BASEHREF ?>per-post-erhalten/" class="custom-btn custom-btn-md <?php echo BTN_OUTLINE_SECONDARY ?> w-100">
					<i class="fa-regular fa-envelope fa-lg me-2"></i>
					Formular <br>per Post erhalten
				</a>
			</div>
			<div class="col mb-3">
				<form id="pdf-save-download" action="<?php echo BASEHREF ?>inc/PDF/createPDF.php" method="GET">
					<!-- TODO: Formular generieren und speichern und zum Konto weiterleiten -->
					<button name="submit-download" class="custom-btn custom-btn-md <?php echo BTN_OUTLINE_SECONDARY ?> w-100">
						<i class="fa-solid fa-file-arrow-down fa-lg me-2"></i>
						Formular <br>als PDF speichern
					</button>
					<input type="hidden" name="entry_id" value="<?php echo $entry_id ?>">
					<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
					<input type="hidden" name="download_file" value="1">
				</form>
			</div>
			<div class="col mb-3">
				<form id="pdf-generate-print" target="_blank" action="<?php echo BASEHREF ?>inc/PDF/createPDF.php" method="get">
					<!-- TODO: Formular ohne Unterschrift generieren -->
					<button type="submit" name="submit-print" class="custom-btn custom-btn-md <?php echo BTN_OUTLINE_SECONDARY ?> w-100">
						<i class="fa-solid fa-print fa-lg me-2"></i>
						Formular <br>ausdrucken
					</button>
					<input type="hidden" id="file_name_input" name="file_name" value="test">
					<input type="hidden" name="entry_id" value="<?php echo $entry_id ?>">
					<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
				</form>
			</div>
		</div>
	</div>
	<?php } ?>
	
<script>
$(document).ready(function() {
	$("button[name='submit-download']").on('click', function(e) {
		$('#pdf-save-download').submit();
		e.preventDefault();
	});
	$("button[name='submit-print']").on('click', function(e) {
		$('#pdf-generate-print').submit();
		e.preventDefault();
	});
	
});
</script>