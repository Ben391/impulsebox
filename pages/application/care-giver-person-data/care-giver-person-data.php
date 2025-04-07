<div class="container">
	<div class="row">
		<div class="col-md-7 px-md-2 px-1 mb-3">
			<form id="form-data" class="p-md-4 p-3 mb-3 bg-light-grey rounded-4">
				<div class=" mb-md-4 mb-2">
					<h1 class="h2 mb-1">Pflegeperson <span class="opacity-75">/</span> Angehöriger</h1>
					<?php if(isset($user_type) AND $user_type == 2) { ?>
					<div class="row alert alert-warning mb-md-4 mb-2">
						<p class="mb-0">
							Sie haben angegeben, dass Sie ein <a class="alert-link" href="<?php echo BASEHREF ?>konto-erstellen/">Angehöriger oder eine Pflegeperson</a> sind. <br>
							Bitte geben Sie daher Ihre Daten ein.</p>
					</div>
					<?php } else { ?>
					<div class="alert alert-warning mb-0">Diese Angaben sind optional. Sie können diesen Schritt <a class="alert-link" href="<?php echo $next_page_url ?>">überspringen</a>.</div>
					<?php } ?>
				</div>
				<?php 
				$input_salutation_attr_name_value = "care_giver_salutation";
				$input_salutation_attr_id_value = "care_giver_salutation";
				$input_salutation_attr_value_value = $care_giver_person_salutation;
				$input_salutation_required = " required ";
				include_once "views/form-elements/salutation.php";
				// first name
				$input_first_name_attr_name_value = "care_giver_first_name";
				$input_first_name_attr_id_value = "care_giver_first_name";
				$input_first_name_attr_value_value = $care_giver_person_first_name;
				$input_first_name_required = " required ";
				// last name
				$input_last_name_attr_name_value = "care_giver_last_name";
				$input_last_name_attr_id_value = "care_giver_last_name";
				$input_last_name_attr_value_value = $care_giver_person_last_name;
				$input_last_name_required = " required ";
				include_once "views/form-elements/name.php";
				// street
				$input_street_attr_name_value = "care_giver_street";
				$input_street_attr_value_value = $care_giver_person_street;
				$input_street_required = " required ";
				// address_addition
				$input_address_addition_attr_name_value = "care_giver_address_addition";
				$input_address_addition_attr_id_value = "care_giver_address_addition";
				$input_address_addition_attr_value_value = $care_giver_person_address_addition;
				$input_address_addition_required = "";
				include_once "views/form-elements/street.php";
				// zipcode
				$input_zipcode_attr_name_value = "care_giver_zipcode";
				$input_zipcode_attr_id_value = "care_giver_zipcode";
				$input_zipcode_attr_value_value = $care_giver_person_zipcode;
				$input_zipcode_required = " required ";
				// city
				$input_city_attr_name_value = "care_giver_city";
				$input_city_attr_id_value = "care_giver_city";
				$input_city_attr_value_value = $care_giver_person_city;
				$input_city_required = " required ";
				include_once "views/form-elements/zipcode_city.php";
				// contact
				// phone
				$input_phone_attr_name_value = "care_giver_phone";
				$input_phone_attr_id_value = "care_giver_phone";
				$input_phone_attr_value_value = $care_giver_person_phone;
				$input_phone_required = " required ";
				$input_phone_required_asterisk = "*";
				// email
				$input_email_attr_name_value = "care_giver_email";
				$input_email_attr_id_value = "care_giver_email";
				if(isset($care_giver_person_email)) { 
					$input_email_attr_value_value = $care_giver_person_email; 
				} else { 
					if(isset($user_type) AND $user_type == 2) { 
						$input_email_attr_value_value = $user_email; 
					} else { 
						$input_email_attr_value_value = $care_giver_person_email; 
					}
				}
				if(isset($user_type) AND $user_type == 2) {
					$input_email_required = " required ";
					$input_email_required_asterisk = "*";
				} else {
					$input_email_required = "";
					$input_email_required_asterisk = "";
				}
				include_once "views/form-elements/contact.php";
				// procced
				include_once "inc/proceed.php";
				?>
			</form>
		</div>
		<div class="col-md-5 px-md-2 px-1 mb-md-3 mb-2 order-md-last order-first">
			<?php include_once "views/your-box.php" ?>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	var form = $('#form-data');
    $("button[name='proceed']").on('click', function(e) {
		e.preventDefault();

        // Validierung
        if (form[0].checkValidity() === false) {
            e.stopPropagation();
        }
		
		form.addClass('was-validated');
		
        if (form[0].checkValidity()) {
			var clickedButton = $(this);
			clickedButton.find('.spinner-border').show();
			clickedButton.find('.btn-text').hide();

			$.ajax({
				url: 'pages/application/care-giver-person-data/save-care-giver-person-data.php',
				type: 'post',
				dataType: 'json',
				data: clickedButton.closest('form').serialize(),
				success: function(response) {
					if(response.success) {
						$('#message').text(response.message).addClass('text-success').show();
						setTimeout(function() {
							window.location.href = "<?php echo $next_page_url ?>";
						}, 1000);
					} else {
						$('#message').text(response.message + "\nDetails: " + response.details).addClass('text-danger').show();
						clickedButton.find('.spinner-border').hide();
						clickedButton.find('.btn-text').show();
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					//console.error('Ein Fehler ist beim Senden aufgetreten. Status: ' + textStatus + '. Fehler: ' + errorThrown);
					$('#message').text('Ein Fehler ist beim Senden aufgetreten.').show();
					clickedButton.find('.spinner-border').hide();
					clickedButton.find('.btn-text').show();
				}
			});
        }
    });
});
</script>