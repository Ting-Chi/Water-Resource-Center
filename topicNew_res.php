
<!DOCTYPE html>

<html>
<head>
	<title>topicNew_res</title>
	<meta charset="utf-8" >
	 <?php session_start();?>
</head>

<body>
<?php require_once("chk_login.php");?>

	<?php

		if(isset($_SESSION["chk"])){
			$fty_no = $_SESSION["fty_no"];
			$types = $_POST['types'];

		/* choose */
			if ($types=="c") {
				$content = $_POST['ch_content'];

				//上傳程式
				$updir = "assets/images/topic/";
				//$size_bytes = 4000*1024;
				$img_type = array(".jpg" ,".jpeg" ,".pjpeg" ,".gif" ,".png");
				$new_file = $_FILES['ch_img'];
				$file_name = $new_file ['name'];
				$ext = strrchr($file_name, '.');  //抓檔案副檔名
				$file_date = date("Y_m_d h_i_s" ,time());
				$file_name = $file_date.$ext;
				$file_tmp = $new_file['tmp_name'];  //暫存資料夾*/

				
				move_uploaded_file($file_tmp, $updir.$file_name);
				
				
				$a1 = $_POST['ch_ans1'];
				$a2 = $_POST['ch_ans2'];
				$a3 = $_POST['ch_ans3'];
				$a4 = $_POST['ch_ans4'];
				$ans = $_POST['ch_answer'];


				require_once("mysql.php");
				$sql = "select topic_content from topic";
				$result=mysql_query($sql) or die(mysql_error());

				$num = mysql_num_rows($result);
				$chk_repeat = false;
		
				for ($i = 1; $i <= $num; $i++)	{
					$row = mysql_fetch_assoc($result);

					if ($row["topic_content"] == $content){
						header("refresh: 0; url=topicNew.php ? chk_repeat=1");
						$chk_repeat = true;
						break;
					}
				}

				if ($chk_repeat==false) {
					$sql = "INSERT INTO `topic`(`fty_no`, `topic_types`, `topic_content`, `topic_img`, `topic_a1`, `topic_a2`, `topic_a3`, `topic_a4`, `topic_ans`) VALUES ('$fty_no', '$types', '$content', '$file_name', '$a1', '$a2', '$a3', '$a4' ,'$ans' )";
					mysql_query($sql)or die(mysql_error());



					header('refresh:0 ; url=topic.php') ;
				}

		/* choose  over*/

		/* yesno */
			}elseif ($types=="y") {

				$content = $_POST['yn_content'];
				//$img = $_POST['img'];
				//上傳程式
				$updir = "assets/images/topic/";
				//$size_bytes = 4000*1024;
				$img_type = array(".jpg" ,".jpeg" ,".pjpeg" ,".gif" ,".png");
				$new_file = $_FILES['yn_img'];
				$file_name = $new_file ['name'];
				$ext = strrchr($file_name, '.');  //抓檔案副檔名
				$file_name = date("Y_m_d h_i_s" ,time()).$ext;
				$file_tmp = $new_file['tmp_name'];  //暫存資料夾*/

				move_uploaded_file($file_tmp, $updir.$file_name);

	  	
				$a1 = "O";
				$a2 = "X";
				$a3 = "-";
				$a4 = "-";
				$ans = $_POST['yn_answer'];

		
				require_once("mysql.php");

				$sql = "select topic_content from topic";
				$result=mysql_query($sql) or die(mysql_error());

				$num = mysql_num_rows($result);
				$chk_repeat = false;
		
				for ($i = 1; $i <= $num; $i++)	{
					$row = mysql_fetch_assoc($result);

					if ($row["topic_content"] == $content){
						header("refresh: 0; url=topicNew.php ? chk_repeat=1");
						$chk_repeat = true;
						break;
					}
				}

				if ($chk_repeat==false) {
					$sql = "INSERT INTO `topic`(`fty_no`, `topic_types`, `topic_content`, `topic_img`, `topic_a1`, `topic_a2`, `topic_a3`, `topic_a4`, `topic_ans`) VALUES ('$fty_no', '$types', '$content', '$file_name', '$a1', '$a2', '$a3', '$a4' ,'$ans' )";
					mysql_query($sql) or die(mysql_error());

					header('refresh:0 ; url=topic.php') ;
				}
			}
		/* yesno  over*/
			
		}
	?>
	
</body>
</html>