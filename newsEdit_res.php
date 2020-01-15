
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

				$newsNo_edit = $_SESSION['newsNo_edit']; //修改的編號
				$title = $_POST['title'];
				$news_content = $_POST['news_content'];
				$fty_no = $_SESSION["fty_no"];
				$news_title = $_SESSION["news_title"];


				require_once("mysql.php");

				$sql = "select * from news";
				$result=mysql_query($sql) or die(mysql_error());
				$num = mysql_num_rows($result);
				$chk_error = false;
			
				for ($i = 1; $i <= $num; $i++)	{
					$row = mysql_fetch_assoc($result);

					if ($row["news_title"] == $title){
						if ( $news_title != $title) {
							header("refresh: 0; url=newsEdit.php ? chk_repeat=1 & news_no=$newsNo_edit");
							$chk_error = true;
							break;
						}
					}
				}

				if ($chk_error==false) {
					echo "<br>";
					$sql="UPDATE `news` set `fty_no`='$fty_no' , `news_title`='$title' , `news_content`='$news_content' where news_no = $newsNo_edit";
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