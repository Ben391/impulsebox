<div class="row border-bottom pb-3 mb-3">
	<div class="col-12 mb-3">
		<label class="form-label">Ihre E-Mail-Adresse</label>
		<p class="line-height-14 text-muted ftsz-1">Die angegebene E-Mail-Adresse wird für die Erstellung Ihres Kundenkontos verwendet</p>
		<div class="row">
			<div class="col-md-8 col-12">
				<input 
					   minlength="5" 
					   maxlength="45" 
					   type="email" 
					   class="form-control form-control-lg" 
					   name="user_email" 
					   id="user_email" 
					   value="<?php echo $user_email ?>" <?php if(isset($entry_data["user_data"]["user_email"])) echo "disabled "; ?> 
					   required>
			</div>
		</div>
	</div>
	<div class="col-md-8 col-12 mb-3" id="confirm-email-row" style="display: none;">
		<label class="form-label">Ihre E-Mail-Adresse bestätigen</label>
		<input 
			   minlength="5" 
			   maxlength="45" 
			   type="email" 
			   class="form-control form-control-lg" 
			   placeholder="E-Mail-Adresse noch einmal eingeben"
			   name="confirm_user_email" 
			   id="confirm_user_email" 
			   value="<?php echo $user_email ?>" 
			   required>
	</div>
</div>