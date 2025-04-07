<?php
require_once '../inc/settings.php';
require_once 'inc/settings.php';
require_once "../inc/dbconnect.php";
require_once "../inc/functions.php";
require_once "inc/functions.php";
require_once "inc/run.php";
ob_start();
$company = getCompanyData($mysqli);
header('Content-Type: text/html; charset=utf-8');
?>
<!doctype html>
<html>
<?php include_once "inc/head.php"; ?>
<body class="bg-white <?php echo $current_page ?>">
	<?php if(isLoggedInAsAdmin()) { ?>
		<?php include_once "header/header.php"; ?>
		<div class="container-fliud">
			<?php include_once $page_file ?>
		</div>
	<?php } else {
		if(isset($_GET["page"])) {
			if($_GET["page"] == "passwort-vergessen") {
				include_once "../pages/forgot_password/forgot_password.php";
			} elseif($_GET["page"] == "passwort-zuruecksetzen") {
				include_once "../pages/reset_password/reset_password.php";
			} else {
				header("Location:" . ADMIN_BASEHREF);
				exit();
			}
		} else {
			include_once "pages/login/login.php";
		}
	}
	?>
</body>
</html>
<?php
ob_end_flush();
//echo "<div class='bg-dark text-white' style='font-size:0.75rem'>"; echo "<pre>";var_dump($_SESSION); echo "</pre>"; echo "</div>"; ?>