<?php
$where = "";
// Check for insurance_type
if(isset($_GET["insurance_type"])) {
	if($_GET["insurance_type"] == 1 || $_GET["insurance_type"] == 2) {
		$where .= (empty($where) ? "" : " AND ") . "insurance_data.insurance_type = " . intval($_GET["insurance_type"]);
	}
}
// Check for status
if(isset($_GET["status"]) && !empty($_GET["status"])) {
	$where .= (empty($where) ? "" : " AND ") . "aps.status = " . intval($_GET["status"]);
}

// Check for start_date
if (!empty($_GET['start_date'])) {
	$start_date = strtotime($_GET['start_date']);
	$where .= (empty($where) ? "" : " AND ") . "e.create_date >= " . $start_date;
}

// Check for end_date
if (!empty($_GET['end_date'])) {
	$end_date = strtotime($_GET['end_date']);

	// If start_date and end_date are the same day, set end_date to the end of the day
	if (date('Y-m-d', $start_date) == date('Y-m-d', $end_date)) {
		$end_date = strtotime(date('Y-m-d 23:59:59', $end_date));
	}

	$where .= (empty($where) ? "" : " AND ") . "e.create_date <= " . $end_date;
}