<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	
	<title>Установка бота</title>
</head>
<body>
	<div class="bg-dark text-white p-2 fw-bold text-center">Мастер установки и настройки</div>
	<?php
		$step = @$_GET['step'];
		$step = (!empty($step)) ? $step : 'mysql';
	?>
	<div class="container">
		<div class="bg-light rounded shadow-sm p-2 mt-3">
		<?php if ($step == 'mysql') { ?>
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
		<?php } ?>
		
		<?php if ($step == 'vkapi') { ?>
			
		<?php } ?>
		
		</div>
	</div>
</body>
</html>