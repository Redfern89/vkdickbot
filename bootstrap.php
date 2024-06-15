<?php
	$WL = array();
	
	require_once DOCROOT . '/config.php';
	
	$sql = @new mysqli($cfg_array[CURRENT_CFG]['SQL_HOST'], $cfg_array[CURRENT_CFG]['SQL_USER'], $cfg_array[CURRENT_CFG]['SQL_PASS'], $cfg_array[CURRENT_CFG]['SQL_DB']);

	require_once DOCROOT . '/sql.php';
	require_once DOCROOT . '/botapi.php';
	require_once DOCROOT . '/vkapi.php';
	require_once DOCROOT . '/messages.php';
	
	wl();
	
?>