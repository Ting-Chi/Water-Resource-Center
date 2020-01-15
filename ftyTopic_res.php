
<!DOCTYPE html>

<html>
<head>
	<title>ftyTopic_res</title>
	<meta charset="utf-8" >

	<?php session_start();?>
</head>

<body>
<?php require_once("chk_login.php");?>

	<?php
		if(isset($_SESSION["chk"])){

	        $fty = $_SESSION["fty"];
			$grade = $_SESSION["grade"];

			require_once("mysql.php");

			/* - 顯示之前就選取的題目 - */
			$i=0;  
			$chked = array();
			$sql = "select * from fty_topic where fty_no = $fty && topicGrade_no = $grade && ftyTopic_enable = 0";
			$U =mysql_query($sql) or die(mysql_error());
			while ( $s =mysql_fetch_array($U) ){
					$chked[]= $s["topic_no"];
					$i++;
			}

			//print_r($chked); //之前就選的題目

			/* - 先將之前所選的題目先全部停用 - */
			foreach ($chked as $value) {  
				$sql="UPDATE `fty_topic` set `ftyTopic_enable`='1' where fty_no = $fty && topicGrade_no = $grade && topic_no = $value";
				mysql_query($sql)or die(mysql_error());
			}

			//如果沒有選擇任何題目就直接跳回去,有就根據選擇的更改資料
			if(!isset($_POST["chkTopic"])){

				header("refresh:0; url=ftyTopic.php?fty=$fty&grade=$grade") ;

			}else{

				$chkTopic = $_POST["chkTopic"];//這次選的題目
				//print_r($chkTopic);

				/* - 依據這次所選的題目做動作 - */
				foreach ($chkTopic as $value) {
					$sql_have  = "select  * from fty_topic where fty_no = $fty && topicGrade_no = $grade && topic_no = $value";
					$t_get = mysql_query($sql_have) or die (mysql_error());
					$total_num = mysql_num_rows($t_get);   //撈出有幾筆資料
					if ($total_num > 0)
					{
						$sql="UPDATE `fty_topic` set `ftyTopic_enable` = '0' where fty_no = $fty && topicGrade_no = $grade && topic_no = $value";
					}
			     	else
					{
						$sql="INSERT INTO `fty_topic`(`fty_no` ,`topicGrade_no` ,`topic_no`) VALUES ( '$fty' ,'$grade' ,'$value')";
					}
					mysql_query($sql) or die (mysql_error());			
					
				}
				echo "<br><br>";
			}
			
			//更新出題數
			$amount = $_POST["amount"];
			$sql_amount="update topic_grade set topicGrade_amount = $amount where topicGrade_no = $grade";
			mysql_query($sql_amount) or die (mysql_error());
			
			header("refresh:0; url=ftyTopic.php?fty=$fty&grade=$grade") ;
			
			
		}	
	?>

	
</body>
</html>