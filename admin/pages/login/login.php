<div class="container py-5">
    <div class="row justify-content-center py-5">
        <div class="col-md-4 text-center">
			<div class="p-md-4 p-3 mb-3 bg-light-grey rounded-4">
				<a href="<?php echo BASEHREF ?>">
					<img class="img-fluid mb-4" src="<?php echo BASEHREF ?>img/logo/logo.svg" style="width: 170px">
				</a>
				<h1 class="h3 text-muted mb-3">Administration</h1>
				<form class="form" id="loginForm" method="post">
					<div class="col mb-4">
						<input class="form-control form-control-lg" type="email" id="email" name="email" placeholder="Login" required>
					</div>
					<div class="col mb-4">
						<input class="form-control form-control-lg" type="password" id="password" name="password" placeholder="Passwort" required>
					</div>
					<div class="col mb-3">
						<input type="hidden" id="role" name="role" value="2">
						<button type="submit" id="login_button" class="custom-btn custom-btn-md <?php echo BTN_PRIMARY ?> w-100">
							<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
							<span class="btn-text">Anmelden</span>
						</button>
					</div>
					<div class="col-12 text-center font-weight-400">
						<div id="message-login" class="mt-md-4 mt-3 mb-3" style="display: none"></div>
					</div>
					<div class="col px-2">
						<div class="row">
							<div class="col text-center">
								<a href="<?php echo ADMIN_BASEHREF ?>passwort-vergessen/">Passwort vergessen?</a>
							</div>
						</div>
					</div>
				</form>
				<script src="https://www.google.com/recaptcha/api.js?render=<?php echo PUBLIC_KEY ?>"></script>
				<script type="text/javascript">
					var PUBLIC_KEY = "<?php echo PUBLIC_KEY ?>";
				</script>
				<script src="<?php echo BASEHREF ?>js/login.js?v4"></script>
			</div>
        </div>
    </div>
</div>