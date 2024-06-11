<?php
	$current_cfg = 0;
	define ('CURRENT_CFG', $current_cfg);

	$cfg_array[0] = array(
		'SQL_USER' => 'vkbot',
		'SQL_HOST' => 'localhost',
		'SQL_PASS' => '',
		'SQL_DB' => 'vkbot',
	);

	define ('WL_DB', $cfg_array[CURRENT_CFG]['SQL_DB']);

	define ('CALLBACK_API_EVENT_CONFIRMATION', 'confirmation'); 
	define ('CALLBACK_API_EVENT_MESSAGE_NEW', 'message_new'); 
	define ('CALLBACK_API_RETURN_OK', 'ok');

	define ('LOG_FILE', DOCROOT . '/logs/log.txt');
?>
