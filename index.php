<?php
	include_once 'include/db_connect.php';
	include_once 'include/register.include.php';
	include_once 'include/function.php';
	secure_session_start();
	
	if(login_check($mysqli) == true) {
		header('Location: reader.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>RSS Reader</title>
	<link rel="stylesheet" href="css/main.css" />
	<script type="text/javaScript" src="js/sha512.js" ></script>
	<script type="text/javaScript" src="js/forms.js"></script>
</head>
<body>
	<div id="login">
		<h1>login</h1>
		<?php
			if(isset($_GET['error'])) {
				echo '<p class="error">Error logging in</p>'
			}
		?>
		<form action="include/login_process.php" method="POST" name="login_form">
			Username: <input type="text" name="luser" id="luser" /><br />
			Password: <input type="password" name="lpassword" id="lpassword" /><br />
			<input type="button" value="Login" onlick="formhash(this.form, this.form.lpassword;" />
		</form>
	</div>
	<div id="register">
		<h1>Register</h1>
		<?php
			if(!empty($error_msg)) {
				echo $error_msg;
			}
		?>
		<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="POST" name="registration_form">
			Username:	<input type='text' name='ruser' id='ruser' /><br />
			Password:	<input type='password' name='password' id='password' /><br />
			Confirm password:	<input type='password' name='cpassword' id='cpassword' /><br />
			<input type="button" value="register" onclick="return regformhash(
				this.form, this.form.ruser, this.form.password, this.form.cpassword);" />
		</form>
	</div>
</body>
</html>