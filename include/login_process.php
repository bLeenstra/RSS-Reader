<?php
	include_once 'db_connect.php';
	include_once 'function.php';
	secure_session_start();
	
	if(isset($_POST['luser'], $_POST['lpass'])){
		$username = $_POST['luser'];
		$password = $_POST['lpass'];
		
		if(login($username, $password, $mysqli) == true){
			header('Location: ../reader.php');
		} else {
			header('Location: ../index.php?error=1');
		}
	} else {
		echo 'Bad Request';
	}