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

?>