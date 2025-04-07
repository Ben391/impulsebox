<?php
$current_page = "";
$current_page_area = "";
$page_file = "";
$header_progress_bar = false;
if(is_home(ADMIN_HOMEURL)) {
	$current_page = "home";
	$page_file = 'pages/home/home.php';
	if(isset($_GET["p"])) {
		$page_file = 'pages/home/home.php';
	}
} else {
	if(isset($_GET["page"]) AND !empty($_GET["page"])) {
		$current_page = $_GET["page"];
		switch ($current_page) {
			case 'status':
				$page_file = 'pages/status/status.php'; 
				break;
			case 'entries':
				$page_file = 'pages/entries/entries.php'; 
				break;
			case 'entry':
				$page_file = 'pages/entry/entry.php'; 
				break;
			case 'products':
				$page_file = 'pages/products/products.php'; 
				break;
			case 'compilations':
				$page_file = 'pages/compilations/compilations.php'; 
				break;	
			case 'email-vorlagen':
				$page_file = 'pages/mail-templates/mail-templates.php'; 
				break;
			case 'mitarbeiter':
				$page_file = 'pages/employees/employees.php'; 
				break;
			case 'import':
				$page_file = 'pages/import/import.php'; 
				break;
			case 'profile':
				$page_file = 'pages/profile/profile.php'; 
				break;
			case 'passwort-zuruecksetzen':
				$page_file = '../pages/reset_password/reset_password.php'; 
				break;
			case 'caregiver-services':
				$page_file = 'pages/caregiver-services/caregiver-services.php'; 
				break;
			case 'company-data':
				$page_file = 'pages/company-data/company-data.php'; 
				break;
			case 'rechtliches':
				$page_file = 'pages/rechtliches/rechtliches.php'; 
				break;
		}
	}
}