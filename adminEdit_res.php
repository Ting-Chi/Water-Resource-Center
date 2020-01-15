<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>admin_edit_res</title>
	
	<link rel="stylesheet" href="css/admin_new.css">

	<?php session_start();?>

</head>

<body>

<?php require_once("chk_login.php");?>

	<?php

	if(isset($_SESSION["chk"])){
		if($_SESSION["adminLOA"]==0){
		//修改管理員

		$adminNo_edit = $_SESSION['adminNo_edit']; //修改的管理員的編號
		$admin_no = $_SESSION["admin_no"];

		$na=$_POST['na'];
		$pwd=$_POST['pwd'];
		$sex=$_POST['sex'];
		$phone=$_POST['phone'];
		$email=$_POST['email'];

		require_once("mysql.php");

		$sql = "select * from admin";
		$result=mysql_query($sql) or die(mysql_error());

		$num = mysql_num_rows($result);

		echo "<br>";  
		$sql="UPDATE `admin` set `admin_na`='$na' , `admin_pwd`='$pwd' , `admin_sex`='$sex' , `admin_phone`='$phone' , `admin_email`='$email' where admin_no = $adminNo_edit";

		mysql_query($sql)or die(mysql_error());

		if ($adminNo_edit == $admin_no) {
			header("refresh:0; url=adminInfo.php?admin_edit=1 & admin_no=$adminNo_edit ") ;
		}else{
			header("refresh:0; url=admin.php?admin_edit=1") ;
		}
		
	}else{  //判斷是否有權限if
                echo "<script>alert('抱歉你無此權限！'); location.href = 'index_admin.php'</script>";
            }
        } //判斷是否有登入if
	
	?>
</body>
</html>