
<!DOCTYPE html>

<html>
<head>
	
	<title>ftyEdit_res</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/topicClass.css">

	<?php session_start();?>

</head>

<body>
<?php require_once("chk_login.php");?>

	<?php
		if(isset($_SESSION["chk"])){
			//廠區管理
			
			$ftyNo_edit = $_SESSION['ftyNo_edit']; //修改的管理員的編號
			$ftyNa = $_SESSION["ftyNa"]; //修改的管理員的名(用來排除掉修改同一個的情況)

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
					if ( $ftyNa != $ftyName) {
						header("refresh: 0; url=ftyEdit.php ? chk_repeat=1 & fty_no=$ftyNo_edit");
						$chk_error = true;
						break;
					}
				}
			}

			if ($chk_error==false) {
				echo "<br>";
				$sql="UPDATE `factory` set `fty_na`='$ftyName' , `fty_phone`='$phone' , `fty_email`='$email' , `fty_address`='$address'  where fty_no = $ftyNo_edit";
				mysql_query($sql)or die(mysql_error());

				header("refresh:0; url=factory.php ? ok=1") ;
			}
		}
	?>
</body>
</html>