
<!DOCTYPE html>

<html>
<head>
	
	<title>login_res</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/login.css">

	<?php session_start();?>

</head>

<body>
	<?php

		if((!empty($_SESSION['check_word'])) && (!empty($_POST['checkword']))){  //判斷此兩個變數是否為空
      		
      		//先驗證圖案對不對
	       if($_SESSION['check_word'] != $_POST['checkword']){

	           header("refresh: 0; url = login.php?imgError=true");

	       }else{
	           
	           $_SESSION['check_word'] = ''; //比對正確後，清空將check_word值
	       
				if(!isset($_POST["id"])){
					require_once("chk_login.php");
				}else{
					//登入
					$id = $_POST["id"];
					$pwd = $_POST["pwd"];
						
					require_once('mysql.php');

					$sql = "select * from admin";
					$result=mysql_query($sql) or die(mysql_error());

					$num = mysql_num_rows($result);
					$has=0;
				
					for ($i = 1; $i <= $num; $i++)	{
						$row = mysql_fetch_assoc($result);

						if (($row["admin_id"] == $id) & ($row["admin_pwd"] == $pwd)){
							$has= 1;
							
							if ($row["admin_enable"] > 0) {   //判斷管理員是否有被停用
								header("refresh: 0; url = login.php?noEnable=true");
								break;
							}
								
								$_SESSION["admin_no"] = $row["admin_no"];
								$_SESSION["adminLv_no"] = $row["adminLv_no"];
								$_SESSION["admin_na"] = $row["admin_na"];
								$_SESSION["admin_sex"] = $row["admin_sex"];
								$_SESSION["fty_no"] = $row["fty_no"];


								header("refresh: 0; url = news.php");
								break;
						}	
					}
					

					if ($has==0){
						header("refresh: 0; url = login.php?error=true");
					}
				}
			}
  		}
	?>
</body>
</html>