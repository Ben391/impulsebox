<div class="container">
	<div class="row">
		<div class="col-md-7 px-md-2 px-1 mb-3">
			<form id="form-data" class="p-md-4 p-3 mb-3 bg-light-grey rounded-4">
				<h1 class="h2 mb-md-4 mb-2">Beratung</h1>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="consultation-status" value="1" id="consultation1" <?php if($consultation_status == 1) echo "checked"; ?> required>
					<label class="form-check-label" for="consultation1">
					Ich wurde vor der Übergabe des Pflegehilfsmittels/der Pflegehilfsmittel von <?php echo $company["servicename"] ?> (<?php echo $company["company"] ?>) umfassend beraten, insbesondere darüber
					</label>
					<ul>
						<li>welche Produkte und Versorgungsmöglichkeiten für meine konkrete Versorgungssituation geeignet und notwendig sind,</li>
						<li>die ich ohne Mehrkosten erhalten kann.</li>
					</ul>
				</div>
				<div id="consultation-data" class="mb-3">
					<div class="mb-4" id="consultation-form">
						<h2 class="h5">Form des Beratungsgesprächs:</h2>
						<div class="form-check">
							<input class="form-check-input consultation-form-check" type="checkbox" value="1" id="consultation-form-1" name="consultation-form[]" <?php if(isset($consultation_form)) { if(in_array('1', explode(',', $consultation_form))) echo "checked"; } ?>>
							<label class="form-check-label" for="consultation-form-1">
								Beratung in den Geschäftsräumen
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input consultation-form-check" type="checkbox" value="2" id="consultation-form-2" name="consultation-form[]" <?php if(isset($consultation_form)) { if(in_array('2', explode(',', $consultation_form))) echo "checked"; }  ?>>
							<label class="form-check-label" for="consultation-form-2">
								Individuelle telefonische oder digitale Beratung (z. B. Videochat)
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input consultation-form-check" type="checkbox" value="3" id="consultation-form-3" name="consultation-form[]" <?php if(isset($consultation_form)) { if(in_array('3', explode(',', $consultation_form))) echo "checked"; } ?>>
							<label class="form-check-label" for="consultation-form-3">
								Beratung in der Häuslichkeit
							</label>
						</div>
						<div class="invalid-feedback">Bitte wählen Sie mindestens eine Option.</div>
					</div>
					<div class="mb-4" id="consultation-partner">
						<h2 class="h5"><?php echo $company["servicename"] ?> (<?php echo $company["company"] ?>) hat</h2>
						<div class="form-check">
							<input class="form-check-input consultation-partner-check" type="checkbox" value="1" id="consultation-partner-1" name="consultation-partner[]" <?php if(isset($consultation_partner)) { if(in_array('1', explode(',', $consultation_partner))) echo "checked"; } ?>>
							<label class="form-check-label">
							mich persönlich und/oder
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input consultation-partner-check" type="checkbox" value="2" id="consultation-partner-2" name="consultation-partner[]" <?php if(isset($consultation_partner)) { if(in_array('2', explode(',', $consultation_partner))) echo "checked"; } ?>>
							<label class="form-check-label">
							meine Betreuungsperson (ges. Vertreter/Bevollmächtigten oder Angehörigen)
							</label>
						</div>
						<h2 class="h5">beraten.</h2>
						<div class="invalid-feedback">Bitte wählen Sie mindestens eine Option.</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-8 col-12 mb-3">
							<label class="form-label">Beratende/r Mitarbeiter/in</label>
							<input 
								   minlength="1" 
								   pattern="[a-zA-ZäöüÄÖÜß- ]+"
								   maxlength="60" 
								   type="text" 
								   class="form-control form-control-lg" 
								   name="consultant" 
								   id="consultant" 
								   value="<?php echo $consultation_consultant ?>">
							<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_CONSULTANT ?></div>
						</div>
						<div class="col-md-4 col-12 mb-3">
							<label class="form-label">Datum der Beratung</label>
							<input 
							   minlength="10"
							   maxlength="10" 
							   placeholder="TT.MM.JJJJ" 
							   type="text" 
							   class="form-control form-control-lg" 
							   name="consultation_date" 
							   id="consultation_date" 
							   value="<?php echo $consultation_date_formatted ?>">
						</div>
					</div>
				</div>
				<div class="form-check mb-4">
					<input class="form-check-input" type="radio" name="consultation-status" value="0" id="consultation" <?php if(isset($consultation_status) AND $consultation_status == 0) echo "checked"; ?> required>
					<label class="form-check-label" for="consultation">
					Ich bin ausreichend über die Produkte, deren Anwendung und den Zweck der Pflegehilfsmittel zum Verbrauch informiert und möchte keine zusätzliche Beratung wahrnehmen.
					</label>
				</div>
				<?php require_once "buttons.php"; ?>
			</form>
		</div>
		<div class="col-md-5 px-md-2 px-1 mb-md-3 mb-2 order-md-last order-first">
			<?php include_once "views/your-box.php" ?>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	
	var previous_length_date = 0;
	
    $("#consultation_date").on('input', function() {
        var input = $(this).val().replace(/\D/g, ''); // Nur Zahlen behalten
        var newInput = '';
        
        if (input.length > 8) {
            input = input.substring(0, 8); // Maximale Länge von 8 Ziffern
        }
        
        for (var i = 0; i < input.length; i++) {
            if (i === 2 || i === 4) {
                newInput += '.';
            }
            newInput += input[i];
        }

        // Nur einen Punkt hinzufügen, wenn die Eingabe verlängert wird
        if (input.length > previous_length_date) {
            if (input.length === 2 || input.length === 4) {
                newInput += '.';
            }
        }

        $(this).val(newInput);
        previous_length_date = input.length; // Aktualisieren der gespeicherten Länge für den nächsten Durchlauf
    });
	
    function toggleConsultantRequired() {
        if ($('#consultation1').is(':checked')) {
            $('#consultant').attr('required', true);
            $('#consultation-data').slideDown();
        } else {
            $('#consultant').removeAttr('required');
            $('#consultation-data').slideUp();
        }
    }

    function validateConsultationPartner() {
        if ($('#consultation1').is(':checked')) {
            var isChecked = $('.consultation-partner-check:checked').length > 0;
            if (!isChecked) {
                $('#consultation-partner .invalid-feedback').show();
                return false;
            } else {
                $('#consultation-partner .invalid-feedback').hide();
            }
        }
        return true;
    }
	
    function validateConsultationForm() {
        if ($('#consultation1').is(':checked')) {
            var isChecked = $('.consultation-form-check:checked').length > 0;
            if (!isChecked) {
                $('#consultation-form .invalid-feedback').show();
                return false;
            } else {
                $('#consultation-form .invalid-feedback').hide();
            }
        }
        return true;
    }

    // Initial check on page load
    toggleConsultantRequired();

    // Check when the consultation status changes
    $('input[name="consultation-status"]').change(function() {
        toggleConsultantRequired();
    });

    var form = $('#form-data');
    $("button[name='proceed']").on('click', function(e) {
        e.preventDefault();
		
        if (form[0].checkValidity() === false || !validateConsultationForm() || !validateConsultationPartner()) {
            e.stopPropagation();
        }
        
        form.addClass('was-validated');

        if (form[0].checkValidity() && validateConsultationForm() && validateConsultationPartner()) {
            var clickedButton = $(this);
            clickedButton.find('.spinner-border').show();
            clickedButton.find('.btn-text').hide();

            $.ajax({
                url: 'pages/application/consultation/save.php',
                type: 'post',
                data: $(this).closest('form').serialize(),

                success: function(response) {
                    if (response.success) {
                        $('#message').text(response.message).addClass('text-success').show();
                        setTimeout(function() {
                            window.location.href = '<?php echo $next_page_url ?>';
                        }, 1000);
                    } else {
                        $('#message').text(response.message + "\nDetails: " + response.details).addClass('text-danger').show();
                        clickedButton.find('.spinner-border').hide();
                        clickedButton.find('.btn-text').show();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#message').text('Ein Fehler ist beim Senden aufgetreten. Status: ' + textStatus + '. Fehler: ' + errorThrown).addClass('text-danger').show();
                    clickedButton.find('.spinner-border').hide();
                    clickedButton.find('.btn-text').show();
                }
            });
        }
    });
	
});
</script>
