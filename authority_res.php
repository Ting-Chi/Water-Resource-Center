
<!DOCTYPE html>

<html>
<head>
	<title>authority_res</title>
	<meta charset="utf-8" >

	<?php session_start();?>
</head>

<body>
<?php require_once("chk_login.php");?>

	<?php
		if(isset($_SESSION["chk"])){

			//先判斷各權限是否有勾選,如果有在執行
			if(!isset($_POST["1"])){
				$super = 0; 
			}else{
				$super = $_POST["1"];
			}

			if(!isset($_POST["2"])){
				$director = 0; 
			}else{
				$director = $_POST["2"];
			}

			if(!isset($_POST["3"])){
				$employee = 0; 
			}else{
				$employee = $_POST["3"];
			}

		 	require_once("mysql.php");

		 	//先全部設成停用
			$sql="UPDATE `authority` set  `newsLOA`='1',`ftyLOA`='1',`adminLOA`='1',`adminLOA_new`='1',`topicLOA`='1',`topicLOA_newgrade`='1',`analysisLOA`='1',`surveyLOA`='1' where `authority_no`='1' or `authority_no`='2' or `authority_no`='3'";
			mysql_query($sql)or die(mysql_error());

			//將所有欄位取一個代號
			$LOA =array('newsLOA','ftyLOA','adminLOA','adminLOA_new','topicLOA','topicLOA_newgrade','surveyLOA','analysisLOA');

			if($super!=0){  
				$superUP = array(); //勾選的欄位
				foreach ($super as $value) {
					$superUP[] = $value % 10;
					
				}
				//依勾選的欄位搭配欄位代號更新
				foreach ($superUP as $value) {
					$sql="UPDATE `authority` set `$LOA[$value]` = '0' where `authority_no`='1'";
					mysql_query($sql) or die (mysql_error());
				}
			}

			if($director!=0){
				$directorUP = array();
				foreach ($director as $value) {
					$directorUP[] = $value % 10;
				}

				foreach ($directorUP as $value) {
					$sql="UPDATE `authority` set `$LOA[$value]` = '0' where `authority_no`='2'";
					mysql_query($sql) or die (mysql_error());
				}
			}

			if($employee!=0){
				$employeeUP = array();
				foreach ($employee as $value) {
					$employeeUP[] = $value % 10;
				}

				foreach ($employeeUP as $value) {
					$sql="UPDATE `authority` set `$LOA[$value]` = '0' where `authority_no`='3'";
					mysql_query($sql) or die (mysql_error());
				}
			}

			header("refresh:0; url=authority.php") ;

		
		}
	?>
	
</body>
</html>