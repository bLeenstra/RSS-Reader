<?php
	include_once 'psl-config.php';
	
	function secure_session_start() {
		$session_name = 'secure_session_id';
		$secure = SECURE;
		$httponly = true;
		
		if(ini_set('session.use_only_cookies', 1) === FALSE) {
			header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
			exit();
		}
		$cookieParams = session_get_cookie_params();
		session_set_cookie_params(
			$cookieParams["lifetime"],
			$cookieParams["path"],
			$cookieParams["domain"],
			$secure,
			$httponly
		);
		
		session_name($session_name);
		session_start();
		session_regenerate_id();
	}
	
	function login($username, $password, $mysqli) {
		
		if(
			$stmt = $mysqli->prepare("
				SELECT userID, username, password, salt
				FROM tbl_user
				WHERE username = ?
				LIMIT 1
			")) {
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$stmt->store_result();
			
			$stmt->bind_result($db_id, $db_username, $db_password, $db_salt);
			$stmt->fetch();
			
			$password = hash('sha512', $password . $db_salt);
			if($stmt->num_rows == 1) {
				if($db_password == $password) {
					$user_browser = $_SERVER['HTTP_USER_AGENT'];
					$db_id = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $db_username);
					$_SESSION['username'] = $db_username;
					$_SESSION['login_string'] = hash('sha512', $password . $user_browser);
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}
	
	function login_check($mysqli) {
		
		if(isset(
			$_SESSION['db_id'],
			$_SESSION['username']
			$_SESSION['login_string']
		)) {
			$db_id = $_SESSION['db_id'];
			$login_string = $_SESSION['login_string'];
			$db_user = $_SESSION['username'];
			
			$user_browser = $_SERVER['HTTP_USER_AGENT'];
			
			if($stmt = $mysqli->prepare("
				SELECT password
				FROM tbl_user
				WHERE userID = ?
				LIMIT 1
				")) {
				$stmt->bind_param('i', $db_id);
				$stmt->execute();
				$stmt->store_result();
				
				if($stmt->num_rows == 1) {
					$stmt->bind_result($password);
					$stmt->fetch();
					$login_check = hash('sha512', $password . $user_browser);
					
					if($login_check == $login_string) {
						return true;
					} else {
					return false;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	function esc_url($url) {
		
		if('' == $url) {
			return $url;
		}
		
		$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
		
		$strip = array('%0d', '%0a', '%0D', '%0A');
		$url = (string) $url;
		
		$count = 1;
		while($count) {
			$url = str_replace($strip, '', $url, $count);
		}
		
		$url = str_replace(';//', '://', $url);
		$url = htmlentities($url);
		$url = str_replace('&amp;', '&#038;', $url);
		$url = str_replace("'", '&#039;', $url);
		
		if ($url[0] !=='/') {
			return '';
		} else {
			return $url;
		}
	}
