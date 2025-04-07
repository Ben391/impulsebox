<div class="col-md-6 mb-4">
	<h2 class="h4 mb-3">Vorhandene Pflegedienste</h2>
	<?php	
	$where = 'user_id IS NOT NULL AND user_id != ""';
	if($care_giver_services = getCareGiverServices($mysqli,$where)) {
	?>
	<div id="services" class="row">
		<?php foreach($care_giver_services AS $care_giver_service) {
		?>
			<div data-service-id="<?php echo $care_giver_service["id"] ?>" class="col-12 mb-3 p-md-4 p-3 mb-3 bg-light-grey rounded-4">
				<div class="row d-flex align-items-center">
					<div class="col mb-2">
						<input 
							   type="text" 
							   class="name-field form-control form-control-lg" 
							   placeholder="Name"
							   value="<?php echo $care_giver_service["company"] ?>">
					</div>
					<div class="col-auto opacity-75">
						<div>#<?php echo $care_giver_service["id"] ?></div>
					</div>
				</div>
				<div class="col-12 mb-2">
					<input 
						   type="text" 
						   class="street-field form-control form-control-lg" 
						   placeholder="Strasse und Hausnummer"
						   value="<?php echo $care_giver_service["street"] ?>">
				</div>
				<div class="col-12 mb-2">
					<input 
						   type="text" 
						   class="address-addition-field form-control form-control-lg" 
						   placeholder="Adresszusatz"
						   value="<?php echo $care_giver_service["address_addition"] ?>">
				</div>
				<div class="row mb-2">
					<div class="col mb-2">
						<input 
							   minlength="5" 
							   maxlength="5" 
							   pattern="[0-9]+" 
							   type="text" 
							   name="zipcode" 
							   class="zipcode-field form-control form-control-lg" 
							   placeholder="PLZ"
							   value="<?php echo $care_giver_service["zipcode"] ?>" required>
						<div class="invalid-feedback">Bitte geben Sie Postleitzahl ein!</div>
					</div>
					<div class="col-9 mb-2">
						<input 
							   minlength="2" 
							   maxlength="30" 
							   type="text" 
							   name="city" 
							   class="city-field form-control form-control-lg" 
							   placeholder="Ort"
							   value="<?php echo $care_giver_service["city"] ?>" 
							   required>
						<div class="invalid-feedback">Bitte geben Sie Stadt ein!</div>
					</div>
				</div>
				<div class="mb-2">
					<input 
						   type="phone" 
						   class="phone-field form-control form-control-lg"
						   placeholder="Telefon"
						   value="<?php echo $care_giver_service["phone"] ?>">
				</div>
				<div class="mb-2">
					<input 
						   type="email" 
						   class="email-field form-control form-control-lg"
						   placeholder="E-Mail-Addresse"
						   value="<?php echo $care_giver_service["email"] ?>">
				</div>
				<div class="row">
					<?php if($care_giver_service["active"] == 1) { ?>
					<div class="col">
						<button title="Aktualisieren" class="custom-btn <?php echo BTN_OUTLINE_PRIMARY ?> update w-100" data-service-id="<?php echo $care_giver_service["id"] ?>" data-address-id="<?php echo $care_giver_service["address_id"]?>">
							Aktualisieren
						</button>
					</div>
					<div class="col">
						<button title="Deaktivieren" class="custom-btn <?php echo BTN_OUTLINE_DANGER ?> disable w-100" data-service-id="<?php echo $care_giver_service["id"] ?>" data-address-id="<?php echo $care_giver_service["address_id"]?>">
							Deaktivieren
						</button>
					</div>
					<?php } else { ?> 
					<div class="col">
						<button title="Aktivieren" class="custom-btn <?php echo BTN_OUTLINE_PRIMARY ?> enable w-100" data-service-id="<?php echo $care_giver_service["id"] ?>" data-address-id="<?php echo $care_giver_service["address_id"]?>">
							Aktivieren
						</button>
					</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>
	<script>
	$(document).ready(function(){
		$('.update').click(function(){
			var id = $(this).data('service-id');
			var container = $('[data-service-id="' + id + '"]');
			var name = container.find('.name-field').val();
			var street = container.find('.street-field').val();
			var address_addition = container.find('.address-addition-field').val();
			var zipcode = container.find('.zipcode-field').val();
			var city = container.find('.city-field').val();
			var phone = container.find('.phone-field').val();
			var email = container.find('.email-field').val();
			var address_id = $(this).data('address-id');
			$.ajax({
				url: 'pages/caregiver-services/inc/update.php',
				type: 'POST',
				data: {
					id: id,
					name: name,
					street: street,
					address_addition: address_addition,
					zipcode: zipcode,
					city: city,
					phone: phone,
					email: email,
					address_id: address_id,
				},
				success: function(data) {
					alert(data);
				},
				error: function() {
					alert('Fehler beim Aktualisieren.');
				}
			});
		});
		$('.enable').click(function(){
			var id = $(this).data('service-id');
			var active = 1;
			
			event.preventDefault();
			if (!this.checkValidity()) {
				event.stopPropagation();
			} else {
				$.ajax({
					url: 'pages/caregiver-services/inc/activate.php',
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
		});
		$('.disable').click(function(){
			var id = $(this).data('service-id');
			var active = 0;
			
			event.preventDefault();
			if (!this.checkValidity()) {
				event.stopPropagation();
			} else {
				$.ajax({
					url: 'pages/caregiver-services/inc/activate.php',
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
		});
				
	});
	</script>
	<?php } ?> 
</div>