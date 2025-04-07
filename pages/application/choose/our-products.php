<div class="bg-light-grey rounded-4 px-md-4 px-3 pt-md-4 pt-2 pb-md-3 pb-1">
	<div class="h5 mb-md-3 mb-1">Unsere Produkte</div>
	<?php
	$products = getProducts($mysqli,1);
	foreach($products AS $product) { ?>
		<div id="<?php echo $product["id"] ?>" 
			 class="row product bg-white mb-md-2 mb-2 shadow-sm border rounded"
			 data-name="<?php echo ucfirst($product["name"]) ?>"
			 data-pack_quantity="<?php echo $product["pack_quantity"] ?>">
			<div class="col-auto py-2 d-md-block d-none product-image">
				<?php 
					$image_extension = CheckImageExtension("img/products/large/".$product["id"]);
					 if ($image_extension) { ?>
						<?php switch($image_extension) {
							case("png"):?>
								<img class="img-fluid" src="<?php echo BASEHREF ?>img/products/<?php echo $product["id"] ?>.png?<?php echo time(); ?>">
						<?php break;
							case("jpg"):?>
								<img class="img-fluid" src="<?php echo BASEHREF ?>img/products/<?php echo $product["id"] ?>.jpg?<?php echo time(); ?>">
						<?php break;
							case("jpeg"):?>
								<img class="img-fluid" src="<?php echo BASEHREF ?>img/products/<?php echo $product["id"] ?>.jpeg?<?php echo time(); ?>">
						<?php break;
						} 
					}?>
			</div>
			<div class="col py-2 px-2">
				<div class="row gx-0">
					<div class="col-12 h-100 product-name">
						<span class="me-1"><?php echo ucfirst($product["name"]) ?></span>
					</div>
					<div class="col-12 h-100 product-pack-quantity ">
						<span class="me-2"><?php echo $product["pack_quantity"] ?></span>
						<!--<span class="product-price text-muted">
							Preis: <?php echo $product["price"] ?>
						</span>-->
					</div>
					<?php if($product["id"] == 1) { ?>
					<div class="product-size bg-light rounded px-md-3 px-1 py-md-2 py-0 mt-md-2 mt-0 mb-2 border border-warning" style="display:none">
						<div class="">Größe auswählen:</div>
						<div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="product-size" value="s">
								<label class="form-check-label">S</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="product-size" value="m">
								<label class="form-check-label">M</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="product-size" value="l">
								<label class="form-check-label">L</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="product-size" value="xl">
								<label class="form-check-label">XL</label>
							</div>
							<div id="message-product-size" class="text-danger line-height-14"></div>
						</div>
					</div>
					<div class="product-intolerance bg-light rounded px-md-3 px-1 py-md-2 py-0 border border-warning" style="display:none">
						<div class="mb-1">Allergie oder Unverträglichkeit?</div>
						<div>
							<div class="form-check form-check-inline me-md-3 me-2">
								<input class="form-check-input" type="checkbox" name="product_intolerance" value="n">
								<label class="form-check-label">Nitril</label>
							</div>
							<div class="form-check form-check-inline me-md-3 me-2">
								<input class="form-check-input" type="checkbox" name="product_intolerance" value="l">
								<label class="form-check-label">Latex</label>
							</div>
							<div class="form-check form-check-inline me-md-3 me-2">
								<input class="form-check-input" type="checkbox" name="product_intolerance" value="v">
								<label class="form-check-label">Vinyl</label>
							</div>
						</div>
						<div id="warning-message" class="text-danger line-height-14"></div>
					</div>
					
					<script>
					$(document).ready(function() {
					  $("body").on("change", "input[name='product_intolerance']", function() {
						const checkedCount = $("input[name='product_intolerance']:checked").length;

						if (checkedCount > 2) {
						  $(this).prop("checked", false);
						  $("#your-box-products #warning-message").text("Falls Sie allergisch gegen alle drei Materialien sind, ist es uns leider nicht möglich, Ihnen Einmalhandschuhe zur Verfügung zu stellen.");
						} else {
						  $("#your-box-products #warning-message").text("");
						}
					  });
					});
					</script>
					<?php } ?>
				</div>
			</div>
			<div class="col-auto ps-0 pe-2">
				<div class="d-flex align-items-center h-100">
					<div class="row g-0 qty-section rounded px-md-2 px-0">
						<div class="col-auto product-qty d-flex align-items-center text-muted pe-1"></div>
						<div class="col-auto qty-button compilation-summary-element-to-hide">
							<div class="circle bg-main-green-impulsebox shadow-sm" title="Zur meiner Box hinzufügen">
								<div class="plus"></div>
								<div class="vertical"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php }	?>
</div>