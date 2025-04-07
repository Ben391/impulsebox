<div class="container py-md-5 py-0">
	<div class="row justify-content-center">
		<form id="form-data" class="col-md-8 p-4 mb-3 bg-light-grey rounded-4">
			<h1 class="text-center mb-4">Formular per Post erhalten</h1>
			<div class="row justify-content-center mb-3">
				<h2 class="h4 text-center mb-3">An wen soll das Formular verschickt werden?</h2>
				<div class="col-8">
					<select class="form-select form-select-lg mb-3" name="delivery" required>
						<option value="" selected disabled>Bitte auswählen</option>
						<option value="1" <?php if(isset($delivery) AND $delivery == 1) echo 'selected'; ?>>An den Versicherten</option>
						<?php if(isset($care_giver_person_id) AND !empty($care_giver_person_id)) { ?>
						<option value="2" <?php if(isset($delivery) AND $delivery == 2) echo 'selected'; ?>>An Pflegeperson</option>
						<?php } ?>
						<?php if(isset($care_giver_service_id) AND !empty($care_giver_service_id)) { ?>
						<option value="3" <?php if(isset($delivery) AND $delivery == 3) echo 'selected'; ?>>An einen beauftragten Pflegedienst</option>
						<?php } ?>
					</select>
					<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_DELIVERY ?></div>
				</div>
				<div class="col-8">
					<?php
					$displayBlocks = [
						"insured-person-address-block" => ($delivery == 1),
						"care-giver-person-address-block" => ($delivery == 2),
						"care-giver-service-address-block" => ($delivery == 3),
					];
					?>
					<div id="insured-person-address-block" class="px-3 mb-3">
						<div><?php echo $insured_person_first_name." ".$insured_person_last_name ?></div>
						<div><?php echo $insured_person_street ?></div>
						<div><?php echo $insured_person_zipcode." ".$insured_person_city ?></div>
					</div>
					<div id="care-giver-person-address-block" class="px-3 mb-3">
						<div><?php echo $care_giver_person_first_name." ".$care_giver_person_last_name ?></div>
						<div><?php echo $care_giver_person_street ?></div>
						<div><?php echo $care_giver_person_zipcode." ".$care_giver_person_city ?></div>
					</div>
					<div id="care-giver-service-address-block" class="px-3 mb-3">
						<div><?php echo $care_giver_service_company ?></div>
						<div><?php echo $care_giver_service_street ?></div>
						<div><?php echo $care_giver_service_zipcode." ".$care_giver_service_city ?></div>
					</div>
				</div>
			</div>
			<div class="row text-center">
				<div class="col-12">
					<input type="hidden" name="entry_id" value="<?php echo $entry_id ?>">
					<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
					<input type="hidden" name="user_email" value="<?php echo $user_email ?>">
					<input type="hidden" name="insurance_type" value="<?php echo $insurance_type ?>">
					<button name="proceed" class="custom-btn custom-btn-md <?php echo BTN_PRIMARY ?>">
						<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
						<span class="btn-text">Antrag per Post anfordern</span>
					</button>
				</div>
				<div class="col-12 text-center font-weight-400 mb-3">
					<div id="message" class="mt-md-4 mt-3" style="display: none"></div>
				</div>
				<div class="col-12 text-center mb-3 fs-1125 text-muted">oder</div>
				<div class="col-12 text-center mb-3">
					<a class="custom-btn custom-btn-md <?php echo BTN_GRADIENT ?>" href="<?php echo BASEHREF ?>unterschrift/">
						<i class="fa-solid fa-file-signature fa-lg me-3"></i> 
						Jetzt digital unterschreiben
					</a>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
$(document).ready(function() {
	function toggleBlocks(selectedValue) {
		// Alle Blöcke ausblenden
		$("#insured-person-address-block, #care-giver-person-address-block, #care-giver-service-address-block").hide();

		// Den entsprechenden Block anzeigen
		if (selectedValue == 1) {
			$("#insured-person-address-block").show();
		} else if (selectedValue == 2) {
			$("#care-giver-person-address-block").show();
		} else if (selectedValue == 3) {
			$("#care-giver-service-address-block").show();
		}
	}
    // Initialisierung beim Laden der Seite
    toggleBlocks($("select[name='delivery']").val());
	
    // Listener für die Änderung der Auswahl
    $("select[name='delivery']").change(function() {
        toggleBlocks($(this).val());
    });
	var form = $('#form-data');
    $("button[name='proceed']").on('click', function(e) {
        e.preventDefault(); // Verhindert das Standard-Formularabsenden

		if (form[0].checkValidity() === false) {
			e.stopPropagation();
		}
		
		form.addClass('was-validated');

		if (form[0].checkValidity()) {
			var clickedButton = $(this);
			clickedButton.find('.spinner-border').show();
			clickedButton.find('.btn-text').hide();
			$.ajax({
				url: 'pages/application/request-by-post/send-request-by-post.php',
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