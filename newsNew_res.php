
<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<title>admin_new_res</title>
	
	<link rel="stylesheet" href="css/news.css">

	<?php session_start();?>

</head>

<body>
<?php require_once("chk_login.php");?>

	<?php
		if(isset($_SESSION["chk"])){
			if($_SESSION["newsLOA"]==0){
				$title = $_POST['title'];
				$date = date("Y/m/d");
				$news_content = $_POST['news_content'];

				$fty_no = $_SESSION["fty_no"];


				require_once("mysql.php");

				$sql = "select * from news";
				$result=mysql_query($sql) or die(mysql_error());

				$num = mysql_num_rows($result);
				$chk_error = false;
			
				for ($i = 1; $i <= $num; $i++)	{
					$row = mysql_fetch_assoc($result);

					if ($row["news_title"] == $title){
						header("refresh: 0; url=newsNew.php ? chk_repeat=1");
						$chk_error = true;
						break;

					}
				}

				if ($chk_error==false) {
					echo "<br>";
					$sql="INSERT INTO `news`(`fty_no` ,`news_title` ,`news_date` ,`news_content`) VALUES ( '$fty_no' ,'$title' ,'$date' ,'$news_content')";

					mysql_query($sql)or die(mysql_error());

					header("refresh:0; url=news.php") ;
				}
			}else{  //判斷是否有權限if
                echo "<script>alert('抱歉你無此權限！'); location.href = 'index_admin.php'</script>";
            }
        } //判斷是否有登入if

	?>
</body>
</html>