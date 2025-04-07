<div class="row">
	<input type="hidden" name="entry_id" value="<?php echo $entry_id ?>">
	<div class="col-auto">
		<a class="custom-btn custom-btn-md <?php echo BTN_OUTLINE_SECONDARY ?>" href="<?php echo $back_page_url ?>">
			<span class="btn-text">Zurück</span>
		</a>
	</div>
	<div class="col text-end">
		<button name="proceed" class="custom-btn custom-btn-md <?php echo BTN_PRIMARY ?> w-100">
			<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
			<span class="btn-text">
				<i class="fa-regular fa-circle-check fa-lg me-2"></i>
				<span class="d-md-inline-block d-none">Speichern und weiter</span>
				<span class="d-md-none d-inline-block">Speichern</span>
			</span>
		</button>
	</div>
	<div class="col-12 text-center font-weight-400">
		<div id="message" class="mt-md-4 mt-3" style="display: none"></div>
	</div>
</div>