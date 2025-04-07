<div class="col-md-6 mb-4">
	<h2 class="h4 mb-1">Neuen Mitarbeiter anlegen</h2>
	<p class="ftsz-1">Legen Sie einen neuen Benutzer an. Sobald der Benutzer angelegt ist, kann er auf der Administration-Loginseite auf „Passwort vergessen“ klicken und seine E-Mail-Adresse eingeben. Anschließend erhält er eine E-Mail mit einem Link, über den er ein neues Passwort definieren kann.</p>
	<form method="POST" action="" class="form p-md-4 p-3 mb-3 bg-light-grey rounded-4">
		<div class="mb-3">
			<label class="form-label">Vorname</label>
			<input type="text" id="first_name" class="form-control form-control-lg" required>
		</div>
		<div class="mb-3">
			<label class="form-label">Nachname</label>
			<input type="text" id="last_name" class="form-control form-control-lg" required>
		</div>
		<div class="mb-3">
			<label class="form-label">E-Mail-Adresse</label>
			<input type="email" id="employer_email" class="form-control form-control-lg" required>
		</div>
		<button class="custom-btn custom-btn-md custom-btn-primary" id="save_employer">Neuen Mitarbeiter anlegen</button>
	</form>
</div>