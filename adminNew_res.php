
<!DOCTYPE html>

<html>
<head>
	
	<title>adminNew_res</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/adminNew.css">

	<?php session_start();?>

</head>

<body>
<?php require_once("chk_login.php");?>

	<?php
	if(isset($_SESSION["chk"])){

		$fty_no=$_POST["fty_no"];
		$level=$_POST['adminLv_no'];
		$na=$_POST['na'];
		$id=$_POST['id'];
		$pwd=$_POST['pwd'];
		$sex=$_POST['sex'];
		$phone=$_POST['phone'];
		$email=$_POST['email'];
		

		require_once("mysql.php");

		$sql = "select * from admin";
		$result=mysql_query($sql) or die(mysql_error());

		$num = mysql_num_rows($result);
		$chk_error = false;
	
		for ($i = 1; $i <= $num; $i++)	{
			$row = mysql_fetch_assoc($result);

			if ($row["admin_id"] == $id){
				header("refresh: 0; url=adminNew.php ? chk_id=1");
				$chk_error = true;
				break;

			}
		}

		if ($chk_error==false) {
			echo "<br>";
			$sql="INSERT INTO `admin`(`fty_no`, `adminLv_no`, `admin_na`, `admin_id`, `admin_pwd`, `admin_sex`, `admin_phone`, `admin_email` ) VALUES ('$fty_no','$level','$na', '$id', '$pwd', '$sex', '$phone', '$email')";
			mysql_query($sql)or die(mysql_error());

			header("refresh:0; url=admin.php ? ok=1") ;
		}
	}
	
	?>
</body>
</html>