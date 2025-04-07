<div class="col-md-6 mb-4">
	<h2 class="h4 mb-3">Neuen Status hinzufügen</h2>
	<form id="status_form" method="POST" method="POST" action="" class="form p-md-4 p-3 mb-3 bg-light-grey rounded-4">
		<div class="mb-3">
			<label class="form-label">Kurzname</label>
			<input type="text" id="short_name" name="short_name" class="form-control form-control-lg" required>
		</div>
		<div class="mb-3">
			<label class="form-label">Name</label>
			<input type="text" id="fullname" name="fullname" class="form-control form-control-lg" required>
		</div>
		<div class="mb-3">
			<label class="form-label">Status ID</label>
			<input type="number" id="status_id" name="status_id" class="form-control form-control-lg" required>
		</div>
		<input type="hidden" name="user_id" value="<?php echo $_SESSION['admin_id'] ?>">
		<button class="custom-btn custom-btn-md custom-btn-primary" id="save_employer">Neuen Status anlegen</button>
	</form>
	<script>
	$(document).ready(function () {
		$('#status_form').on('submit', function (event) {
			event.preventDefault();
			if (!this.checkValidity()) {
				event.stopPropagation();
			} else {
				$.ajax({
					url: 'pages/status/inc/save.php',
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