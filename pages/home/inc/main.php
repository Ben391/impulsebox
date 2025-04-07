<div class="container-fluid px-0 main-bg">
	<?php include_once "header/header.php" ?>
	<div class="row g-0 h-100 justify-content-end pt-md-5 pt-0">
		<div class="col-md-6 px-3 h-100 d-flex flex-column text-start mt-md-5 mt-0 justify-content-center ">
			<div class="main-title main-title-first text-white mb-xxl-2 mb-2 px-1">
				Kostenfreie Mittel zur Pflege <small>*</small>
			</div>
			<h1 class="main-title main-title-second text-white px-1 mb-1">
				ImpulseBox
			</h1>
			<div class="main-title main-title-first text-white mb-xxl-5 mb-4 px-1">
				Sie können damit jeden Monat ca. <?php echo $compilation_max_total_price ?> EUR einsparen.<br>Je nach Krankenkasse bzw. Pflegekasse.
			</div>
			<div class="ripple-box">
				<a class="ripple-element custom-btn custom-btn-lg <?php echo BTN_GRADIENT; if(isLoggedInAsAdmin()) { ?> disabled<?php } ?>" href="<?php echo BASEHREF ?>auswahl/" style="max-width: 540px">
					<span>Pflegehilfsmittel beantragen</span>
				</a>
			</div>
		</div>
	</div>
</div>