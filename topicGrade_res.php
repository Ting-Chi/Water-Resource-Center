
<!DOCTYPE html>

<html>
<head>
	
	<title>topicGrade_res</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/topicGrade.css">

	<?php session_start();?>

</head>

<body>
<?php require_once("chk_login.php");?>

	<?php
		if(isset($_SESSION["chk"])){
			//類別管理
			
			$fty=$_POST['fty'];
			$topicGrade_Name=$_POST['topicGrade_Name'];
			$amount=$_POST['amount'];
			
			require_once("mysql.php");

			$sql = "select * from topic_grade";
			$result=mysql_query($sql) or die(mysql_error());
			$num = mysql_num_rows($result);
			$chk_error = false;
		
			for ($i = 1; $i <= $num; $i++)	{
				$row = mysql_fetch_assoc($result);

				if ($row["topicGrade_na"] == $topicGrade_Name){
					header("refresh: 0; url=topicGrade.php ? chk_grade=1");
					$chk_error = true;
					break;

				}
			}

			if ($chk_error==false) {
				echo "<br>";
				$sql="INSERT INTO `topic_grade`(`topicGrade_na` , `fty_no`, `topicGrade_enable`, topicGrade_amount) VALUES ( '$topicGrade_Name','$fty','0','$amount')";
				mysql_query($sql)or die(mysql_error());

				header("refresh:0; url=topicGrade.php ? ok=1") ;
			}
		}
	?>
</body>
</html>