<div class="col">
	<?php if(isLoggedIn()) { ?>
	<div class="btn-group" role="group" aria-label="Basic outlined example">
		<div class="btn disabled d-flex" style="">
			<?php 
			if($user_type == 1) {
				echo "Versicherter | ";
			} elseif($user_type == 2) {
				echo "Pflegeperson | ";
			}
			?>
			<?php echo $user_email ?>
		</div>
		<a class="btn btn-danger" href="auth/logout.php" class="logout-button">Abmelden</a>
	</div>
	<?php } else { ?>
	<form class="row" id="loginForm">
		<div class="col-auto">
			<input class="form-control" type="text" id="email" placeholder="Benutzername" required>
		</div>
		<div class="col-auto">
			<input class="form-control" type="password" id="password" placeholder="Passwort" required>
		</div>
		<div class="col-auto">
			<button class="btn btn-blue-impulsebox" type="submit">Anmelden</button>
		</div>
	</form>
	<div id="message-login"></div>
    <script type="text/javascript">
        var PUBLIC_KEY = "<?php echo PUBLIC_KEY ?>";
    </script>
	<script src="<?php echo BASEHREF ?>js/login.js?v2"></script>
	<?php } ?>
</div>
