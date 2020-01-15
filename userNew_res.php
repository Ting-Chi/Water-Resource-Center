<!DOCTYPE html>
<html>
<head>	
	<title>進入系統...</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/user_new.css">
	<?php session_start();?>
</head>
<body>
	<?php

		//先取得今日日期
		$tw_date = new DateTime("now");
		$tw_date->modify("+8 hours"); //再加8小時 (GMT+8)

		//新增會員
	
		$fty_no=$_GET['area'];
		
		$sex=$_GET['sex'];
		$old=$_GET['old'];
		$study=$_GET['study'];
		$team=$_GET['team'];
		$lineID=$_GET['lineID'];

		$_SESSION['lineID']=$lineID;

		
		require_once("mysql.php");

		//新增資料
		$sql_insert="insert into user(fty_no,user_time,user_sex, user_old , user_study,user_team ,user_lineId) values ('$fty_no',".$tw_date -> format("YmdHis").",'$sex','$old','$study','$team','$lineID')";
		mysql_query($sql_insert)or die(mysql_error());
		
		//取得最新資料編號 (也就是自己的編號)
		$sql_maxUserNo="select max(user_no) from user";
		$sql_maxUNo=mysql_query($sql_maxUserNo)or die(mysql_error());
		$s_maxUNo=mysql_fetch_array ($sql_maxUNo);
		
		$_SESSION['user_no']=$s_maxUNo['max(user_no)'];

		
		header("refresh:0; url=quizChoice.php?fty_no=$fty_no");
		
	
	?>
</body>
</html>