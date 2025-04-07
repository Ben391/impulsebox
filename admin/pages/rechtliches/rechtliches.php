<?php $rechtliches = getRechtliches($mysqli); ?>
<div class="container py-4">
	<div class="row">
		<h1 class="h2 mb-3">Rechtliches</h1>
		<form class="form" id="rechtliches">
			<h2 class="h4">Impressum</h2>
			<div class="mb-4">
				<textarea rows="10" class="form-control mb-3" name="impressum"><?php echo $rechtliches["impressum"] ?></textarea>
				<button class="custom-btn custom-btn-md custom-btn-primary">Speichern</button>
				<a class="ms-3" target="_blank" href="<?php echo BASEHREF ?>impressum/">Impressum</a>
			</div>
			<h2 class="h4">Allgemeine Geschäftsbedingungen</h2>
			<div class="mb-4">
				<textarea rows="10" class="form-control mb-3" name="agb"><?php echo $rechtliches["agb"] ?></textarea>
				<button class="custom-btn custom-btn-md custom-btn-primary">Speichern</button>
				<a class="ms-3" target="_blank" href="<?php echo BASEHREF ?>agb/">Allgemeine Geschäftsbedingungen</a>
			</div>
			<h2 class="h4">Datenschutzerklärung</h2>
			<div class="mb-4">
				<textarea rows="10" class="form-control mb-3" name="datenschutz"><?php echo $rechtliches["datenschutz"] ?></textarea>
				<button class="custom-btn custom-btn-md custom-btn-primary">Speichern</button>
				<a class="ms-3" target="_blank" href="<?php echo BASEHREF ?>datenschutz/">Datenschutzerklärung</a>
			</div>
			<h2 class="h4">Widerrufsrecht</h2>
			<div class="mb-4">
				<textarea rows="10" class="form-control mb-3" name="widerrufsrecht"><?php echo $rechtliches["widerrufsrecht"] ?></textarea>
				<button class="custom-btn custom-btn-md custom-btn-primary">Speichern</button>
				<a class="ms-3" target="_blank" href="<?php echo BASEHREF ?>datenschutz/">Widerrufsrecht</a>
			</div>
		</div>
		<script>
		$(document).ready(function () {
			$('#rechtliches').on('submit', function (event) {
				event.preventDefault();
				if (!this.checkValidity()) {
					event.stopPropagation();
				} else {
					$.ajax({
						url: 'pages/rechtliches/inc/save.php',
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
