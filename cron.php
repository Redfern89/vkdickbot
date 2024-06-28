<?php
	if (php_sapi_name() !== 'cli') die("Ты избрал не тот путь");
	if (!checkInternetConnection()) die('No internet');

	define ('DOCROOT', realpath(__DIR__));
	require_once DOCROOT . '/bootstrap.php';

	updateGlobal('cron_work', 'true');
	CRON_updateDicks();
	CRON_reloadPeers();
	updateGlobal('cron_work', 'false');

	$sql -> close();
?>