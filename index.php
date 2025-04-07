<?php
require_once 'inc/protect.php'; // Passwort Schutz
require_once 'inc/settings.php';
require_once "inc/dbconnect.php";
require_once "inc/functions.php";
if(isLoggedIn() OR isLoggedInAsAdmin()) {
	require_once "inc/run-application.php";
} else {
	require_once "inc/run-application-session.php";
}
require_once "inc/run.php";
require_once "inc/redirects.php";
include_once "inc/textblocks.php";
include_once "inc/svgs.php";
$company = getCompanyData($mysqli);
if($total_price = getCompilationPrices()) {
	$compilation_max_total_price = floatval($total_price["compilation_max_total_price"]);
	$compilation_min_total_price = floatval($total_price["compilation_min_total_price"]);
} else {
	$compilation_max_total_price = 40;
	$compilation_min_total_price = 29;
}
?>
<!doctype html>
<html>
<?php include_once "inc/head.php" ?>
<body class="bg-white <?php echo $current_page ?>">
	<?php 
	if(isLoggedInAsAdmin()) { include_once "header/admin-panel.php"; }
	if(!is_home(HOMEURL)) { include_once "header/header.php"; } 
	?>
	<div class="container-fluid p-0">
		<?php if($header_progress_bar == true) include "inc/application-progress-bar.php"; ?>
		<?php include_once $page_file ?>
	</div>
	<?php include_once "footer/footer.php"; ?>
</body>
</html>
<?php //echo "<div class='bg-dark text-white' style='font-size:0.75rem'>"; echo "<pre>";var_dump($_SESSION); echo "</pre>"; echo "</div>"; ?>