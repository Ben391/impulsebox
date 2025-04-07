<div class="col-md-6 mb-4">
<?php if($all_admins = getAdmins($mysqli)) { ?>
	<table class="table">
	<?php foreach($all_admins AS $all_admin) { ?>
		<tr class="<?php if($all_admin["id"] == $admin["id"]) echo 'text-primary'; ?> <?php if($all_admin['active'] == 0){?> opacity-50 <?php } ?>">
			<td><?php echo $all_admin["id"] ?></td>
			<td><?php echo $all_admin["first_name"] ?></td>
			<td><?php echo $all_admin["last_name"] ?></td>
			<td><?php echo $all_admin["email"] ?></td>
			<?php if($_SESSION['admin_role'] == 1) { ?>
				<td>
				<?php if($all_admin['active'] == 0) {?>
					<button title="Aktivieren" class="btn btn-success admin-activate" data-admin-id="<?php echo $all_admin["id"] ?>">+</button>
				<?php } else { ?>
					<button title="Deaktivieren" class="btn btn-outline-danger admin-deactivate" data-admin-id="<?php echo $all_admin["id"] ?>">-</button>
				<?php } ?>
				</td>
			<?php } ?>
		</tr>
	<?php } ?>
	</table>
<?php } ?>
</div>