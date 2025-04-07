<?php
$entry_number = $e['entry_data']['entry_number'];
$entry_create_date_formatted = date("d.m.Y", $e['entry_data']["entry_create_date"]);
$entry_create_datetime_formatted = date("d.m.Y H:i", $e['entry_data']["entry_create_date"]);
$entry_import_id = $e['entry_data']['entry_import_id'];
$entry_status_data = $e['entry_status_data'];
// User
$user_id = $e['user_data']['user_id'];
$user_email = $e['user_data']['user_email'];
$user_type = $e['user_data']['user_type'];
$user_type_name = $e['user_data']['user_type_name'];
// Versicherter
$insured_person_id = $e['insured_person_data']['insured_person_id'];
$insured_person_salutation = $e['insured_person_data']['insured_person_salutation'];
$insured_person_salutation_name = $e['insured_person_data']['insured_person_salutation_name'];
$insured_person_address_id = $e['insured_person_data']['insured_person_address_id'];
$insured_person_first_name = $e['insured_person_data']['insured_person_first_name'];
$insured_person_last_name = $e['insured_person_data']['insured_person_last_name'];
$insured_person_birth_date = $e['insured_person_data']['insured_person_birth_date'];
$insured_person_phone = $e['insured_person_data']['insured_person_phone'];
$insured_person_email = $e['insured_person_data']['insured_person_email'];
$insured_person_street = $e['insured_person_data']['insured_person_street'];
$insured_person_address_addition = $e['insured_person_data']['insured_person_address_addition'];
$insured_person_zipcode = $e['insured_person_data']['insured_person_zipcode'];
$insured_person_city = $e['insured_person_data']['insured_person_city'];
$insurance_type = $e['insured_person_data']['insurance_type'];
$insurance_type_name = $e['insured_person_data']['insurance_type_name'];
$insurance_number = $e['insured_person_data']['insurance_number'];
$insurance_company_id = $e['insured_person_data']['insurance_company_id'];
$custom_insurance_company_name = $e['insured_person_data']["custom_insurance_company_name"];
if(!empty($custom_insurance_company_name)) {
	$insurance_company_name = $custom_insurance_company_name;
} else {
	$insurance_company_name = $e['insured_person_data']["insurance_company_name"];
}
$insurance_aid = $e['insured_person_data']['insurance_aid'];
$care_level = $e['insured_person_data']['care_level'];
$care_level_since = $e['insured_person_data']['care_level_since'];
if(isset($e['product_data'])) {
	$compilation_name = $e['product_data']["compilation_name"];
}
$bed_protectors_amount = $e['entry_data']['bed_protectors_amount'];
if(isset($e["product_data"]["product_full_data"])) {
	$product_full_data = $e["product_data"]["product_full_data"];
} else {
	$product_full_data = "";
}
// Beratung
$consultation_status = $e['consultation_data']["status"];
$consultation_form = $e['consultation_data']["form"];
$consultation_partner = $e['consultation_data']["partner"];
$consultation_consultant = $e['consultation_data']["consultant"];
$consultation_date_formatted = $e['consultation_data']["date"];
// Lieferung
$delivery = $e['delivery_data']['delivery'];
$delivery_frequency = $e['delivery_data']['delivery_frequency'];
$delivery_frequency_name = $e['delivery_data']['delivery_frequency_name'];
$supplier_change = $e['delivery_data']['supplier_change'];
$supplier_change_delivery_start = $e['delivery_data']['supplier_change_delivery_start'];
// Pflegeperson
$care_giver_person_id = $e['care_giver_person_data']['care_giver_person_id'];
$care_giver_person_salutation_name = $e['care_giver_person_data']['care_giver_person_salutation_name'];
$care_giver_person_first_name = $e['care_giver_person_data']['care_giver_person_first_name'];
$care_giver_person_last_name = $e['care_giver_person_data']['care_giver_person_last_name'];
$care_giver_person_street = $e['care_giver_person_data']['care_giver_person_street'];
$care_giver_person_address_addition = $e['care_giver_person_data']['care_giver_person_address_addition'];
$care_giver_person_zipcode = $e['care_giver_person_data']['care_giver_person_zipcode'];
$care_giver_person_city = $e['care_giver_person_data']['care_giver_person_city'];
$care_giver_person_phone = $e['care_giver_person_data']['care_giver_person_phone'];
$care_giver_person_email = $e['care_giver_person_data']['care_giver_person_email'];
// Pflegedienst
$care_giver_service_id = $e['care_giver_service_data']['care_giver_service_id'];
$care_giver_service_company = $e['care_giver_service_data']['care_giver_service_company'];
$care_giver_service_street = $e['care_giver_service_data']['care_giver_service_street'];
$care_giver_service_address_addition = $e['care_giver_service_data']['care_giver_service_address_addition'];
$care_giver_service_zipcode = $e['care_giver_service_data']['care_giver_service_zipcode'];
$care_giver_service_city = $e['care_giver_service_data']['care_giver_service_city'];
$care_giver_service_phone = $e['care_giver_service_data']['care_giver_service_phone'];
$care_giver_service_email = $e['care_giver_service_data']['care_giver_service_email'];