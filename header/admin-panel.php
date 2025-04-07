<style>.fixed-top{top: 64px;}</style>
<div class="container-fluid bg-dark text-white ftsz-1 py-2 sticky-top">
	<div class="row d-flex align-items-center">
		<div class="col-auto opacity-75">Administration</div>
		<div class="col-auto">
			<a class="text-white me-3" href="<?php echo ADMIN_BASEHREF ?>">Dashboard</a>
			<a class="text-white me-3" href="<?php echo ADMIN_BASEHREF ?>entries/">Anträge</a>
		</div>
		<div class="col">
			<?php if(isset($entry_number)) { ?>
			<span class="me-3">
				<span class="opacity-75 me-1">Sie bearbeiten den Antrag </span>
				<strong class="ftsz-1125" style="letter-spacing:.1rem"><?php echo $entry_number ?></strong>
			</span>
			<a class="custom-btn custom-btn-outline-primary-white" href="<?php echo ADMIN_BASEHREF ?>entry/?id=<?php echo $entry_id ?>">Zurück zum Antrag</a>
			<?php } ?>
		</div>
		<div class="col-auto">
			<a class="custom-btn <?php echo BTN_OUTLINE_DANGER ?>" href="<?php echo ADMIN_BASEHREF ?>auth/logout.php">Ausloggen</a>
		</div>
	</div>
</div>