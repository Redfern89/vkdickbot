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
			
			__redirect('/setup?step=vkapi');
			
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
?>