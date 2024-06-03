<?php 
	session_start();
	define ('DOCROOT', $_SERVER['DOCUMENT_ROOT']);
	$step = @$_GET['step'];
	$step = (!empty($step)) ? $step : 'mysql';
	$file = DOCROOT . "/setup/section.$step.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	
	<title>Установка бота</title>
</head>
<body>
	<div class="bg-dark text-white p-2 fw-bold text-center">Мастер установки и настройки</div>
	<div class="container">
		<div class="bg-light rounded shadow-sm p-2 mt-3">
		<?php
			if (file_exists($file)) {
				require_once $file;
			}
		?>
		</div>
	</div>
</body>
</html>