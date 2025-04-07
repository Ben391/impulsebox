<?php if(file_exists($file)) { ?>
<h4 class="mb-3">Daten importieren</h4>
<form id="import_form" action="pages/import/inc/import/import-handling.php" method="POST">
	<?php
	$where = 'cgd.user_id IS NOT NULL AND cgd.user_id != ""';					  
	if($care_giver_services = getCareGiverServices($mysqli,$where)) { ?>
	<div class="row d-flex align-items-end">
		<div class="col-12 mb-3">
			<label class="form-label">Pflegedienst auswählen</label>
			<select id="care_giver_service" class="form-select form-select-lg" name="care_giver_service_id" required>
				<option value="" selected disabled>Auswählen</option>
				<?php foreach($care_giver_services AS $care_giver_service) { ?>
					<option 
							value="<?php echo $care_giver_service["id"] ?>" 
							data-user_id="<?php echo $care_giver_service["user_id"] ?>">
							<?php echo $care_giver_service["company"] ?>
					</option>
				<?php } ?>
			</select>
		</div>
		<div class="col-12 mb-3">
			<span class="text-muted me-2">oder</span> <a class="custom-btn custom-btn-outline-primary" href="<?php echo ADMIN_BASEHREF ?>caregiver-services/">Neues Pflegedienst anlegen</a>
		</div>
	</div>
	<?php } ?>
	<div class="mb-3">
		<label class="form-label">PDF Version</label>
		<div>
			<!--
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="pdf_version" value="0" required>
				<label class="form-check-label">voll: Bestellformular, Antrag auf Kostenübernahme, Empfangsvollmacht, ggfs. Wechselerklärung, Allgemeine Geschäftsbedingungen</label>
			</div>-->
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="pdf_version" value="1" required>
				<label class="form-check-label">Antrag auf Kostenübernahme, ggfs. Wechselerklärung</label>
			</div>
		</div>
	</div>
	<input type="hidden" name="user_id" value="">
	<input type="hidden" name="admin_id" value="<?php echo $admin["id"] ?>">
	<button class="btn btn-lg btn-primary" type="submit" name="submit" value="submit">Daten importieren</button>
</form>
<?php } ?>
<script>
$(document).ready(function() {
	$('select[name="care_giver_service_id"]').change(function() {
		var userId = $('option:selected', this).data('user_id');
		$('input[name="user_id"]').val(userId);
	});
});
</script>
