<?php if(isLoggedIn()) { ?>
<div class="container py-md-5 py-0">
	<div class="row mb-md-3 mb-1">
		<div class="col mb-md-2 mb-1">
			<h1 class="mb-0">Mein Konto</h1>
		</div>
		<div class="col-auto d-flex align-items-center text-end mb-2">
			<a class="text-main-blue-impulsebox" href="#" data-bs-toggle="modal" data-bs-target="#contact">Sie wünschen eine Änderung?</a>
		</div>
	</div>
	<div class="row pb-5">
		<div class="col-md-7 px-md-2 px-1 mb-3">
			<div class="p-md-4 p-3 mb-3 bg-light-grey rounded-4">
				<div class="">
					<h2 class="h3">Sie sind: <?php echo $user_type_name; ?></h2>
				</div>
				<?php 
				include_once "pages/account/inc/change-password.php";
				include_once "views/entry-status.php";
				include_once "views/application-number-pdf.php";
				include_once "views/insured-person-data.php";
				include_once "views/delivery-data.php";
				if(isset($care_giver_person_id) AND !empty($care_giver_person_id)) {
					include_once "views/care-giver-person-data.php";
				}
				if(isset($care_giver_service_id) AND !empty($care_giver_service_id)) {
					include_once "views/care-giver-service-data.php";
				}
				?>
			</div>
		</div>
		<div class="col-md-5 px-md-2 px-1 mb-md-3 mb-2 order-md-last order-first"><?php include_once "views/your-box.php"; ?></div>
	</div>
<?php } else { ?>
<div class="container py-5">
	<div class="row text-center">
		<div class="col text-muted mb-3">
			<h2 class="h5 mb-0">Sie sind bereits Kunde?</h2>
			<p class="mb-0">Hier können Sie die Zusammenstellung Ihrer Pflegebox anpassen oder uns Änderungen mitteilen.</p>
		</div>
	</div>
	<div class="row justify-content-center py-5">
		<div class="col-md-4 text-center">
			<h1 class="mb-3">Anmelden</h1>
			<form class="form" id="loginForm">
				<div class="col mb-4">
					<input class="form-control form-control-lg" type="email" id="email" placeholder="E-Mail-Adresse" required>
				</div>
				<div class="col mb-4">
					<input class="form-control form-control-lg" type="password" id="password" placeholder="Passwort" required>
				</div>
				<div class="col mb-4">
					<input type="hidden" id="role" name="role" value="1">
					<button type="submit" id="login_button" class="custom-btn custom-btn-md <?php echo BTN_PRIMARY ?> w-100">
						<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
						<span class="btn-text">Anmelden</span>
					</button>
				</div>
				<div class="col-12 text-center font-weight-400">
					<div id="message-login" class="mt-md-4 mt-3 mb-3"></div>
				</div>
				<div class="col px-2">
					<div class="row">
						<div class="col text-center">
							<a href="<?php echo BASEHREF ?>passwort-vergessen/">Passwort vergessen?</a>
						</div>
					</div>
				</div>
			</form>
			<script src="https://www.google.com/recaptcha/api.js?render=<?php echo PUBLIC_KEY ?>"></script>
			<script type="text/javascript">
				var PUBLIC_KEY = "<?php echo PUBLIC_KEY ?>";
			</script>
			<script src="<?php echo BASEHREF ?>js/login.js?v24"></script>
		</div>
	</div>
</div>
<?php } ?>