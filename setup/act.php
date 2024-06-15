<?php
	session_start();
	$act = @$_REQUEST['act'];
	
	function __redirect($location) {
		header('HTTP/1.1 302 Found');
		header('Location: ' . $location);
	}
	
	if ($act == 'mysql_setup') {
		$mysql_user = @$_POST['mysql_user'];
		$mysql_db = @$_POST['mysql_db'];
		$mysql_pass = @$_POST['mysql_pass'];
		$mysql_host = @$_POST['mysql_host'];
		
		try {
			$sql = @ new mysqli($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
			$sql_query = file_get_contents('vkbot.sql');
			$result = mysqli_multi_query($sql, $sql_query);
			$sql -> close();
			
			define ('DOCROOT', $_SERVER['DOCUMENT_ROOT']);
			
			require_once '../botapi.php';
			$configFile = load_tpl('config_php', array(
				'SQL_USER' => $mysql_user,
				'SQL_PASS' => $mysql_pass,
				'SQL_HOST' => $mysql_host,
				'SQL_DB' => $mysql_db,
			));
			
			echo $configFile;
			file_put_contents('../config.php', $configFile);
			
			__redirect('/setup?step=dir');
			
		} catch (Exception $e) {
			$_SESSION['sql_errno'] = $e -> getCode();;
			$_SESSION['sql_error'] = $e -> getMessage();
			__redirect('/setup?step=mysql&fail');
		}
	}
	
	
	if ($act == 'dir_setup') {
		$docroot = @$_POST['docroot'];
		try {
			$errors = array();
			if (is_writable($docroot)) {				
				$dirs = ['/logs', '/members/50', '/members/100', '/members/200', '/stats_graphs'];
				foreach ($dirs as $dir) {
					$directory = $docroot . $dir;
					if (!file_exists($directory)) {
						if (!mkdir($directory, 0777, true)) {
							$errors[] = 'Не возможно создать директорию ' . $directory;
						}
					} else {
						$errors[] = 'Директория <b>' . $directory . '</b> уже существует';
					}
				}
				if (!empty($errors)) {
					$_SESSION['dir_error'] = implode('<br />', $errors);
					__redirect('/setup?step=dir&fail');
				} else {
					__redirect('/setup?step=vkapi');
				}
				
			} else {
				$_SESSION['dir_error'] = 'Не возможно создать директории';
				__redirect('/setup?step=dir&fail');
			}
		} catch (Exception $e) {
			$_SESSION['dir_errno'] = $e -> getCode();;
			$_SESSION['dir_error'] = $e -> getMessage();
			__redirect('/setup?step=dir&fail');			
		}
	}
	
	
	if ($act == 'confirmation_token_setup') {
		define ('DOCROOT', $_SERVER['DOCUMENT_ROOT']);
		require_once '../bootstrap.php';
		
		updateGlobal('vkapi_confirmation_token', @$_POST['vkapi_confirmation_token']);
		__redirect('/setup?step=vkapi');
		
		$sql -> close();
	}
	
	if ($act == 'vkapi_keys_setup') {
		define ('DOCROOT', $_SERVER['DOCUMENT_ROOT']);
		require_once '../bootstrap.php';
		
		$vkapi_access_token = @$_POST['vkapi_access_token'];
		$vkapi_secret_key = @$_POST['vkapi_secret_key'];
		
		updateGlobal('vkapi_access_token', $vkapi_access_token);
		updateGlobal('vkapi_secret_key', $vkapi_secret_key);
		
		__redirect('/setup?step=vkapi');
		
		$_SESSION['vkapi_keys_ok'] = true;
		
		$sql -> close();
	}
	
	if ($act == 'admin_setup') {
		define ('DOCROOT', $_SERVER['DOCUMENT_ROOT']);
		require_once '../bootstrap.php';
		$admin_id = @$_POST['admin_id'];
		$admin = _vkApi_usersGet($admin_id, fields: 'screen_name');
		$adminData = $admin[0];
		
		$admin_Link = sprintf('<a href="https://vk.com/%s" target="_blank">%s %s</a>', $adminData['screen_name'], $adminData['first_name'], $adminData['last_name']);
		$_SESSION['admin_link'] = $admin_Link;
		updateGlobal('admin_id', $admin_id);
		$sql -> close();
		__redirect('/setup?step=admin_settings');
	}
?>