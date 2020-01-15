<!DOCTYPE html>
<html>
	<head>
		<title>提交中...</title>
		<meta charset="utf-8">
		<?php session_start(); ?>
	</head>
	<body>
		<script>
		alert('送出成功，水寶謝謝你！');
		</script> 
		<?php
		//將已填寫問卷回存
			
		$quiz=$_POST['quiz'];
		$factory=$_SESSION['factory'];

		//先取得今日日期
		$tw_date = new DateTime("now");
		$tw_date->modify("+8 hours"); //再加8小時 (GMT+8)
		
		require_once("mysql.php");
		
		foreach ($quiz as $key => $value) {
			$sql="insert into survey(survey_time,surveytopic_aid,fty_no,survey_score) values (".$tw_date -> format("YmdHis").",'$key','$factory','$value')";
			mysql_query($sql)or die(mysql_error());
		}

		header("refresh:0; url=index.php?survey_ok=1") ;
			
		?>
	</body>
</html>