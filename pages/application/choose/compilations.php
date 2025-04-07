<?php if($compilations = getCompilations(true)) { ?>
<div class="bg-light-grey rounded-4 px-md-4 px-3 pt-md-4 pt-2 pb-0">
	<div class="row justify-content-center">
		<div class="col-12 ">
			<div class="h5 mb-md-4 mb-1">
				<span class="d-md-inline-block d-none">Die beliebtesten </span> Zusammenstellungen
			</div>
		</div>
		<?php 
		$compilations_amount = count($compilations);
		if ($compilations_amount % 2 == 0) {
			$compilation_col_class = "col-6";
		} else {
			$compilation_col_class = "col-4";
		}
		foreach($compilations AS $compilation) { 
			$compilation_image = $_SERVER['DOCUMENT_ROOT'] . "/img/compilations/" . $compilation["id"] . ".png";
			?>
			<div class="<?php echo $compilation_col_class ?> compilation h-100 mb-md-3 mb-2" id="c-<?php echo $compilation["id"] ?>">
				<div class="row gx-3 product bg-white rounded shadow-sm py-2">
					<?php if(file_exists($compilation_image)) { ?>
					<div class="col-auto d-md-block d-none compilation-image me-5">
						<img src="<?php echo BASEHREF ?>img/compilations/<?php echo $compilation["id"] ?>.png" border="0" alt="" style="max-height:130px">
					</div>
					<?php } ?>
					<div class="col text-center px-1 mb-1">
						<div class="h6 mb-0"><?php echo $compilation["name"] ?></div>
					</div>
					<div class="col-md-auto col-12 qty-button d-flex justify-content-center align-items-center">
						<div class="circle bg-main-green-impulsebox shadow-sm" title="Zur meiner Box hinzufügen">
							<div class="plus"></div>
							<div class="vertical"></div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
	</div>
</div>
<?php 
	$compilation_ids = array_map(function($compilation) {
		return $compilation["id"];
	  }, $compilations);
} ?>