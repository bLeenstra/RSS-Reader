<?php
	incude_once 'db_connect.php';
	incude_once 'psl-config.php';
	
	$error_msg = "";
	
	if(isset($_POST['ruser'], $_POST['rpass'])) {
		$username = filter_input(INPUT_POST, 'ruser', FILTER_SANITIZE_STRING);
		$password = filter_input(INPUT_POST, 'rpass', FILTER_SANITIZE_STRING);
		
		if(strlen($password) != 128) {
			$error_msg .= '<p class="error">Invalid password</p>';
		}
		$prep_stmt = "
			SELECT userID
			FROM tbl_user
			WHERE username = ?
			LIMIT 1";
		$stmt = $mysqli->prepare($prep_stmt);
		
		if($stmt) {
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$stmt->store_result();
			
			if($stmt->num_rows == 1) {
				$error_msg .= '<p class="error">This username already exists</p>';
			}
		} else {
			$error_msg .= '<p class="error">Database error</p>';
		}
		
		if(empty($error_msg)) {
			$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
			$password = hash('sha512', $password . $random_salt);
			
			if($insert_stmt = $mysqli->prepare("
				INSERT INTO tbl_user(
					username,
					password,
					salt
				) VALUES (
					?,
					?,
					?
				)")) {
				$insert_stmt->bind_param('sss', $username, $password, $random_salt);
				
				if(! $insert_stmt->execute()) {
					header('Location: ../error.php?err=Registration failure: INSERT');
				}
			}
			header('Location: ./register_success');
		}
	}