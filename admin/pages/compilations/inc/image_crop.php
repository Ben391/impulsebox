<div class="col-auto">
	<?php 
	$img_src = '../img/compilations/' . $compilation["id"] . '.png';
	if(!file_exists($img_src)) {
		$img_src = "/../../../../img/icons/upload_image_impulse.svg";
	}
	if($compilation["active"] == 0) { ?>
	<img 
		 src="<?php echo $img_src ?>" 
		 id="uploaded_image_<?php echo $compilation["id"] ?>" 
		 class="img-responsive img-circle" 
		 width="20px" 
		 height="20px">
	<?php } else { ?>
	<div class="image_area">
		<form method="post">
			<label for="upload_image_<?php echo $compilation["id"] ?>">
				<img 
					 src="<?php echo $img_src."?".time() ?>" 
					 id="uploaded_image_<?php echo $compilation["id"] ?>" 
					 class="img-responsive img-circle" 
					 width="40px" 
					 height="40px" style="cursor: pointer">
				<input type="file" name="image" class="image" id="upload_image_<?php echo $compilation["id"] ?>" style="display:none" />
			</label>
		</form>
	</div>
	<div class="modal fade" id="modal-<?php echo $compilation["id"] ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel-<?php echo $compilation["id"] ?>" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Bild vor dem Hochladen zuschneiden</h5>
					<button type="button" class="close rounded-3" style="height:fit-content" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="img-container">
						<div class="row">
							<div class="col-md-8" style="max-height: 600px">
								<img src="" id="sample_image_<?php echo $compilation["id"] ?>" />
							</div>
							<div class="col-md-4">
								<div class="preview"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="crop_<?php echo $compilation["id"] ?>" class="btn btn-primary crop" data-compilations-id="<?php echo $compilation["id"] ?>">Zuschneiden</button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>