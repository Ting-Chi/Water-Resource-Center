
<!DOCTYPE html>

<html>
<head>
	<title>news_delete</title>
	<meta charset = "UTF-8">
</head>
<body>
<?php// require_once("chk_login.php");?>

		<?php

			//if(isset($_SESSION["chk"])){
				$news_no = $_GET["news_no"];
				
				require_once("mysql.php");
				
				$sql = "delete from news where news_no = $news_no";
				
				mysql_query($sql) or die(mysql_error());

				header("refresh: 0; url = 'news.php'");
			//}
		?>
</body>
</html>
