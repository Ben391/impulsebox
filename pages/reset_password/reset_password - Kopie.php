<?php
if(defined("IS_ADMIN") AND IS_ADMIN) {
	$user_table = "admins";
	$back_url = ADMIN_BASEHREF;
} else {
	$user_table = "users";
	$back_url = BASEHREF;
}
$isValid = false;
if (isLoggedIn() OR isLoggedInAsAdmin()) {
	$isValid = true;
	if(isLoggedIn()) {
		$userId = $_SESSION['user_id'];
	} elseif(isLoggedInAsAdmin()) {
		$adminId = $_SESSION['admin_id'];
	}
} elseif (isset($_GET['token'])) {
	$token = $_GET['token'];
	try {
	    $stmt = $mysqli->prepare("SELECT token_expiry FROM $user_table WHERE reset_token = ? AND token_expiry > NOW()");
	    $stmt->bind_param("s", $token);
	    $stmt->execute();
	    $stmt->bind_result($token_expiry);
	    $isValid = $stmt->fetch();
	    $stmt->close();
	} catch (Exception $e) {
	    $isValid = false;
	}
} ?>
<script>
	const admin_area = false;
</script>
<?php
if(isLoggedIn()) { ?>
<script>
    const userId = <?php echo json_encode($_SESSION['user_id']); ?>;
</script>
<?php } elseif (isLoggedInAsAdmin()) { ?>
<script>
    const adminId = <?php echo json_encode($_SESSION['admin_id']); ?>;
</script>
<?php } elseif (defined("IS_ADMIN") AND IS_ADMIN) { ?>
<script>
    const admin_area = true;
</script>
<?php } ?>
<div class="container py-5">
	<?php if($isValid) { ?>
	<div class="row justify-content-center py-5">
		<div class="col-md-4 text-center">
			<form class="form p-md-4 p-3 mb-3 bg-light-grey rounded-4" id="resetPasswordForm" method="POST">
				<h1 class="h3 mb-4">Neues Passwort setzen</h1>
				<div class="col mb-4">
					<input class="form-control form-control-lg" type="password" id="new_password" name="new_password" placeholder="Passwort eingeben" required>
				</div>
				<div class="col mb-4">
					<input class="form-control form-control-lg" type="password" id="confirm_password" name="confirm_password" placeholder="Passwort wiederholen" required>
				</div>
				<div class="col">
					<button type="submit" class="custom-btn custom-btn-md <?php echo BTN_PRIMARY ?> w-100">
						<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
						<span class="btn-text">Passwort ändern</span>
					</button>
				</div>
			</form>
			<div class="text-center font-weight-400">
				<div id="message" class="mt-md-4 mt-3 mb-3" style="display: none"></div>
			</div>
		</div>
	</div>
	<?php } else { ?>
	<div class="row py-5 text-center">
		<div class="col mb-1">
			Der Link ist ungültig oder abgelaufen.<br>
			<a href="<?php echo $back_url ?>">Zurück</a>
		</div>
	</div>
	<?php } ?>
</div>
<script>
$(document).ready(function() {
	const $form = $("#resetPasswordForm");
	$form.submit(function(e) {
		e.preventDefault();

		const newPassword = $("#new_password").val();
		const confirmPassword = $("#confirm_password").val();
		
		// Überprüfung der Mindestlänge
		if (newPassword.length < 8) {
			$("#message").show().addClass("text-danger").html("Das Passwort muss mindestens 8 Zeichen lang sein.");
			return;
		}
        
		// Regex-Prüfung für mindestens einen Buchstaben, eine Ziffer und ein Symbol
		const hasLetter = /[a-zA-Z]/.test(newPassword);
		const hasDigit = /\d/.test(newPassword);
		const hasSymbol = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(newPassword);
		
		let missingItems = [];
		
		if (!hasLetter) missingItems.push("einen Buchstaben");
		if (!hasDigit) missingItems.push("eine Ziffer");
		if (!hasSymbol) missingItems.push("ein Symbol");

		if (missingItems.length > 0) {
			const missingString = missingItems.join(", ");
			$("#message").show().addClass("text-danger").html(`Das Passwort muss mindestens ${missingString} enthalten.`);
			return;
		}

		if (newPassword !== confirmPassword) {
			$("#message").show().addClass("text-danger").html("Die eingegebenen Passwörter stimmen nicht überein.");
			return;
		}

		const token = new URLSearchParams(window.location.search).get("token");
		
        let requestData = { 
			new_password: newPassword,
			admin_area: admin_area,
		};
        
        if (typeof userId !== "undefined") {
            requestData.user_id = userId;
        } else if (typeof adminId !== "undefined") {
            requestData.admin_id = adminId;
        } else {
            const token = new URLSearchParams(window.location.search).get("token");
            requestData.token = token;
        }

		$.ajax({
			url: '<?php echo BASEHREF ?>pages/reset_password/send_reset_password.php',
			method: 'POST',
			dataType: 'json',
			data: requestData,
			success: function(response) {
				const data = response;
				if (data.success) {
					$form.hide();
					$("#message").show().removeClass("text-danger").addClass("text-success").html("Passwort wurde erfolgreich zurückgesetzt. Sie werden gleich weitergeleitet.");
                    setTimeout(() => {
                        if (typeof userId !== "undefined") {
                            window.location.href = "konto/";
                        } else if (typeof adminId !== "undefined") {
                            window.location.href = "profile/";
                        } else if (admin_area == true) {
                            window.location.href = "/admin/";
                        }
                    }, 4000);
				} else {
					$("#message").show().addClass("text-danger").html(data.message || "Ein Fehler ist aufgetreten.");
				}
			},
			error: function() {
				$("#message").show().addClass("text-danger").html("Ein Fehler ist aufgetreten.");
			}
		});
	});
});
</script>