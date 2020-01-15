
<!DOCTYPE html>

<html>
<head>
	<title>topicEdit</title>
	<meta charset="utf-8" >

	<?php session_start();?>
</head>

<body>
<?php require_once("chk_login.php");?>

	<?php
		if(isset($_SESSION["chk"])){
			if($_SESSION["topicLOA"]==0){
			$topic_no = $_SESSION['topic_no'];
			$types = $_POST['types'];
			$topic = $_SESSION["topic"];
			$img = $_SESSION["img"];



		/* CHOOSE */
			if ($types=="c") {
				$content = $_POST['ch_content'];

				if ($_FILES['ch_img']['error']==4){ //如果沒有更改圖片就用之前的圖片

					$file_name = $img;

				}else{

					//上傳程式
					$updir = "assets/images/topic/";
					$img_type = array(".jpg" ,".jpeg" ,".pjpeg" ,".gif" ,".png");
					$new_file = $_FILES['ch_img'];
					$file_name = $new_file ['name'];
					$ext = strrchr($file_name, '.');  //抓檔案副檔名
					$file_date = date("Y_m_d h_i_s" ,time());
					$file_name = $file_date.$ext;
					$file_tmp = $new_file['tmp_name'];  //暫存資料夾*/

					move_uploaded_file($file_tmp, $updir.$file_name);

				}
			
		  	
				$a1 = $_POST['ch_ans1'];
				$a2 = $_POST['ch_ans2'];
				$a3 = $_POST['ch_ans3'];
				$a4 = $_POST['ch_ans4'];
				$ans = $_POST['ch_answer'];
				

				//判斷題目是否重複,並排除掉修改同一題的情況
				require_once("mysql.php");
				$sql = "select topic_content from topic";
				$result=mysql_query($sql) or die(mysql_error());
				$num = mysql_num_rows($result);
				$chk_repeat = false;

				for ($i = 1; $i <= $num; $i++)	{
					$row = mysql_fetch_assoc($result);

					if ($row["topic_content"] == $content){
						if ( $topic != $content) {
							header("refresh: 0; url=topicEdit.php ? chk_repeat=1 & topic_no=$topic_no");
							$chk_repeat = true;
							break;
						}
					}
				}
			
				if ($chk_repeat==false) {
					$sql = "UPDATE `topic` set `topic_types`='$types' , `topic_content`='$content',  `topic_img`='$file_name', `topic_a1`='$a1', `topic_a2`='$a2', `topic_a3`='$a3', `topic_a4`='$a4', `topic_ans`='$ans' where topic_no = $topic_no";
				
					mysql_query($sql) or die(mysql_error());
					header('refresh:0 ; url=topic.php') ;
				}

		/* CHOOSE over */

		/* YESNO */
			}elseif ($types=="y") {
				$content = $_POST['yn_content'];

				if ($_FILES['yn_img']['error']==4){

					$file_name = $img;

				}else{
					$updir = "assets/images/topic/";
					$img_type = array(".jpg" ,".jpeg" ,".pjpeg" ,".gif" ,".png");
					$new_file = $_FILES['yn_img'];
					$file_name = $new_file ['name'];
					$ext = strrchr($file_name, '.');  //抓檔案副檔名
					$file_date = date("Y_m_d h_i_s" ,time());
					$file_name = $file_date.$ext;
					$file_tmp = $new_file['tmp_name'];  //暫存資料夾*/

					move_uploaded_file($file_tmp, $updir.$file_name);
				}
			
		  	
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
						if ( $topic != $content) {
							header("refresh: 0; url=topicEdit.php ? chk_repeat=1 & topic_no=$topic_no");
							$chk_repeat = true;
							break;
						}
					}
				}

				if ($chk_repeat==false) {

					$sql = "UPDATE `topic` set `topic_types`='$types' , `topic_content`='$content' , `topic_img`='$file_name', `topic_a1`='$a1', `topic_a2`='$a2', `topic_a3`='$a3', `topic_a4`='$a4', `topic_ans`='$ans' where topic_no = $topic_no";

					mysql_query($sql) or die(mysql_error());
					header('refresh:0 ; url=topic.php') ;
				}
			}
		/* YESNO over */
		}
	} 
?>
	
</body>
</html>