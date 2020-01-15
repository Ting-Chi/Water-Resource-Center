
<!DOCTYPE html>

<html>
<head>
	
	<title>ftyNew_res</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/topicClass.css">

	<?php session_start();?>

</head>

<body>
<?php require_once("chk_login.php");?>

	<?php
		if(isset($_SESSION["chk"])){
			//廠區管理
			
			$ftyName=$_POST['ftyName'];
			$phone=$_POST['phone'];
			$email=$_POST['email'];
			$address=$_POST['address'];

			require_once("mysql.php");

			$sql = "select * from factory";
			$result=mysql_query($sql) or die(mysql_error());

			$num = mysql_num_rows($result);
			$chk_error = false;
		
			for ($i = 1; $i <= $num; $i++)	{
				$row = mysql_fetch_assoc($result);

				if ($row["fty_na"] == $ftyName){
					header("refresh: 0; url=ftyNew.php ? chk_repeat=1");
					$chk_error = true;
					break;
				}
			}

			if ($chk_error==false) {
				echo "<br>";
				$sql="INSERT INTO `factory`(`fty_na`,  `fty_phone`, `fty_email`, `fty_address`) VALUES ( '$ftyName',  '$phone', '$email', '$address')";
				mysql_query($sql)or die(mysql_error());

				header("refresh:0; url=factory.php ? ok=1") ;
			}
		}
	?>
</body>
</html>