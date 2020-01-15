
<style type="text/css">
	.chk_login{
		position: absolute;
		left: 50%;
		top: 50%;
		margin-top: -250px;
		margin-left: -250px;
		background-color: #dddddd;

	}
</style>

<?php
	if(!isset($_SESSION["admin_no"])){
		echo "<div class='chk_login'><img src='assets/images/chk.png'></div>";
		header("Refresh: 3; url=login.php");
		
	}else{
		$_SESSION['chk'] = 'ok';

		//將各權限值存入全域函數
		require_once("mysql.php");
	    $adminLv_no = $_SESSION["adminLv_no"];
	    $sql = "select * from authority where adminLv_no='$adminLv_no'";
	    $U =mysql_query($sql) or die(mysql_error());
	    while ( $s =mysql_fetch_assoc($U) ){

	        $_SESSION["newsLOA"] = $s['newsLOA'];
	        $_SESSION["ftyLOA"] = $s['ftyLOA'];
	        $_SESSION["adminLOA"] = $s['adminLOA'];
	        $_SESSION["adminLOA_new"] = $s['adminLOA_new'];
	        $_SESSION["adminLOA_authority"] = $s['adminLOA_authority'];
	        $_SESSION["topicLOA"] = $s['topicLOA'];
	        $_SESSION["topicLOA_newgrade"] = $s['topicLOA_newgrade'];
	        $_SESSION["surveyLOA"] = $s['surveyLOA'];
	        $_SESSION["analysisLOA"] = $s['analysisLOA'];
    	}
	}
?>