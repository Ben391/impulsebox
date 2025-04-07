<div class="col-md-6 mb-4">
	<h2 class="h4 mb-3">Neuen Pflegedienst hinzufügen</h2>
	<form id="care_giver_form" method="POST" method="POST" action="" class="form p-md-4 p-3 mb-3 bg-light-grey rounded-4">
		<div class="mb-3">
			<label class="form-label">Name</label>
			<input type="text" id="company" name="company" class="form-control form-control-lg" required>
		</div>
		<div class="mb-3">
			<label class="form-label">Strasse und Hausnummer</label>
			<input type="text" id="street" name="street" class="form-control form-control-lg" required>
		</div>
		<div class="mb-3">
			<label class="form-label">Adresszusatz</label>
			<input type="text" id="address_addition" name="address_addition" class="form-control form-control-lg" placeholder="Postfach, Etage, c/o usw.">
		</div>
		<div class="row mb-3">
			<div class="col-md-3 col-12 mb-3">
				<label class="form-label">PLZ</label>
				<input minlength="5" maxlength="5" pattern="[0-9]+" type="text" name="zipcode" class="form-control form-control-lg" required>
				<div class="invalid-feedback">Bitte geben Sie Postleitzahl ein!</div>
			</div>
			<div class="col-md-9 col-12 mb-3">
				<label class="form-label">Stadt</label>
				<input minlength="2" maxlength="30" type="text" name="city" class="form-control form-control-lg" required>
				<div class="invalid-feedback">Bitte geben Sie Stadt ein!</div>
			</div>
		</div>
		<div class="mb-3">
			<label class="form-label">Telefon</label>
			<input type="phone" id="phone" class="form-control form-control-lg">
		</div>
		<div class="mb-3">
			<label class="form-label">E-Mail-Adresse</label>
			<input type="email" id="email" class="form-control form-control-lg">
		</div>
		<input type="hidden" name="user_id" value="<?php echo $_SESSION['admin_id'] ?>">
		<button class="custom-btn custom-btn-md custom-btn-primary" id="save_employer">Neues Pflegedienst anlegen</button>
	</form>
	<script>
	$(document).ready(function () {
		$('#care_giver_form').on('submit', function (event) {
			event.preventDefault();
			if (!this.checkValidity()) {
				event.stopPropagation();
			} else {
				$.ajax({
					url: 'pages/caregiver-services/inc/save.php',
					type: 'POST',
					data: $(this).serialize(),
					success: function (data) {
						alert(data);
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
</div>