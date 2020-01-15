<!DOCTYPE html>

<html>
<head>
  
  <title>topic_new</title>
  <meta charset = "UTF-8">
</head>

<body>


	<?php


			$topic_no = $_GET["topic_no"];
				
			require_once("mysql.php");
				
			$sql = "delete from topic where topic_no = $topic_no";
				
			mysql_query($sql) or die(mysql_error());
				
			header("refresh: 0; url = 'topic.php'");
	
	?>
</body>
</html>