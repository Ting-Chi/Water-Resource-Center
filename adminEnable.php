
<!DOCTYPE html>

<html>
<head>

	<title>adminEnable</title>
	<meta charset="utf-8">

	<?php session_start();?>

</head>

<body>

<?php require_once("chk_login.php");?>

	<?php

		if(isset($_SESSION["chk"])){
			$admin_no = $_GET["admin_no"];
				
			require_once("mysql.php");

			$sql = "select admin_enable from admin where admin_no = $admin_no";
			$U =mysql_query($sql) or die(mysql_error());

			while ( $s =mysql_fetch_assoc($U) ){

				if ($s["admin_enable"]=="0") { //停用管理員時將參數設成2,避免跟廠區停用啟用搞混
					$sql="UPDATE `admin` set `admin_enable`='2' where admin_no = $admin_no";
				}else{
					$sql="UPDATE `admin` set `admin_enable`='0' where admin_no = $admin_no";
				}
			
				mysql_query($sql)or die(mysql_error());

				header("refresh: 0; url = 'admin.php'");

			}
		}
	?>
</body>
</html>