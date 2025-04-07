<div class="col-md-6 mb-4">
	<h2 class="h4 mb-3">Vorhandene Status</h2>
	<?php 
	$sql_where = "";
	if($application_status = getStatuses($mysqli, $sql_where)) { ?>
	<div id="status" class="row">
		<?php foreach($application_status AS $status) { ?>
			<div data-status-id="<?php echo $status["id"] ?>" class="col-12 mb-3 p-md-4 p-3 mb-3 bg-light-grey rounded-4">
				<div class="row d-flex align-items-center">
					<div class="col mb-2">
						<input 
							   id="shortname-<?php echo $status["id"] ?>"
							   type="text" 
							   class="shortname-field form-control " 
							   placeholder="Kurzname"
							   value="<?php echo $status["short_name"] ?>"
							   <?php if(!empty($status["tech_name"])) echo " disabled"; ?>
							   >
					</div>
					<div class="col-auto opacity-75">
						<div>#<?php echo $status["id"] ?></div>
					</div>
				</div>
				<div class="row d-flex align-items-center">
					<div class="col mb-2">
						<input 
						   id="fullname-<?php echo $status["id"] ?>"
						   type="text" 
						   class="fullname-field form-control " 
						   placeholder="Name"
						   value="<?php echo $status["name"] ?>">
					</div>
					<div class="col-auto mb-2">
						<input 
						   id="status-id-<?php echo $status["id"] ?>"
						   style="max-width:100px"
						   type="text" 
						   class="status-id-field form-control " 
						   placeholder="Status ID"
						   value="<?php echo $status["status_id"] ?>"
							<?php if(!empty($status["tech_name"])) echo " disabled"; ?>>
					</div>
				</div>
				<?php if(!empty($status["tech_name"])) { ?>
				<div class="row d-flex align-items-center">
					<div class="col-auto ftsz-1">Technischer Name:</div>
					<div class="col mb-2">
						<input 
						   id="fullname-<?php echo $status["id"] ?>"
						   type="text" 
						   class="fullname-field form-control" 
						   placeholder="Name"
						   value="<?php echo $status["tech_name"] ?>" disabled>
					</div>
				</div>
				<?php } ?>
				<?php if(empty($status["tech_name"])) { ?>
				<div class="row d-flex align-items-center">
					<?php if($status["active"] == 0) { ?>
					<div class="col">
						<button value="Aktivieren" id="activate-status" class="custom-btn <?php echo BTN_OUTLINE_PRIMARY ?> status-activate w-100" data-status-id="<?php echo $status["id"] ?>">
							Aktivieren
						</button>
					</div>
					<?php } else { ?>
					<div class="col">
						<button value="Aktualisieren" id="update-status" class="custom-btn <?php echo BTN_OUTLINE_PRIMARY ?> update-status w-100" data-status-id="<?php echo $status["id"] ?>">
							Aktualisieren
						</button>
					</div>
					<div class="col">
						<button title="Deaktivieren" class="custom-btn <?php echo BTN_OUTLINE_DANGER ?> status-deactivate w-100" data-status-id="<?php echo $status["id"] ?>">
							Deaktivieren
						</button>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
	<?php } ?>
</div>
<script>
	$(document).ready(function () {
		$('.update-status').click(function(){
			var id = $(this).data('status-id');
			var status_id = $('#status-id-' + id).val();
			var shortname = $('#shortname-' + id).val();
			var fullname = $('#fullname-' + id).val();
			
			event.preventDefault();
			if (!this.checkValidity()) {
				event.stopPropagation();
			} else {
				$.ajax({
					url: 'pages/status/inc/update.php',
					type: 'POST',
					data: { 
						id: id,
						status_id: status_id,
						shortname: shortname,
						fullname: fullname,
					},
					success: function (data) {
						alert(data);
						setTimeout(function() {
							window.location.reload();
							}, 1000);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Fehler beim Senden der Daten: ' + textStatus);
					}
				});
			}
			this.classList.add('was-validated');
		});
		$('.status-activate').click(function(){
			var id = $(this).data('status-id');
			var active = 1;
			
			event.preventDefault();
			if (!this.checkValidity()) {
				event.stopPropagation();
			} else {
				$.ajax({
					url: 'pages/status/inc/activate.php',
					type: 'POST',
					data: { 
						id: id,
						active: active,
					},
					success: function (data) {
						alert(data);
						setTimeout(function() {
							window.location.reload();
							}, 1000);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Fehler beim Senden der Daten: ' + textStatus);
					}
				});
			}
			this.classList.add('was-validated');
		});
		$('.status-deactivate').click(function(){
			var id = $(this).data('status-id');
			var active = 0;
			
			event.preventDefault();
			if (!this.checkValidity()) {
				event.stopPropagation();
			} else {
				$.ajax({
					url: 'pages/status/inc/activate.php',
					type: 'POST',
					data: { 
						id: id,
						active: active,
					},
					success: function (data) {
						alert(data);
						setTimeout(function() {
						window.location.reload();
						}, 1000);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Fehler beim Senden der Daten: ' + textStatus);
					}
				});
			}
			this.classList.add('was-validated');
		});
	});
</script>