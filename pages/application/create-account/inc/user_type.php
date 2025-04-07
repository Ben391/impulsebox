<div class="row border-bottom pb-3 mb-3">
	<h2 class="h4 mb-3">Ich bin</h2>
	<div class="col-12">
		<div class="form-check form-check-inline me-1">
			<input class="form-check-input" type="radio" name="user_type" value="1" required <?php if($user_type == 1) echo "checked "; ?>>
			<label class="form-check-label">
				Versicherter / Pflegebedürftiger
			</label>
		</div>
	</div>
	<div class="col-12">
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="user_type" value="2" <?php if($user_type == 2) echo "checked "; ?>>
			<label class="form-check-label">
				Angehöriger / Pflegeperson
			</label>
		</div>
	</div>
	<div class="col-12">
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="user_type" value="3" <?php if($user_type == 3) echo "checked "; ?>>
			<label class="form-check-label">
				Pflegedienst
			</label>
		</div>
		<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_USER_TYPE ?></div>
	</div>
</div>