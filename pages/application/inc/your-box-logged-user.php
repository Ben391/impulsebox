<?php if(isset($product_full_data)) { ?>
<div id="box" class="row bg-main-gradient rounded-4 shadow-sm px-md-4 px-2 pt-md-4 pt-2 pb-md-3 pb-2">
	<div class="col collapsed" data-bs-toggle="collapse" data-bs-target="#your-box-products" aria-expanded="false" aria-controls="your-box-products">
		<div class="row mb-md-2 mb-0">
			<div class="col px-2">
				<h5 class="mb-0 text-white">Ihre Zusammenstellung</h5>
				<?php if(!empty($compilation_name)) { ?>
				<div class="ftsz-1 text-white opacity-75" style="margin-top: -7px"><?php echo $compilation_name ?></div>
				<?php } ?>
			</div>
			<div class="col-auto px-0 ftsz-0875 text-white opacity-75 d-flex align-items-center d-md-none d-block">
				<span class="expand-text">ausklappen</span>
			</div>
			<div class="col-auto d-md-none d-block d-flex align-items-center">
				<i class="fa-solid fa-chevron-down text-white"></i>
			</div>
		</div>
	</div>
	<div id="your-box-products" class="col-12 mt-1 mb-2 collapse show">
		<?php foreach ($product_full_data AS $product) { ?>
		<div class="row bg-white mb-2 shadow-sm border rounded selected-product">
			<div class="col-auto d-md-block d-none py-2 product-image">
				<img src="<?php echo BASEHREF ?>img/products/<?php echo $product["id"] ?>.png" border="0">
			</div>
			<div class="col py-2">
				<div class="row g-0">
					<div class="col-12 product-name">
						<span class="me-2"><?php echo $product['name'] ?></span>
					</div>					
					<div class="col-12 product-pack-quantity">
						<div class="row">
							<div class="col-auto pe-1">
								<?php echo $product['pack_quantity'] ?>
							</div>
							<?php if(isset($product['size']) AND !empty($product['size'])) { ?>
							<div class="col-auto pe-1">
								<span>Größe:</span> <span class="font-weight-400"><?php echo strtoupper($product['size']) ?></span>
							</div>
							<?php } ?>
							<?php if(isset($product['intolerance']) AND !empty($product['intolerance'])) { ?>
							<div class="col-auto pe-1">
								<span class="text-decoration-line-through"><?php echo handleMaterial($product['intolerance']); ?></span>
							</div>
							<?php } ?>
							<!--<span class="product-price text-muted ms-3"><?php echo $product['price'] ?> € *</span>-->
						</div>						
					</div>
				</div>
			</div>
			<div class="col-auto py-2">
				<div class="d-flex align-items-center h-100">
					<div class="row g-0 qty-section rounded px-2">
						<div class="col-auto text-main-blue-impulsebox product-qty d-flex align-items-center justify-content-center fs-15 fw-bold">
							<span class="qty"><?php echo $product['quantity'] ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="row text-white font-weight-400 mb-1 cost">
			<div class="col px-2">
				<span class=" me-2">Kosten:</span> 
				<span class="text-nowrap">
					<?php if($insurance_type == 2) { ?>
					40,00 € *
					<?php } else { ?>
					0,00 €
					<?php } ?>
				</span>
			</div>
			<?php if(!empty($delivery_frequency_name)) { ?>
			<div class="col-auto d-flex align-items-start text-end">
				Lieferung <?php echo $delivery_frequency_name ?>
			</div>
			<?php } ?>
		</div>	
		<?php if($insurance_type == 2 AND empty($entry_status)) { ?>
		<div class="row pb-2 border-bottom border-white mb-md-4 mb-2">
			<div class="col cost-description text-white px-2">
				Sie erhalten eine auf den Versicherten ausgestellte Rechnung in Höhe des erstattungsfähigen Betrags von maximal 40€ * und gehen in Vorleistung. Anschließend beantragen Sie die Erstattung der Kosten der <?php echo $company["servicename"] ?> bei Ihrer Pflegekasse selbst. Die Rechnung ist grundsätzlich voll erstattungsfähig, wenn ein Pflegegrad vorliegt.
			</div>
		</div>
		<?php } ?>
		<?php if($bed_protectors_amount > 0) { ?>
		<div class="row bg-white py-2 mt-md-4 mt-1 mb-2 shadow-sm border rounded selected-product">
			<div class="col-auto d-md-block d-none">
				<img src="<?php echo BASEHREF ?>img/products/produkt-wiederverwbettschutzeinl.png" border="0" alt="" style="max-height:50px">
			</div>
			<div class="col">
				<div class="row g-0">
					<div class="col-12 product-name">
						<span class="me-2">Wiederverwendbare Bettschutzeinlagen</span>
					</div>
				</div>
			</div>
			<div class="col-auto">
				<div class="d-flex align-items-center h-100">
					<div class="row g-0 qty-section rounded px-2">
						<div class="col-auto text-main-blue-impulsebox product-qty d-flex align-items-center justify-content-center fs-15 fw-bold">
							<span class="qty"><?php echo $bed_protectors_amount ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row text-white font-weight-400 mb-1 cost">
			<div class="col d-flex align-items-end px-2">
				<span class="me-2">Kosten:</span>
				<span>
					<?php if($insurance_type == 2) {
						$bed_protectors_total_amount = $bed_protectors_amount * 26;
						$bed_protectors_total_amount = round($bed_protectors_total_amount, 2); // Rundet auf zwei Nachkommastellen
						$bed_protectors_total_amount = number_format($bed_protectors_total_amount, 2, ',', ''); // Setzt ein Komma als Dezimaltrennzeichen
						echo $bed_protectors_total_amount." € *";
					} else {
						echo "0,00 €";
					} ?>
				</span>
			</div>
			<div class="col-auto d-flex align-items-end text-end">
				Lieferung jährlich
			</div>
		</div>
		<?php if($insurance_type == 2 AND empty($entry_status)) { ?>
		<div class="row mb-md-4 mb-2">
			<div class="col cost-description text-white px-2">
				Sie erhalten eine separate auf den Versicherten ausgestellte Rechnung und gehen in Vorleistung. Anschließend beantragen Sie die Erstattung der Kosten bei Ihrer Pflegekasse selbst. Inwieweit die Rechnung erstattungsfähig ist, erfragen Sie bitte bei Ihrer Pflegekasse.
			</div>
		</div>
		<?php } ?>
		<?php } ?>
		<?php if($insurance_type == 2) { ?>
		<div class="row mb-md-3 mb-2">
			<div class="col text-white">
			* inkl. gesetzl. MwSt.
			</div>
		</div>
		<?php } ?>
		<?php if($current_page != "konto") { ?>
		<a class="custom-btn <?php echo BTN_GRADIENT ?> w-100" href="<?php echo BASEHREF ?>auswahl/">Ihre Auswahl ändern</a>
		<?php } ?>
	</div>
</div>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function(){
		// Funktion nur einmal beim Laden der Seite aufrufen
		if ($(window).width() < 769) {
			$('#your-box-products').removeClass('show');
		}
		$('.col[data-bs-toggle="collapse"]').click(function() {
			$('.fa-chevron-down').toggleClass('fa-rotate-180');
		});
		$('#your-box-products').on('shown.bs.collapse', function () {
			$('.expand-text').text('einklappen');
		});

		$('#your-box-products').on('hidden.bs.collapse', function () {
			$('.expand-text').text('ausklappen');
		});
	});
</script>
