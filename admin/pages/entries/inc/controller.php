<?php
$entry_status = $e["entry_status"];
$entry_status_name = $e["entry_status_name"];
$entry_status_data = "";
if(isset($e["entry_status_data"])) {
	$entry_status_data = $e["entry_status_data"];
}
$entry_id = $e["entry_id"];
$entry_number = $e["entry_number"];
$entry_import_id = $e['entry_import_id'];
$user_id = $e["user_id"];
$user_type = $e["user_type"];
$user_type_name = $e["user_type_name"];
$entry_create_datetime_formatted = date("d.m.Y H:i", $e["entry_create_date"]);
$entry_complete_date = $e["entry_complete_date"];
$entry_complete_datetime_formatted = date("d.m.Y H:i", $entry_complete_date);
$insured_person_data_first_name  = $e["insured_person_data_first_name"];
$insured_person_data_last_name = $e["insured_person_data_last_name"];
$insurance_type_short_name = $e["insurance_type_short_name"];
$custom_insurance_company_name = $e["custom_insurance_company_name"];
$compilation_name = $e["compilation_name"];
$bed_protectors_amount = $e['bed_protectors_amount'];
if(!empty($custom_insurance_company_name)) {
	$insurance_company_name = $custom_insurance_company_name;
} else {
	$insurance_company_name = $e["insurance_company_name"];
}
$care_giver_person_first_name = $e["care_giver_person_first_name"];
$care_giver_person_last_name = $e["care_giver_person_last_name"];