<!DOCTYPE html>
<html>
	<head>
		<title>新增中_問卷題目</title>
		<meta charset="utf-8">
	</head>
	<body>
	<?php  
	// 新增問卷題目
	require_once('mysql.php'); 
	$ftyName = $_POST['ftyName'];
	$newQuiz = $_POST['newQuiz'];
	
	if ($ftyName!=0){
		$sql_newQuiz = "insert into surveytopic(fty_no, surveytopic_content) values ('$ftyName', '$newQuiz')";
		mysql_query($sql_newQuiz) or die(mysql_error());
	}else{
		$sql_factoryNo = "select * from factory where fty_no!=0";
		$sql_ftyNo = mysql_query($sql_factoryNo) or die(mysql_error());
		while ($s_ftyNo = mysql_fetch_assoc($sql_ftyNo)){
			$sql_newQuiz = "insert into surveytopic(fty_no, surveytopic_content) values (".$s_ftyNo['fty_no'].",'$newQuiz')";
			mysql_query($sql_newQuiz) or die(mysql_error());
		}
	}
	
	
	header("refresh:0; url=surveyNew.php?status=ok") ;	
	?>
	</body>
</html>