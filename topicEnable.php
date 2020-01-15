
<!DOCTYPE html>

<html>
<head>

	<title>topicEnable</title>
	<meta charset="utf-8">

	<?php session_start();?>

</head>

<body>
<?php require_once("chk_login.php");?>

	<?php

		if(isset($_SESSION["chk"])){

			$topic_no = $_GET["topic_no"];
				
			require_once("mysql.php");

			$sql = "select topic_enable from topic where topic_no = $topic_no";
			$U =mysql_query($sql) or die(mysql_error());

			while ( $s =mysql_fetch_assoc($U) ){ //停用啟用廠區時一並將該管理員一起設定

				if ($s["topic_enable"]=="0") {
					$sql="UPDATE `topic` set `topic_enable`='1' where topic_no = $topic_no";

				}else{
					$sql="UPDATE `topic` set `topic_enable`='0' where topic_no = $topic_no";

				}
			
				mysql_query($sql)or die(mysql_error());

				header("refresh: 0; url = 'topic.php'");

			}
		}
	?>
</body>
</html>