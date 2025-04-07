<?php 
if($compilations = getCompilations(true)) {
	$compilations[] = [
		'id' => 0,
		'active' => 1,
		'name' => 'PflegeVitalBox -Flexibel',
		"products_readable" => array(),
		"products_details" => array(
			0 => [
				'product_info' => null,
				'quantity' => 0,
				'size' => '',
				'intolerance' => '',
				'name' => "wählen Sie Produkte ganz nach Ihren Bedürfnissen"
			]
		),
	];
	//echo "<pre>";print_r($compilations);echo "</pre>";	
?>
<section class="container-fluid border-bottom px-0 py-xxl-5 py-0">
	<div class="container py-5">
		<div class="row">
			<div class="col-md-6">
				<h2 class="px-2 mb-5">Diese Konstellationen<br> der <?php echo $company["servicename"] ?> bieten wir an</h2>
			</div>
		</div>
		<style>
			.test77{
				position: absolute; 
				top:0;
				left:0;
			}
		</style>
		<div class="row">
			<?php foreach($compilations AS $compilation) { ?>
			<div class="col-md-3 mb-4">
				<div class="bg-light-grey rounded-3 h-100 text-center" style="overflow:hidden;">
					<div class="text-center rounded-top-3 bg-main-gradient p-3 mb-3">
						<?php 
						$compilation_image = $_SERVER['DOCUMENT_ROOT'] . "/img/compilations/" . $compilation["id"] . ".png";
						if(file_exists($compilation_image)) { ?>
						<div class="text-center">
							<img class="img-fluid" src="<?php echo BASEHREF ?>img/compilations/<?php echo $compilation["id"] ?>.png" border="0">
						</div>
						<?php } ?>
						<h3 class="h3 mb-3 text-white">
							<span class="d-block " style="line-height: 1.4"><?php echo $compilation["name"] ?></span>
							<span class="d-block opacity-50 ftsz-15">Box</span>
						</h3>
					</div>
					<?php foreach($compilation["products_details"] AS $compilation_product) { ?>
					<div class="mb-3 px-3">
						<div class="h5 mb-0">
							<?php if(!empty($compilation_product["quantity"])) { ?>
							<span class="d-block">
								<?php echo $compilation_product["quantity"] ?> <i class="fa-solid fa-xmark fa-xs opacity-75"></i>
							</span>
							<?php } ?>
							<?php echo $compilation_product["name"] ?>
						</div>
						<?php if(!empty($compilation_product["pack_quantity"])) { ?>
						<div class="h6 text-muted mb-3"><?php echo $compilation_product["pack_quantity"] ?></div>
						<?php } ?>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</section>
<?php } ?>