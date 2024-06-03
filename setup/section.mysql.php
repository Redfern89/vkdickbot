<h3>Настройки базы данных mysql</h3>
<hr />

<?php if (isset($_SESSION['sql_errno'])) { ?>
<div class="alert alert-danger">
	<?php echo sprintf('<b>Ошибка #%d:</b> %s', $_SESSION['sql_errno'], $_SESSION['sql_error']); ?>
</div>
<?php 
	unset($_SESSION['sql_errno']);
	unset($_SESSION['sql_error']);
	} 
?>
<form method="POST" action="/setup/act.php">
	<input type="hidden" name="act" value="mysql_setup" />
	
	<div class="mb-3">
		<label class="form-label">Имя пользователя MySQL</label>
		<input type="text" name="mysql_user" class="form-control" />
	</div>
	<div class="mb-3">
		<label class="form-label">Имя базы данных MySQL</label>
		<input type="text" name="mysql_db" class="form-control" />
	</div>
	<div class="mb-3">
		<label class="form-label">Пароль пользователя MySQL</label>
		<input type="password" name="mysql_pass" class="form-control" />
	</div>
	<div class="mb-3">
		<label class="form-label">Хост сервера MySQL</label>
		<input type="text" name="mysql_host" value="localhost" class="form-control" />
	</div>
	<hr />
	<button type="submit" class="btn btn-danger">Далее</button>
</form>