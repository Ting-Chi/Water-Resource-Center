
<!DOCTYPE html>

<html>
<head>	
	<title>logout</title>
	<meta charset="utf-8">
</head>

<body>
	<?php
			session_start();
			session_unset();
			session_destroy();
			header("refresh: 0; url = index.php");
		?>
</body>
</html>