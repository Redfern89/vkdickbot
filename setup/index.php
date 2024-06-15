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
	<link href="/setup/bootstrap.min.css" rel="stylesheet" />
	<script src="/setup/bootstrap.bundle.min.js" type="text/javascript"></script>
	
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