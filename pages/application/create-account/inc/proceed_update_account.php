<input type="hidden" name="user_id" value="<?php echo $user_id ?>">
<input type="hidden" name="entry_id" value="<?php echo $entry_id ?>">
<input type="hidden" name="agreement_id" value="<?php echo $agreement_id ?>">
<input type="hidden" name="insured_person_id" value="<?php echo $insured_person_id ?>">
<div class="col-md col-auto">
	<a class="custom-btn custom-btn-md <?php echo BTN_OUTLINE_SECONDARY ?>" href="<?php echo $back_page_url ?>">
		<span class="btn-text">
			Zurück
		</span>
	</a>
</div>
<div class="col text-end">
	<button name="proceed" class="custom-btn custom-btn-md <?php echo BTN_PRIMARY ?> w-md-100-custom">
		<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
		<span class="btn-text">
			<i class="fa-regular fa-circle-check fa-lg me-2"></i>
			<span class="d-md-inline-block d-none">Speichern und weiter</span>
			<span class="d-md-none d-inline-block">Speichern</span>
		</span>
	</button>
</div>