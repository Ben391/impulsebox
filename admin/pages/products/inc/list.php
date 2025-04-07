<div class="col-md-6">
	<?php
	if($products = getProducts($mysqli,0)) { 
		$activeted_products = getProducts($mysqli, 1);
		$activeted_products_number = count($activeted_products);
		?>
		<h2 class="h4 mb-1">Vorhandene Produkte</h2>
		<p class="ftsz-1 mb-2">Es sind <strong><?php echo $activeted_products_number ?></strong> Produkte aktivert.</p>
		<div id="products" class="row">
			<?php foreach($products AS $product) { ?>
				<div id="product-<?php echo $product["id"] ?>" class="col-12 mb-3 p-md-4 p-3 mb-3 bg-light-grey rounded-4 <?php if($product["active"] == 0) echo " opacity-50" ?>">
					<div class="row d-flex align-items-center mb-2">
						<div class="col mb-1">
							<input 
								   type="text" 
								   class="form-control product-name" 
								   value="<?php echo $product["name"] ?>"
								   placeholder="Name">
						</div>
						<?php include "pages/products/inc/image_crop.php"; ?>
						<div class="col-auto">
							<div>#<?php echo $product["id"] ?></div>
						</div>
						<?php if($product["id"] == 1) { ?>
						<div class="col-12 ftsz-1 text-danger px-4">
							Damit die Handschuhe an der richtigen Stelle auf dem PDF-Formular dargestellt werden, sollen sie die ID 1 haben.
						</div>
						<?php } ?>
					</div>
					<div class="row d-flex align-items-center">
						<div class="col mb-3">
							<input 
								   type="text"
								   class="form-control product-short-name"
								   id="product-short-name-<?php echo $product["id"] ?>"
								   value="<?php echo $product["short_name"] ?>"
								   placeholder="Short Name">
						</div>
						<div class="col mb-3">
							<input type="text" class="form-control pack-quantity" value="<?php echo $product["pack_quantity"] ?>" placeholder="Packungsmenge">
						</div>
						<div class="col mb-3">
							<input 
								   type="number" 
								   class="form-control product-price" 
								   id="product-price-<?php echo $product["id"] ?>" 
								   value="<?php echo $product["price"] ?>"
								   placeholder="Gesamtpreis">
						</div>
					</div>
					<div class="col-12 mb-3">
						<input type="text" class="form-control positionsnumber" placeholder="Positionsnummer" value="<?php echo $product["positionsnumber"] ?>">
					</div>
					<div class="row d-flex align-items-center">
						<?php if($product["active"] == 0) { ?>
						<div class="col">
							<button class="custom-btn <?php echo BTN_OUTLINE_PRIMARY ?> product-activate w-100" data-product-id="<?php echo $product["id"] ?>">
								Produkt aktivieren
							</button>
						</div>
						<?php } else { ?>
						<div class="col-12 mb-3">
							<textarea 
									  rows="3" 
									  class="form-control product-description" 
									  name="description" 
									  placeholder="Beschreibung"><?php echo $product["description"] ?></textarea>
						</div>
						<div class="col">
							<button class="custom-btn <?php echo BTN_OUTLINE_PRIMARY ?> update-product w-100" data-product-id="<?php echo $product["id"] ?>">
								Produkt aktualisieren
							</button>
						</div>
						<div class="col">
							<button title="Deaktivieren" class="custom-btn <?php echo BTN_OUTLINE_DANGER ?> product-deactivate w-100" data-product-id="<?php echo $product["id"] ?>">
								Produkt deaktivieren
							</button>
						</div>
						<?php } ?>
					</div>
				</div>
				<script>
				$(document).ready(function() {
					var product_id = '<?php echo $product["id"] ?>';
					var $modal = $('#modal-' + product_id);
					var image = document.getElementById('uploaded_image_' + product_id);
					var cropper;
					
					$('#upload_image_' + product_id).change(function(event){
						var files = event.target.files;
						

						var done = function(url){
							image.src = url;
							$modal.modal('show');
						};

						if(files && files.length > 0)
						{
							reader = new FileReader();
							reader.onload = function(event)
							{
								done(reader.result);
							};
							reader.readAsDataURL(files[0]);
						}
					});
					
					$modal.on('shown.bs.modal', function() {
						cropper = new Cropper(image, {
							aspectRatio: 1,
							viewMode: 0,
							preview:'.preview'
						});
					}).on('hidden.bs.modal', function(){
						cropper.destroy();
						cropper = null;
					});
					
					$('#crop_' + product_id).click(function(){
						canvas = cropper.getCroppedCanvas({
							width:400,
							height:400
						});

						canvas.toBlob(function(blob){
							url = URL.createObjectURL(blob);
							var reader = new FileReader();
							reader.readAsDataURL(blob);
							reader.onloadend = function(){
								var base64data = reader.result;
								$.ajax({
									url: 'pages/products/inc/upload_img.php',
									method:'POST',
									data: {
										image: base64data, 
										id: product_id
									},
									success: function(data){
										$modal.modal('hide');
										// Füge einen Zeitstempel hinzu, um den Browser-Cache zu umgehen
										$('#thumbnail_uploaded_image_' + product_id).attr('src', data + '?' + new Date().getTime());
									},
									error: function(err) {
										console.error('Upload failed', err);
									}
								});
							};
						});
					});
					
				});
				</script>
			<?php } ?>
		</div>
	<?php }	?>
</div>