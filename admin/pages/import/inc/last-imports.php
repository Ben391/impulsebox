<div class="col-md-5">
	<h2>Letzte Importe</h2>
	<?php if($imports = getImports($mysqli)) { ?>
	<table class="table table-sm ftsz-1">
	<?php foreach($imports AS $import) { ?>
	<tr class="<?php if(isset($_GET["import_id"]) AND $_GET["import_id"] == $import["import_id"]) echo "table-success"; ?>">
		<td>
			<a href="<?php echo ADMIN_BASEHREF . "entries/?keyword=" . $import["import_id"] ?>"><?php echo $import["import_id"] ?></a>
		</td>
		<td><?php echo $import["import_date_formatted"] ?></td>	
		<td><?php echo $import["first_name"] . " " . $import["last_name"] ?></td>
	</tr>
	<?php } ?>
	</table>
	<?php } ?>
</div>