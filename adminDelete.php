
<!DOCTYPE html>
<html>
<head>
	<title>admin_Delete</title>
	<meta charset = "UTF-8">

</head>
	<body>
		<?php require_once("chk_login.php");?>

			<?php

				if(isset($_SESSION["chk"])){
					$admin_no = $_GET["admin_no"];
					
					require_once("mysql.php");
					
					$sql = "delete from admin where admin_no = $admin_no";
					
					mysql_query($sql) or die(mysql_error());
					
					header("refresh: 0; url = 'admin.php'");
				}
			?>
	</body>
</html>

<html>
	
</html>