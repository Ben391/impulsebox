<div class="row border-bottom mb-3">
	<div class="col">
		<div class="row">
			<div class="col-md-12 mb-3">
				<h2 class="h3 mb-3">Bearbeitungsstatus</h2>
				<table class="table table-sm table-striped">
					<?php if(isset($entry_status_data)) { 
							foreach($entry_status_data AS $s) {
							$status_name = $s["status_name"];
							$status_date_formatted = date('d.m.Y H:i', $s["status_date"]); ?>
							<tr>
								<td><?php echo $status_date_formatted ?></td>
								<td>
									<?php echo $status_name ?>
									<?php if(!empty($s["sending_on_name"])) echo ": ".$s["sending_on_name"]; ?>
								</td>
							</tr>
						<?php } ?>
					<?php } ?>
					<tr>
						<td><?php echo $entry_create_date_formatted ?></td>
						<td>
							<?php if(isset($entry_import_id) AND !empty($entry_import_id)) { ?>
							Antrag importiert / Import ID: <?php echo $entry_import_id ?>
							<?php } else { ?>
							Antrag angelegt
							<?php } ?>
						</td>
					</tr>
				</table>
				<?php if(is_admin_area()) { ?>
				<form method="POST" id="form-data" class="row">
					<?php 
					// "digital, kostenpflichtig, post_angefordert, download, print" nicht ausgeben
					$sql_where = "WHERE status_id NOT IN (10, 11, 20, 30, 40) AND active = 1";
					if($statuses = getStatuses($mysqli, $sql_where)) { ?>
						<select name="status_id" class="col form-select form-select-lg mb-3" required>
							<option value="" selected disabled>Status auswählen</option>
							<?php foreach($statuses AS $status) { ?>
							<option value="<?php echo $status["status_id"] ?>"><?php echo $status["short_name"] ?></option>
							<?php } ?>
						</select>							  
					<?php }	?>
					<div class="col-auto">
						<input type="hidden" name="entry_id" value="<?php echo $entry_id ?>">
						<button name="proceed" class="custom-btn <?php echo BTN_PRIMARY ?>">
							<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
							<span class="btn-text">
								<span>Aktualisieren</span>
							</span>
						</button>
					</div>
					<div class="col-12" id="message"></div>
				</form>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
var form = $('#form-data');
$("button[name='proceed']").on('click', function(e) {
    e.preventDefault();

    // Überprüfen Sie die Validität des Formulars
    if (form[0].checkValidity() === false) {
        e.stopPropagation();
        form.addClass('was-validated');
    } else {
        // Form ist gültig, zeigen Sie den Bestätigungsdialog
        var proceed = window.confirm("Status aktualisieren?");
        
        if (!proceed) {
            return;  // Aktion abbrechen, wenn der Benutzer 'Cancel' wählt
        }
		
        var statusId = $("select[name='status_id']").val();
        var send_mail = 'false';
        if (['21', '50', '60', '70'].includes(statusId)) {
            send_mail = window.confirm("Möchten Sie eine E-Mail an den Kunden senden?") ? 'true' : 'false';
        }

        form.addClass('was-validated');

        var clickedButton = $(this);
        clickedButton.find('.spinner-border').show();
        clickedButton.find('.btn-text').hide();

        $.ajax({
            url: 'pages/entry/inc/update-entry.php',
            type: 'post',
            dataType: 'json',
            data: form.serialize() + '&send_mail=' + send_mail,
            success: function(response) {
                if (response.success) {
                    $('#message').text(response.message).addClass('text-success').show();
                    setTimeout(function() {
                        window.location.href = 'entry/?id=' + '<?php echo $entry_id; ?>';
                    }, 500);
                } else {
                    var missingFieldsStr = response.missingFields ? response.missingFields.join(", ") : "Keine Angabe";
                    $('#message').text(response.message + "\nDetails: " + missingFieldsStr).addClass('text-danger').show();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#message').text('Ein Fehler ist beim Senden aufgetreten. Status: ' + textStatus + '. Fehler: ' + errorThrown).addClass('text-danger').show();
            }
        });
    }
});
</script>