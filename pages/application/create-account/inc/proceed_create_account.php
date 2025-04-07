<input type="hidden" name="insured_person_salutation" value="<?php echo isset($_SESSION["insured_person_data"]["insured_person_salutation"]) ? $_SESSION["insured_person_data"]["insured_person_salutation"] : ""; ?>">
<input type="hidden" name="insured_person_first_name" value="<?php echo isset($_SESSION["insured_person_data"]["insured_person_first_name"]) ? $_SESSION["insured_person_data"]["insured_person_first_name"] : ""; ?>">
<input type="hidden" name="insured_person_last_name" value="<?php echo isset($_SESSION["insured_person_data"]["insured_person_last_name"]) ? $_SESSION["insured_person_data"]["insured_person_last_name"] : ""; ?>">
<input type="hidden" name="insured_person_birth_date" value="<?php echo isset($_SESSION["insured_person_data"]["insured_person_birth_date"]) ? $_SESSION["insured_person_data"]["insured_person_birth_date"] : ""; ?>">
<input type="hidden" name="insured_person_phone" value="<?php echo isset($_SESSION["insured_person_data"]["insured_person_phone"]) ? $_SESSION["insured_person_data"]["insured_person_phone"] : ""; ?>">
<input type="hidden" name="insured_person_email" value="<?php echo isset($_SESSION["insured_person_data"]["insured_person_email"]) ? $_SESSION["insured_person_data"]["insured_person_email"] : ""; ?>">
<input type="hidden" name="insurance_type" value="<?php echo isset($_SESSION["insured_person_data"]["insurance_type"]) ? $_SESSION["insured_person_data"]["insurance_type"] : ""; ?>">
<input type="hidden" name="insurance_number" value="<?php echo isset($_SESSION["insured_person_data"]["insurance_number"]) ? $_SESSION["insured_person_data"]["insurance_number"] : ""; ?>">
<input type="hidden" name="insurance_company_id" value="<?php echo isset($_SESSION["insured_person_data"]["insurance_company_id"]) ? $_SESSION["insured_person_data"]["insurance_company_id"] : ""; ?>">
<input type="hidden" name="custom_insurance_company" value="<?php echo isset($_SESSION["insured_person_data"]["custom_insurance_company"]) ? $_SESSION["insured_person_data"]["custom_insurance_company"] : ""; ?>">
<input type="hidden" name="custom_insurance_company_name" value="<?php echo isset($_SESSION["insured_person_data"]["custom_insurance_company_name"]) ? $_SESSION["insured_person_data"]["custom_insurance_company_name"] : ""; ?>">
<input type="hidden" name="care_level" value="<?php echo isset($_SESSION["insured_person_data"]["care_level"]) ? $_SESSION["insured_person_data"]["care_level"] : ""; ?>">
<input type="hidden" name="care_level_since" value="<?php echo isset($_SESSION["insured_person_data"]["care_level_since"]) ? $_SESSION["insured_person_data"]["care_level_since"] : ""; ?>">
<input type="hidden" name="insured_person_street" value="<?php echo isset($_SESSION["insured_person_data"]["insured_person_street"]) ? $_SESSION["insured_person_data"]["insured_person_street"] : ""; ?>">
<input type="hidden" name="insured_person_address_addition" value="<?php echo isset($_SESSION["insured_person_data"]["insured_person_address_addition"]) ? $_SESSION["insured_person_data"]["insured_person_address_addition"] : ""; ?>">
<input type="hidden" name="insured_person_zipcode" value="<?php echo isset($_SESSION["insured_person_data"]["insured_person_zipcode"]) ? $_SESSION["insured_person_data"]["insured_person_zipcode"] : ""; ?>">
<input type="hidden" name="insured_person_city" value="<?php echo isset($_SESSION["insured_person_data"]["insured_person_city"]) ? $_SESSION["insured_person_data"]["insured_person_city"] : ""; ?>">
<input type="hidden" name="bed_protectors_amount" value="<?php echo $bed_protectors_amount ?>">
<input type="hidden" name="products" value="<?php echo $products_json_htmlentities ?>">
<input type="hidden" name="compilation_name" value="<?php echo $compilation_name ?>">
<div class="col-md-6 col-auto">
	<a class="custom-btn custom-btn-md <?php echo BTN_OUTLINE_SECONDARY ?>" href="<?php echo $back_page_url ?>">
		<span class="btn-text">
			Zurück
		</span>
	</a>
</div>
<div class="col-md-6 col text-end mb-3">
	<button name="proceed" class="custom-btn custom-btn-md <?php echo BTN_PRIMARY ?> w-100">
		<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
		<i class="fa-solid fa-triangle-exclamation fa-lg" style="display: none"></i>
		<span class="btn-text">
			<i class="fa-regular fa-circle-check fa-lg me-2 d-md-inline-block d-none"></i>
			<span class="btn-text font-weight-400">Konto erstellen</span>
		</span>
	</button>
	<script src="https://www.google.com/recaptcha/api.js?render=<?php echo PUBLIC_KEY ?>"></script>
</div>
<div class="col-12">
	<div class="text-center ftsz-1 p-2">
		<p class="mb-1 font-weight-600">Sie geben noch keine Bestellung ab</p>
		<p class="mb-0">Nach der Kontoerstellung werden Sie sofort automatisch eingeloggt und können Ihren Antrag fortsetzen. Ihr Passwort wird umgehend an die von Ihnen angegebene E-Mail-Adresse gesendet, damit Sie sich jederzeit erneut einloggen können.</p>
	</div>
</div>