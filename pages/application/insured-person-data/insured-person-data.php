<div class="container">
	<div class="row">
		<div class="col-md-7 px-md-2 px-1 mb-3">
			<form id="form-data" class="p-md-4 p-3 mb-3 bg-light-grey rounded-4">
				<h1 class="h2 mb-md-4 mb-2">Versicherter <span class="opacity-75">/</span> Pflegebedürftiger</h1>
				<?php
				// salutation
				$input_salutation_attr_name_value = "insured_person_salutation";
				$input_salutation_attr_id_value = "insured_person_salutation";
				$input_salutation_attr_value_value = $insured_person_salutation;
				$input_salutation_required = " required ";
				include_once "views/form-elements/salutation.php";
				// first name
				$input_first_name_attr_name_value = "insured_person_first_name";
				$input_first_name_attr_id_value = "insured_person_first_name";
				$input_first_name_attr_value_value = $insured_person_first_name;
				$input_first_name_required = " required ";
				// last name
				$input_last_name_attr_name_value = "insured_person_last_name";
				$input_last_name_attr_id_value = "insured_person_last_name";
				$input_last_name_attr_value_value = $insured_person_last_name;
				$input_last_name_required = " required ";
				include_once "views/form-elements/name.php";
				// street
				$input_street_attr_name_value = "insured_person_street";
				$input_street_attr_id_value = "insured_person_street";
				$input_street_attr_value_value = $insured_person_street;
				$input_street_required = " required ";
				// address_addition
				$input_address_addition_attr_name_value = "insured_person_address_addition";
				$input_address_addition_attr_id_value = "insured_person_address_addition";
				$input_address_addition_attr_value_value = $insured_person_address_addition;
				$input_address_addition_required = "";
				include_once "views/form-elements/street.php";
				// zipcode
				$input_zipcode_attr_name_value = "insured_person_zipcode";
				$input_zipcode_attr_id_value = "insured_person_zipcode";
				$input_zipcode_attr_value_value = $insured_person_zipcode;
				$input_zipcode_required = " required ";
				// city
				$input_city_attr_name_value = "insured_person_city";
				$input_city_attr_id_value = "insured_person_city";
				$input_city_attr_value_value = $insured_person_city;
				$input_city_required = " required ";
				include_once "views/form-elements/zipcode_city.php";
				// birth date
				$input_birth_date_attr_name_value = "insured_person_birth_date";
				$input_birth_date_attr_id_value = "insured_person_birth_date";
				$input_birth_date_attr_value_value = $insured_person_birth_date;
				$input_birth_date_required = " required ";
				include_once "views/form-elements/birth_date.php";
				include_once "inc/insurance-company.php";
				include_once "inc/care-level.php";
				echo '<h2 class="h3 mb-3">Kontaktdaten</h2>';
				// phone
				$input_phone_attr_name_value = "insured_person_phone";
				$input_phone_attr_id_value = "insured_person_phone";
				$input_phone_attr_value_value = $insured_person_phone;
				$input_phone_required = " required ";
				$input_phone_required_asterisk = "*";
				// email
				$input_email_attr_name_value = "insured_person_email";
				$input_email_attr_id_value = "insured_person_email";
				$input_email_attr_value_value = $insured_person_email;
				$input_email_required = " required ";
				$input_email_required_asterisk = "";
				include_once "views/form-elements/contact.php";
				?>
				<div class="row">
					<div class="col-auto">
						<a class="custom-btn custom-btn-md <?php echo BTN_OUTLINE_SECONDARY ?>" href="<?php echo $back_page_url ?>">
							<span class="btn-text">
								<span class="">Zurück</span>
							</span>
						</a>
					</div>
					<div class="col text-end">
						<input type="hidden" id="insured_person_id" name="insured_person_id" value="<?php echo $insured_person_id ?>">
						<input type="hidden" id="insured_person_address_id" name="insured_person_address_id" value="<?php echo $insured_person_address_id ?>">
						<button name="proceed" class="custom-btn custom-btn-md <?php echo BTN_PRIMARY ?> w-md-100-custom">
							<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
							<span class="btn-text">
								<i class="fa-regular fa-circle-check fa-lg me-2"></i>
								<span class="d-md-inline-block d-none">Speichern und weiter</span>
								<span class="d-md-none d-inline-block">Speichern</span>
							</span>
						</button>
					</div>
					<div class="col-12 text-center font-weight-400">
						<div id="message" class="mt-md-4 mt-3" style="display: none"></div>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-5 px-md-2 px-1 mb-md-3 mb-2 order-md-last order-first"><?php include_once "views/your-box.php"; ?></div>
	</div>
</div>
<script>
$(document).ready(function() {
    // Auto-Punkt-Einfügung für das Geburtsdatumsfeld
	var previous_length_birth_date = 0; // Um die vorherige Länge der Eingabe zu speichern
	var previous_length_care_level_since = 0; // Für das #care_level_since Feld

    $("#insured_person_birth_date").on('input', function() {
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
        if (input.length > previous_length_birth_date) {
            if (input.length === 2 || input.length === 4) {
                newInput += '.';
            }
        }

        $(this).val(newInput);
        previous_length_birth_date = input.length; // Aktualisieren der gespeicherten Länge für den nächsten Durchlauf
    });
	
    $("#care_level_since").on('input', function() {
        var input = $(this).val().replace(/\D/g, ''); // Nur Zahlen behalten
        var newInput = '';

        if (input.length > 6) {
            input = input.substring(0, 6); // Maximale Länge von 6 Ziffern
        }

        // Monat und Jahr extrahieren
        var month = input.length >= 2 ? input.substring(0, 2) : input;
        var year = input.length > 2 ? input.substring(2) : '';

        // Werte neu zusammensetzen
        newInput = (month ? month : '') +
                   (year ? '.' + year : '');

        // Nur einen Punkt hinzufügen, wenn die Eingabe verlängert wird
        if (input.length > previous_length_care_level_since) {
            if (input.length === 2) {
                newInput += '.';
            }
        }

        $(this).val(newInput);
        previous_length_care_level_since = input.length; // Aktualisieren der gespeicherten Länge für den nächsten Durchlauf
    });
	
    const CheckEGK = testling => {
        let m = testling.match(/^([A-Z]{1})([\d]{8})([\d]{1})$/);
        if (m) {   
            let cardNo = ('0' + (m[1].charCodeAt(0)-64)).slice(-2) + m[2];
            let sum = 0;
            for (let i = 0; i < 10; i++) {
                let d = cardNo[i];
                if (i % 2 == 1) d *= 2;
                if (d > 9) d -= 9;
                sum += parseInt(d);
            }
            return sum % 10 == m[3];
        }
        return false;
    };
	
	function isValidDate(dateString) {
		var regEx = /^\d{2}\.\d{2}\.\d{4}$/;
		if(!dateString.match(regEx)) return false;  // Invalid format
		var parts = dateString.split('.');
		var day = parseInt(parts[0], 10);
		var month = parseInt(parts[1], 10);
		var year = parseInt(parts[2], 10);
		if(year < 1900 || year > 2100 || month === 0 || month > 12) return false;
		var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];
		if(year % 400 === 0 || (year % 100 !== 0 && year % 4 === 0)) monthLength[1] = 29; // Schaltjahr
		var currentDate = new Date();
		var currentYear = currentDate.getFullYear();
		var currentMonth = currentDate.getMonth() + 1; // Da Monat von 0 bis 11 indexiert ist
		var currentDay = currentDate.getDate();

		// Überprüfen, ob das Jahr mindestens 10 Jahre zurückliegt
		if (year > currentYear - 10) return false;
		if (year === currentYear - 10 && month > currentMonth) return false;
		if (year === currentYear - 10 && month === currentMonth && day > currentDay) return false;

		return day > 0 && day <= monthLength[month - 1];
	}

    var form = $('#form-data');
    $("button[name='proceed']").on('click', function(e) {
		e.preventDefault();
		
        form[0].classList.remove('was-validated');
        form[0].classList.add('was-validated');
		
		// Krankenversicherungsnummer
        var kvnrField = $('#insurance_number');
        var kvnr = kvnrField.val();
		
        if(!CheckEGK(kvnr)) {
            kvnrField.removeClass('is-valid');
            kvnrField.addClass('is-invalid');
            $('#message_insurance_number').text('Die Krankenversichertennummer scheint ungültig zu sein. Bitte prüfen Sie diese.').addClass('text-danger').show();
            
            $('html, body').animate({
                scrollTop: kvnrField.offset().top
            }, 500);
            
            return false;
        } else {
            kvnrField.removeClass('is-invalid');
            kvnrField.addClass('is-valid');
        }
		
		// Geburtsdatum validieren
		var birthDateField = $('#insured_person_birth_date');
		var birthDate = birthDateField.val();
		if (!isValidDate(birthDate)) {
			birthDateField.removeClass('is-valid');
			birthDateField.addClass('is-invalid');
			$('#message_insured_person_birth_date').text('Das eingegebene Geburtsdatum ist ungültig.').show();

			$('html, body').animate({
				scrollTop: birthDateField.offset().top
			}, 500);

			return false;
		} else {
			birthDateField.removeClass('is-invalid');
			birthDateField.addClass('is-valid');
		}
		
        if (form[0].checkValidity() === false) {
            e.stopPropagation();
        }
		
		form.addClass('was-validated');
		
		if (form[0].checkValidity()) {
			var clickedButton = $(this);
			clickedButton.find('.spinner-border').show();
			clickedButton.find('.btn-text').hide();

			$.ajax({
				url: 'pages/application/insured-person-data/save-insured-person-data.php',
				type: 'post',
				dataType: 'json',
				data: form.serialize(),
				success: function(response) {
					if(response.success) {
						$('#message').text(response.message).addClass('text-success').show();
						setTimeout(function() {
							window.location.href = "<?php echo $next_page_url ?>";
						}, 1000);
					} else {
						var missingFieldsStr = response.missingFields ? response.missingFields.join(", ") : "Keine Angabe";
						$('#message').text(response.message + "\nDetails: " + missingFieldsStr).addClass('text-danger').show();
					}
				},
/*				error: function(jqXHR, textStatus, errorThrown) {
					$('#message').text('Ein Fehler ist beim Senden aufgetreten. Status: ' + textStatus + '. Fehler: ' + errorThrown).addClass('text-danger').show();
				}*/
			});
		}
    });
	
	$('#insurance_number').on('input', function() {
		var kvnrField = $(this);
		var kvnr = kvnrField.val();

		if (kvnr.length === 10) {
			if (CheckEGK(kvnr)) {
				kvnrField.removeClass('is-invalid');
				kvnrField.addClass('is-valid');
			} else {
				kvnrField.removeClass('is-valid');
				kvnrField.addClass('is-invalid');
			}
		} else {
			kvnrField.removeClass('is-valid is-invalid');
		}
	});
});
</script>