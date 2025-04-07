<?php $rechtliches = getRechtliches($mysqli); ?>
<div class="container py-5 ftsz-1">
	<h1 class="h2 mb-3">Impressum</h1>
	<?php echo html_entity_decode($rechtliches["impressum"]) ?>
</div>


			
