<div class="container py-4">
	<div class="row">
		<h1 class="h2 mb-3">Mitarbeiter</h1>
		<?php
		include_once "inc/list.php";
		if($_SESSION['admin_role'] == 1) {
			include_once "inc/add-new.php"; 
		}
		?>
	</div>
	<script>
	$(document).ready(function() {
		$('#save_employer').click(function(event) {
			event.preventDefault();
			var first_name = $('#first_name').val().trim();
			var last_name = $('#last_name').val().trim();
			var employer_email = $('#employer_email').val().trim();

			if (!first_name || !last_name || !employer_email) {
				alert('Bitte füllen Sie alle Felder aus.');
				return;
			}

			// Überprüfen der E-Mail-Adresse vor dem Speichern
			$.ajax({
				url: 'pages/employees/inc/check_email.php', // Pfad zur PHP-Datei, die die Überprüfung durchführt
				type: 'POST',
				data: {email: employer_email},
				success: function(data) {
					if (data === 'exists') {
						alert('E-Mail-Adresse existiert bereits.');
					} else {
						// Wenn die E-Mail-Adresse nicht existiert, fahren Sie mit dem Speichern fort
						saveEmployee(first_name, last_name, employer_email);
					}
				},
				error: function() {
					alert('Fehler beim Überprüfen der E-Mail-Adresse.');
				}
			});
		});
		$('.admin-activate').click(function(){
			var id = $(this).data('admin-id');
			var active = 1;

			event.preventDefault();
				if (!this.checkValidity()) {
					event.stopPropagation();
				} else {
					$.ajax({
						url: 'pages/employees/inc/set_active.php',
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
		$('.admin-deactivate').click(function(){
			var id = $(this).data('admin-id');
			var active = 0;

			event.preventDefault();
				if (!this.checkValidity()) {
					event.stopPropagation();
				} else {
					$.ajax({
						url: 'pages/employees/inc/set_active.php',
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

		function saveEmployee(first_name, last_name, employer_email) {
			$.ajax({
				url: 'pages/employees/inc/save_employer.php',
				type: 'POST',
				data: {
					first_name: first_name,
					last_name: last_name,
					employer_email: employer_email
				},
				success: function(data) {
					alert('Neuer Mitarbeiter wurde angelegt.');
					setTimeout(function() {
						window.location.reload();
					}, 1000);
				},
				error: function() {
					alert('Fehler beim Speichern.');
				}
			});
		}

		});
	</script>
</div>
