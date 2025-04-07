<div class="row mb-4 border-bottom">
	<h2 class="h3 mb-2">Ihr Konto</h2>
	<div class="col-12 mb-3">
		Sie sind: <?php echo $user_type_name ?>
	</div>
	<div class="col-12">
		<h3 class="h5 mb-3">Zugangsdaten</h3>
	</div>
	<div class="col mb-3">
		<h4 class="h6 mb-1">E-Mail-Adresse</h5>
		<?php echo $user_email ?>
	</div>
	<?php if(!is_admin_area()) { ?>
	<div class="col mb-3">
		<h4 class="h6 mb-1">Passwort</h5>
		<p class="line-height-14 ftsz-1">Das Passwort wurde an die angegebene E-Mail-Adresse verschickt</p>
	</div>
	<?php } ?>
</div>