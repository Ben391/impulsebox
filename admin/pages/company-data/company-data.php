<div class="container py-4">
	<div class="row">
		<h1 class="h2 mb-3">Unternehmensdaten</h1>
		<?php $company = getCompanyData($mysqli); ?>
		<div class="col-md-6">
			<form id="company">
				<div class="mb-1">
					<input 
					   name="servicename"
					   type="text" 
					   class="form-control form-control-lg" 
					   placeholder="Servicename"
					   value="<?php echo $company["servicename"] ?>">
				</div>
				<div class="mb-1 text-muted px-3">ist ein Service von</div>
				<div class="mb-2">
					<input 
					   name="company"
					   type="text" 
					   class="form-control form-control-lg" 
					   placeholder="Unternehmensname"
					   value="<?php echo $company["company"] ?>">
				</div>
				<div class="mb-2">
					<input 
					   name="street"
					   type="text" 
					   class="form-control form-control-lg" 
					   placeholder="Strasse und Hausnummer"
					   value="<?php echo $company["street"] ?>">
				</div>
				<div class="row mb-2">
					<div class="col mb-2">
						<input 
							   minlength="5" 
							   maxlength="5" 
							   pattern="[0-9]+" 
							   type="text" 
							   name="zipcode" 
							   class="form-control form-control-lg" 
							   placeholder="PLZ"
							   value="<?php echo $company["zipcode"] ?>">
						<div class="invalid-feedback">Bitte geben Sie Postleitzahl ein!</div>
					</div>
					<div class="col-9 mb-2">
						<input 
							   minlength="2" 
							   maxlength="30" 
							   type="text" 
							   name="city" 
							   class="form-control form-control-lg" 
							   placeholder="Ort"
							   value="<?php echo $company["city"] ?>">
						<div class="invalid-feedback">Bitte geben Sie Stadt ein!</div>
					</div>
				</div>
				<div class="mb-2">
					<input 
					   name="phone"
					   type="text" 
					   class="form-control form-control-lg" 
					   placeholder="Telefon"
					   value="<?php echo $company["phone"] ?>">
				</div>
				<div class="mb-2">
					<input 
					   name="email"
					   type="text" 
					   class="form-control form-control-lg" 
					   placeholder="E-Mail-Adresse"
					   value="<?php echo $company["email"] ?>">
				</div>
				<button class="custom-btn custom-btn-md custom-btn-primary">Speichern</button>
			</form>
			<script>
			$(document).ready(function () {
				$('#company').on('submit', function (event) {
					event.preventDefault();
					if (!this.checkValidity()) {
						event.stopPropagation();
					} else {
						$.ajax({
							url: 'pages/company-data/inc/save.php',
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
	</div>
</div>