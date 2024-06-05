<?php
	define ('DOCROOT', realpath(__DIR__));
	require_once DOCROOT . '/bootstrap.php';


	$event = json_decode(file_get_contents('php://input'), true);
	$secret = isset($event['secret']) ? $event['secret'] : '';
	
	if (isset($event['type'])) {

		if ($event['type'] == CALLBACK_API_EVENT_CONFIRMATION) {
			echo CALLBACK_API_CONFIRMATION_TOKEN;
		}

		if ($event['type'] == CALLBACK_API_EVENT_MESSAGE_NEW && $secret == __('@vkapi_secret_key@')) {
			echo CALLBACK_API_RETURN_OK;

			if (isset($event['object']['message'])) {
				$message_obj = $event['object']['message'];
				if (__('@cron_work@') == 'false') {
					message_process($message_obj);
				} else {
					//_vkApi_messages_Send($message_obj['peer_id'], 'Сервер занят, повтори запрос через минутку');
				}
			}
		}
	}
	
	$sql -> close();
?>