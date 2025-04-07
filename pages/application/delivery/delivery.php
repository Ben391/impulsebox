<div class="container">
	<div class="row">
		<div class="col-md-7 px-md-2 px-1 mb-3">
			<form id="form-data" class="p-md-4 p-3 mb-3 bg-light-grey rounded-4">
				<h1 class="h2 mb-md-4 mb-2">Lieferung</h1>
				<div class="row mb-3">
					<h2 class="h4 mb-2">Ihre <?php echo $company["servicename"] ?> wird an folgende Adresse geliefert:</h2>
					<input type="hidden" name="delivery" value="1">
					<!--
					<div class="col-md-8">
						<select class="form-select form-select-lg mb-3" name="delivery" required>
							<option value="1" selected disabled>An den Versicherten</option>
						</select>
						<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_DELIVERY ?></div>
					</div>
					-->
					<div class="col-12">
						<div class="mb-3">
							<div><?php echo $insured_person_first_name . " " . $insured_person_last_name ?></div>
							<div><?php echo $insured_person_address_addition ?></div>
							<div><?php echo $insured_person_street ?></div>
							<div><?php echo $insured_person_zipcode . " " . $insured_person_city ?></div>
						</div>
					</div>
				</div>
				<?php require_once "inc/delivery-frequency.php"; ?>
				<div class="row mb-3">
					<div class="col">
						<h2 class="h4 mb-3">Angaben zum Versorgerwechsel</h2>
						<div>
							<div class="form-check mb-3">
								<input class="form-check-input" name="supplier_change" type="checkbox" value="1" <?php if($supplier_change == 1) echo "checked"; ?>>
								<label class="form-check-label">
								Ich erhalte bereits Pflegehilfsmittel von einem anderen Versorger, möchte jedoch zukünftig durch <?php echo $company["company"] ?> beliefert werden.
								</label>
							</div>
							<div id="supplier_change_delivery_start_block" class="mb-3" <?php if(empty($supplier_change)) { ?>style="display:none;"<?php } ?>>
								<label class="form-label">gewünschter Start der Lieferung</label>
								<input type="text" class="form-control form-control-lg" name="supplier_change_delivery_start" id="supplier_change_delivery_start" placeholder="MM.JJJJ" value="<?php echo $supplier_change_delivery_start ?>" style="width: 150px">
								<div class="invalid-feedback">Dieses Feld ist erforderlich.</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<input type="hidden" name="entry_id" value="<?php echo $entry_id ?>">
					<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
					<input type="hidden" name="insured_person_id" value="<?php echo $insured_person_id ?>">
					<div class="col-auto">
						<a class="custom-btn custom-btn-md <?php echo BTN_OUTLINE_SECONDARY ?>" href="<?php echo $back_page_url ?>">
							<span class="btn-text">Zurück</span>
						</a>
					</div>
					<div class="col text-end">
						<button name="proceed" class="custom-btn custom-btn-md <?php echo BTN_PRIMARY ?> w-100">
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
		<div class="col-md-5 px-md-2 px-1 mb-md-3 mb-2 order-md-last order-first">
			<?php include_once "views/your-box.php" ?>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	var previous_length_supplier_change_delivery_start = 0;
	
    $("#supplier_change_delivery_start").on('input', function() {
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
        if (input.length > previous_length_supplier_change_delivery_start) {
            if (input.length === 2) {
                newInput += '.';
            }
        }

        $(this).val(newInput);
        previous_length_supplier_change_delivery_start = input.length; // Aktualisieren der gespeicherten Länge für den nächsten Durchlauf
    });
	
	
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
				url: 'pages/application/delivery/save-delivery.php',
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
	
	$("input[name='supplier_change']").on('change', function() {
		if ($(this).prop('checked')) {
			$('#supplier_change_delivery_start_block').show();
			$('#supplier_change_delivery_start').prop('required', true);
		} else {
			$('#supplier_change_delivery_start_block').hide();
			$('#supplier_change_delivery_start').prop('required', false);
		}
	});
});
</script>