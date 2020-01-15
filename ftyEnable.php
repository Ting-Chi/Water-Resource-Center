
<!DOCTYPE html>

<html>
<head>

	<title>factoryEnable</title>
	<meta charset="utf-8">

	<?php session_start();?>

</head>

<body>
<?php require_once("chk_login.php");?>

	<?php

		if(isset($_SESSION["chk"])){

			$fty_no = $_GET["fty_no"];
				
			require_once("mysql.php");

			$sql = "select fty_enable from factory where fty_no = $fty_no";
			$U =mysql_query($sql) or die(mysql_error());

			while ( $s =mysql_fetch_assoc($U) ){ //停用啟用廠區時一並將該管理員一起設定

				if ($s["fty_enable"]=="0") {
					$sql="UPDATE `factory` set `fty_enable`='1' where fty_no = $fty_no";

					$adminSQL = "UPDATE `admin` set `admin_enable`='1' where fty_no = $fty_no AND admin_enable='0'";
					
				}else{
					$sql="UPDATE `factory` set `fty_enable`='0' where fty_no = $fty_no";

					$adminSQL = "UPDATE `admin` set `admin_enable`='0' where fty_no = $fty_no AND admin_enable='1'";
				}
			
				mysql_query($sql)or die(mysql_error());
				mysql_query($adminSQL)or die(mysql_error());

				header("refresh: 0; url = 'factory.php'");

			}
		}
	?>
</body>
</html>