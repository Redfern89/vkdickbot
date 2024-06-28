<?php
	if (php_sapi_name() !== 'cli') die("Ты избрал не тот путь");
	
	define ('DOCROOT', realpath(__DIR__));
	require_once DOCROOT . '/bootstrap.php';

	if (!checkInternetConnection()) die('No internet');

	$notifyIDs = WL_DB_GetDelimitedList('dicks', 'vkid', where: array(['enable_notify', '=', 'true'], ['notify_send', '=', 'false'], ['metr_available', '<=', time()]));
	_vkApi_messages_Send($notifyIDs, load_tpl('notify'));
	WL_DB_Update('dicks', array('notify_send' => 'true'), array(['vkid', 'IN', $notifyIDs]));

	$sql -> close();
?>