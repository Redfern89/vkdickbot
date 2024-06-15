<?php require_once '../bootstrap.php'; ?>
<h3>Настройки администрирования</h3>
<form method="POST" action="/setup/act.php">
	<input type="hidden" name="act" value="admin_setup" />
	
	<div class="mb-3">
		<label class="form-label mb-0">ID администратора</label>
		<div class="small mb-2 ms-1 text-muted">Администратор на данный момент может быть только один.</div>
		<input type="text" name="admin_id" class="form-control" value="<?php echo __('@admin_id@'); ?>" />
		<?php
			if (isset($_SESSION['admin_link'])) {
				echo $_SESSION['admin_link'];
			}
		?>
	</div>
	<button type="submit" class="btn btn-danger">Сохранить</button>
	<?php if (isset($_SESSION['admin_link'])) { ?>
	<a href="/setup?step=done" class="btn btn-danger">Готово</a>
	<?php } ?>
</form>