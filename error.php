<?php
	$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);
	
	if(! $error) {
		$error = 'Something unusual happened';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>RSS Reader</title>
	<link rel="stylesheet" href="css/main.css" />
</head>
<body>
	<h1>An error occured</h1>
	<p class="error"><?php echo $error; ?></p>
</body>
</html>