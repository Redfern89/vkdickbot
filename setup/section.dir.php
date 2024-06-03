<h3>Настройки директорий</h3>
<hr />

<?php if (isset($_SESSION['dir_error'])) { ?>
<div class="alert alert-danger">
	<?php echo $_SESSION['dir_error']; ?>
</div>
<?php 
	unset($_SESSION['dir_error']);
	} 
?>

<form method="POST" action="/setup/act.php">
	<input type="hidden" name="act" value="dir_setup" />
	
	<div class="mb-3">
		<label class="form-label">Директория установки</label>
		<input type="text" name="docroot" class="form-control" value="<?php echo DOCROOT; ?>" />
	</div>
	<div class="mb-3">
		<b>Проверка прав на директорию: </b>
		<font color="red">
			<?php echo substr(sprintf('%o', fileperms(DOCROOT)), -4); ?>
		</font>
	</div>
	<hr />
	<a href="/setup?step=mysql" class="btn btn-success">Назад</a>
	<button type="submit" class="btn btn-danger">Далее</button>
</form>