
<!DOCTYPE html>

<html>
<head>
	
	<title>topicGrade_Enable</title>
	<meta charset="utf-8">

	<?php session_start();?>

</head>

<body>
<?php require_once("chk_login.php");?>

	<?php

		if(isset($_SESSION["chk"])){
			$topicGrade_no = $_GET["topicGrade_no"];
				
			require_once("mysql.php");

			$sql = "select topicGrade_enable from topic_grade where topicGrade_no = $topicGrade_no";
			$U =mysql_query($sql) or die(mysql_error());

			while ( $s =mysql_fetch_assoc($U) ){

				if ($s["topicGrade_enable"]=="0") {
					$sql="UPDATE `topic_grade` set `topicGrade_enable`='1' where topicGrade_no = $topicGrade_no";
				}else{
					$sql="UPDATE `topic_grade` set `topicGrade_enable`='0' where topicGrade_no = $topicGrade_no";
				}
			
				mysql_query($sql)or die(mysql_error());

				header("refresh: 0; url = 'topicGrade.php'");

			}
	
		}
	?>
</body>
</html>