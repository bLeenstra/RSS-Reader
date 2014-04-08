<?php
	include_once 'include/db_connect.php';
	include_once 'include/function.php';
	secure_session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>RSS Reader</title>
	<link rel="stylesheet" href="css/main.css" />
</head>
<body>
<?php if(login_check($mysqli) == true) : ?>
<?php echo htmlentities($_SESSION['username']); //gets username ?>
<?php else : ?>
<?php endif; ?>
</body>
</html>