<div class="container py-4">
	<div class="row">
		<h1 class="h2 mb-3">Profil</h1>
		<div class="col-12 mb-4">	
			<h3 class="mb-1"><?php echo $admin["first_name"]." ".$admin["last_name"] ?></h3>
			<p><?php echo $admin["email"] ?></p>
			<div>
				<a href="<?php echo ADMIN_BASEHREF ?>passwort-zuruecksetzen/">Passwort ändern</a>
			</div>
		</div>
	</div>
</div>