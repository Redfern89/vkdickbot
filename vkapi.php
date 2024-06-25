<?php

	// Функция для работы с VK API
	function _vkApi_Call($method, $params = [], $cron=FALSE) {
		$params['v'] = __('@vkapi_version@');
		
		if (!$cron) $params['access_token'] = __('@vkapi_access_token@');
		else $params['access_token'] = __('@vkapi_cron_acces_token@');
		
		
		$url = sprintf('https://api.vk.com/method/%s', $method); // URL для отсылки данных на сервер ВК
		$data = __http_request($url, $params);
		
		WL_DB_Insert('api_log', array(
			'method' => $method,
			'request_data' => http_build_query($params),
			'response_data' => $data,
			'date' => time()
		));
		
		$data = json_decode($data, TRUE);
		
		if (isset($data['response'])) {
			return $data['response'];
		} else {
			return $data;
		}
	}
	
	function _vkApi_photos_getMessagesUploadServer($peer_id) {
		return _vkApi_Call('photos.getMessagesUploadServer', array(
			'peer_id' => $peer_id
		));
	}

	function _vkApi_photos_saveMessagesPhoto($photo, $server, $hash) {
		return _vkApi_Call('photos.saveMessagesPhoto', array(
			'photo' => $photo,
			'server' => $server,
			'hash' => $hash
		));
	}

	function _vkApi_CreatePhotoAttachment($peer_id, $filename, $mime) {
		$srv = _vkApi_photos_getMessagesUploadServer($peer_id);
		$attachment = '';
		if (isset($srv['upload_url'])) {
			$fields = [
				'photo' => new \CurlFile($filename, $mime)
			];
			$data = __http_request($srv['upload_url'], $fields);
			$data = json_decode($data, TRUE);
			if (isset($data['photo']) && isset($data['server']) && isset($data['hash'])) {
				$photo = _vkApi_photos_saveMessagesPhoto($data['photo'], $data['server'], $data['hash']);
			} else {
				$photo = null;
				return FALSE;
			}
			if (isset($photo[0])) {
				$attachment = sprintf('photo%d_%d', $photo[0]['owner_id'], $photo[0]['id']);
			}
		}

		return $attachment;
	}

	// Функция отправки сообщения
	function _vkApi_messages_Send($peer_id, $text='', $attachment='', $reply_to='', $disable_mentions=false, $keyboard='', $payload='') {
		$params = array(
			'peer_ids' => $peer_id,
			'random_id' => random_uint32_t(),
			'message' => $text
		);
		if ($disable_mentions) $params['disable_mentions'] = '1';
		if (!empty($attachment)) $params['attachment'] = $attachment;
		if (!empty($keyboard)) $params['keyboard'] = $keyboard;
		if (!empty($payload)) $params['keyboard'] = $payload;

		return _vkApi_Call('messages.send', $params);
	}
	
	function _vkApi_messages_Pin($peer_id, $message_id=NULL, $conversation_message_id=NULL) {
		return _vkApi_Call('messages.pin', array(
			'peer_id' => $peer_id,
			'conversation_message_id' => $message_id
		));
	}
	
	function _vkApi_usersGet($user_ids, $fields='') {
		return _vkApi_Call('users.get', array(
			'user_ids' => $user_ids,
			'fields' => $fields
		));
	}

	function _vkApi_messages_isMessagesFromGroupAllowed($group_id, $user_id) {
		$result = _vkApi_Call('messages.isMessagesFromGroupAllowed', array('group_id' => $group_id, 'user_id' => $user_id));
		if (isset($result['is_allowed'])) return $result['is_allowed'];
		
		return FALSE;
	}
?>