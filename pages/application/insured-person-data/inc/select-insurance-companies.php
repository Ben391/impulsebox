<?php
include_once "../../../../inc/settings.php";
include_once "../../../../inc/dbconnect.php";
include_once "../../../../inc/functions.php";
if(isset($_POST['insurance_type'])) {
	$type = $_POST['insurance_type'];
	$companies = getInsuranceCompanies($mysqli, $type);
	echo json_encode($companies);
}