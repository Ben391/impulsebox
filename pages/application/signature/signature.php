<div class="container py-md-5 py-0">
	<div class="row justify-content-center">
		<form id="form-data" class="col-md-8 p-4 mb-3 bg-light-grey rounded-4">
			<h1 class="h2 mb-4">Unterschrift des Versicherten oder Bevollmächtigten</h1>
			<h2 class="h4 mb-4">Zu unterzeichnende Unterlagen:</h2>
			<div class="row mb-3">
				<div class="col-12 mb-3">
					<div class="row">
						<div class="col-auto">
							<a href="<?php echo BASEHREF ?>inc/PDF/createPDF-for-download.php?page_nr=1&entry_id=<?php echo $entry_id?>" target="_blank"><i class="fa-regular fa-file-pdf text-muted fa-2xl"></i></a>
						</div>
						<div class="col">
							<a class="text-dark" href="<?php echo BASEHREF ?>inc/PDF/createPDF-for-download.php?page_nr=1&entry_id=<?php echo $entry_id?>" target="_blank"><h2 class="h5">Bestellformular</h2></a>
						</div>
					</div>
				</div>
				<div class="col-12 mb-3">
					<div class="row">
						<div class="col-auto">
							<a href="<?php echo BASEHREF ?>inc/PDF/createPDF-for-download.php?page_nr=2&entry_id=<?php echo $entry_id?>" target="_blank"><i class="fa-regular fa-file-pdf text-muted fa-2xl"></i></a>
						</div>
						<div class="col">
							<a class="text-dark" href="<?php echo BASEHREF ?>inc/PDF/createPDF-for-download.php?page_nr=2&entry_id=<?php echo $entry_id?>" target="_blank"><h2 class="h5">Antrag auf Kostenübernahme und Beratungsdokumentation (Blatt 1)</h2></a>
						</div>
					</div>
				</div>
				<div class="col-12 mb-3">
					<div class="row">
						<div class="col-auto">
							<a href="<?php echo BASEHREF ?>inc/PDF/createPDF-for-download.php?page_nr=3&entry_id=<?php echo $entry_id?>" target="_blank"><i class="fa-regular fa-file-pdf text-muted fa-2xl"></i></a>
						</div>
						<div class="col">
							<a class="text-dark" href="<?php echo BASEHREF ?>inc/PDF/createPDF-for-download.php?page_nr=3&entry_id=<?php echo $entry_id?>" target="_blank"><h2 class="h5">Antrag auf Kostenübernahme und Beratungsdokumentation (Blatt 2)</h2></a>
						</div>
					</div>
				</div>
				<?php if($consultation_status == 0) { ?>
				<div class="col-12 mb-3">
					<div class="row">
						<div class="col-auto">
							<a href="<?php echo BASEHREF ?>inc/PDF/createPDF-for-download.php?page_nr=4&entry_id=<?php echo $entry_id?>" target="_blank"><i class="fa-regular fa-file-pdf text-muted fa-2xl"></i></a>
						</div>
						<div class="col">
							<a class="text-dark" href="<?php echo BASEHREF ?>inc/PDF/createPDF-for-download.php?page_nr=4&entry_id=<?php echo $entry_id?>" target="_blank"><h2 class="h5">Ablehnung der persönlichen Beratung</h2></a>
						</div>
					</div>
				</div>
				<?php } ?>
				<?php if(isset($supplier_change) AND !empty($supplier_change)) { ?>
				<div class="col-12 mb-3">
					<div class="row">
						<div class="col-auto">
							<a href="<?php echo BASEHREF ?>inc/PDF/createPDF-for-download.php?page_nr=5&entry_id=<?php echo $entry_id?>" target="_blank"><i class="fa-regular fa-file-pdf text-muted fa-2xl"></i></a>
						</div>
						<div class="col">
							<a class="text-dark" href="<?php echo BASEHREF ?>inc/PDF/createPDF-for-download.php?page_nr=5&entry_id=<?php echo $entry_id?>" target="_blank"><h2 class="h5">Formular zum Wechsel des Versorgers</h2></a>
							<p class="ftsz-1 line-height-14">Zur Bearbeitung der Umversorgung mit Pflegehilfsmitteln von einem anderen Versorger zur <?php echo $company["company"] ?>.</p>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="row mb-3 ms-5">
				<div class="col-md-8">
				<canvas id="sig" class="bg-white border-2 border-primary w-100" style="height: 150px;"></canvas>
				</div>
			</div>
			<div class="row mb-4">
				<div class="col">
					<div class="px-2 mb-3 ms-5" style="">Bitte unterschreiben Sie im blau umrandeten Feld. Nutzen Sie hierfür Ihre Maus oder, bei einem Touch-Gerät, Ihren Finger.</div>
				</div>
				<div class="col-auto">
					<button id="clear" class="custom-btn custom-btn-md <?php echo BTN_OUTLINE_SECONDARY ?>">Unterschrift löschen</button>
				</div>
				<div id="Signstatus"></div>
				<textarea id="signature64" name="signed"></textarea>
			</div>
			<div class="row mb-4">
				<div class="col-12 mb-3">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="1" id="" required>
						<label class="form-check-label">
						Mit meiner Unterschrift bestätige ich, dass ich darüber informiert wurde, dass die gewünschten Produkte ausnahmslos für die häusliche Pflege durch eine private Pflegeperson (und nicht durch Pflegedienste oder Einrichtungen der Tagespflege) verwendet werden dürfen.
						</label>
					</div>
				</div>
				<div class="col-12">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="1" id="" required>
						<label class="form-check-label">
						Ich bin darüber aufgeklärt worden, dass die Pflegekasse die Kosten nur für solche Pflegehilfsmittel und in dem finanziellen Umfang übernimmt, für die ich eine Kostenübernahmeerklärung durch die Pflegekasse erhalten habe. Kosten für evtl. darüber hinausgehende Leistungen sind von mir selbst zu tragen.
						</label>
					</div>
				</div>
			</div>
			<div class="row text-center">
				<div class="col-12">
					<input type="hidden" name="entry_id" value="<?php echo $entry_id ?>">
					<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
					<input type="hidden" name="user_email" value="<?php echo $user_email ?>">
					<input type="hidden" name="insurance_type" value="<?php echo $insurance_type ?>">
					<button name="submit-digital" class="custom-btn custom-btn-md <?php echo BTN_GRADIENT ?>">
						<i class="fa-regular fa-paper-plane fa-lg me-2"></i>
						<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
						<span class="btn-text">Antrag kostenlos einreichen</span>
					</button>
				</div>
				<div class="col-12 text-center font-weight-400">
					<div id="message" class="mt-md-4 mt-3" style="display: none"></div>
				</div>
			</div>
		</form>
		<form id="signatureForm" action="<?php echo BASEHREF ?>inc/PDF/createPDF.php" method="get">
			<input type="hidden" id="file_name_input" name="file_name" value="test">
			<input type="hidden" name="entry_id" value="<?php echo $entry_id ?>">
			<input type="hidden" name="signed_status" value="1">
			<input type="hidden" id="deviceType" name="deviceType" value="">
		</form>
	</div>
</div>
<script>
function detectDevice() {
	var userAgent = window.navigator.userAgent;
	var isMobile = /Mobi|Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(userAgent);
	return isMobile ? "mobile" : "desktop";
	}
$(document).ready(function() {
	var form = $('#form-data');
	var canvas = document.getElementById("sig");
    var signaturePad = new SignaturePad(canvas);

	canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;

	$('#clear').click(function(e) {
		e.preventDefault();
		signaturePad.clear();
		$("#signature64").val('');
	});

    $("button[name='submit-digital']").on('click', function(e) {
        e.preventDefault(); // Verhindert das Standard-Formularabsenden
		
		if (signaturePad.isEmpty()) {
			$('#Signstatus').text('Bitte geben Sie Ihre Unterschrift ein.').addClass('text-danger').show();
			return;
		}

		
		if (form[0].checkValidity() === false) {
			e.stopPropagation();
		}
		
		$("#deviceType").val(detectDevice());
		form.addClass('was-validated');

		var signatureDataURL = signaturePad.toDataURL();
        $("#signature64").val(signatureDataURL);

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
						let filename = response.filename; // Set the JavaScript variable
							$('#file_name_input').val(filename); // Set the hidden input field value using jQuery
							$('#debugOutput').text("Debug Output: " + filename);

							$('#signatureForm').submit();
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