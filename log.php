<?php
	function __log($eventName, $event, $type=0) {
		$file = fopen(LOG_FILE, 'a');
		
		$log_types = array(
			0 => 'INFO',
			1 => 'WARN',
			2 => 'ERROR',
			3 => 'LONG_TEXT'
		);
		$dateTime = date('Y-m-d H:i:s');
		$log = sprintf("[ %s, %s ] [ %s ] :: %s\n", $log_types[$type], $dateTime, $eventName, $event);
		
		fwrite($file, $log);
		fclose($file);
	}
?>