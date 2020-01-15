<html>
<head>
	<meta charset="utf-8">
	<title>答題結果 - 前後測系統</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
	<!-- jQuery (Bootstrap 所有外掛均需要使用) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- Bootstrap -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	
	<link rel="stylesheet" href="assets/css/quiz.css">
	<?php session_start(); ?>
</head>
<body>
	<?php

	if(isset($_SESSION['user_no'])){
		$topic_ans = $_SESSION['topic_ans'];
		$userAns = $_GET['ans'];
		$total_disable=$_SESSION['total_disable'];
		
		require_once("mysql.php");
		
		if(isset($_SESSION['lineID'])){
			$sql_userID= "select * from line_Connect where lineConnect_lineid='".$_SESSION['lineID']."'";
			$sql_uID=mysql_query($sql_userID) or die( mysql_error());
			$s_uID= mysql_fetch_assoc ($sql_uID);
			$from=$s_uID['lineConnect_userid']; //$from給push.php作為發送對象用
		}
		
		// 取得此份試卷編號
		$user_no=$_SESSION['user_no'];
		
		if ($_SESSION['i']==1){ //目前若是1，清空總答對題數(無論前後測)
			
			$_SESSION['total']=0;
		}

		if (($userAns==$topic_ans) and ($total_disable==0)){
			
			$total=$_SESSION['total'];
			$total+=1;
			$total_disable=1; //防止透過F5洗答對題數 1=禁止計算答對數 0=允許
			
			$_SESSION['total_disable']=$total_disable;
			$_SESSION['total']=$total; ?>
			
			<div class="hidden-xs hidden-sm ans_correct">
				<center><img src="assets/images/test/答對.gif" height="100%"></center>
			</div>
			<div class="hidden-lg hidden-md ans_correct">
				<center><img src="assets/images/test/手機-答對.gif" height="100%"></center>
			</div>
			<?php
		}
		
		if ($userAns!=$topic_ans){ ?>
		
			<div class="hidden-xs hidden-sm ans_wrong">
				<center><img src="assets/images/test/答錯.gif" height="100%"></center>
			</div>
			<div class="hidden-lg hidden-md ans_wrong">
				<center><img src="assets/images/test/手機-答錯.gif" height="100%"></center>
			</div>
			<?php
			
			if ($_SESSION['test']==2){ //如果後測答錯且有line帳號
				if(isset($_SESSION['lineID'])){
					
					$sql_topicNo= "select * from topic where topic_no='".$_SESSION['topic_no']."'"; //
					$sql_tNo=mysql_query($sql_topicNo) or die( mysql_error());
					$s_tNo= mysql_fetch_assoc ($sql_tNo);	
					
					if(($s_tNo['topic_ans']=="a") or ($s_tNo['topic_ans']=="1")){ $answerLine=$s_tNo['topic_a1'];} //如果答案是1就撈topic_a1的內容
					if(($s_tNo['topic_ans']=="b") or ($s_tNo['topic_ans']=="2")){ $answerLine=$s_tNo['topic_a2'];}
					if($s_tNo['topic_ans']=="c"){ $answerLine=$s_tNo['topic_a3'];}
					if($s_tNo['topic_ans']=="d"){ $answerLine=$s_tNo['topic_a4'];}
					
					if(($userAns=="a") or ($userAns=="1")){ $userAns=$s_tNo['topic_a1'];} //如果使用者選1就撈topic_a1的內容
					if(($userAns=="b") or ($userAns=="2")){ $userAns=$s_tNo['topic_a2'];}
					if($userAns=="c"){ $userAns=$s_tNo['topic_a3'];}
					if($userAns=="d"){ $userAns=$s_tNo['topic_a4'];}
					
					$wrong_state="好可惜！答錯了 😢\n\n Q: ".$s_tNo['topic_content']."\n\n⭕ 正確解答 [ ".$answerLine." ]\n❌ 你的答案 [ ".$userAns." ]";
					require_once("line-API/push.php");
				}
			}
		}
		
		if ($_SESSION['i']==$_SESSION['j']){ ?>
			<script type="text/javascript">	
				$(document).ready(function(){
					$(".ans_correct").delay(1500).fadeOut(1000);
					$(".ans_wrong").delay(1500).fadeOut(1000);
					$(".total_count").delay(1500).fadeIn(1000);
					$(".ans_info").delay(1500).fadeIn(1000);
				});
			</script>
			<?php 
			
			echo "<span class='ans_info'>Wow！答對了&nbsp&nbsp<font color='#FF4D4D' style='font-size:10vh;'>".$_SESSION['total']."</font>&nbsp&nbsp題</span>";
			
			
			if ($_SESSION['test']==1){
				
				$_SESSION['i']=1; //準備進入後測 變回第一題
				$_SESSION['test']=2; //表示後測
				$_SESSION['testing']=1; //表示測驗中 ?>
				
				<div class="hidden-xs hidden-sm total_count" style="display:none;">
					<img src="assets/images/test/結算.jpg" height="100%"><br>
					<div class="judge">
						<a class="next_btn" href="index.php">到水寶樂園找答案囉！</a>
						<a class="giveup" href="logout.php">放棄</a>
					</div>
				</div>
				
				<div class="hidden-lg hidden-md total_count" style="display:none;">
					<img src="assets/images/test/手機-黑板.jpg" height="100%"><br>
					<div class="judge">
						<a class="next_btn" href="index.php">到水寶樂園找答案囉！</a>
						<a class="giveup" href="logout.php">放棄</a>
					</div>
				</div>
				<?php

				//存入前測成績
				
				$test1 = "UPDATE user set user_test1='$_SESSION[total]' where user_no='$user_no' ";
				mysql_query($test1) or die(mysql_error());

			}else{
				
				//回存分數到資料庫
			
				$test2 = "UPDATE user set user_test2='$_SESSION[total]' where user_no='$user_no' ";
				mysql_query($test2) or die(mysql_error());
				
				//進退步分析
				
				$ju= "select user_no, user_test2-user_test1 '進退步' from user where user_no='$user_no'";
				$jud=mysql_query($ju) or die(mysql_error());
				$judg=mysql_fetch_assoc($jud);
				$judge=$judg['進退步'];

				if ($judge>0){
					$judge_info="評語：<font color=yellow>進步</font>&nbsp".$judge."&nbsp題"; //給網頁的
					$end_state="⭐ 測驗結束囉 ⭐\n\n太棒了！你進步了".$judge."題\n收穫滿滿，恭喜 👍"; //給line的
				
				}else if ($judge<0){
					$judge_info="評語：<font color=yellow>退步</font>&nbsp".abs($judge)."&nbsp題";
					$end_state="⭐ 測驗結束囉 ⭐\n\n真可惜！下次再加油";
					
				}else{
					$judge_info="評語：<font color=yellow>維持原有水準</font>";
					$end_state="⭐ 測驗結束囉 ⭐\n\n表現可圈可點~";
				}?>
				
				
				<div class="hidden-xs hidden-sm total_count" style="display:none;">
					<img src="assets/images/test/結算.jpg" height="100%"><br>
					<div class="judge">
						<?php echo $judge_info; ?>
					</div>
					<center><a class="end_btn" href='logout.php'>結束猜題</a></center>
					<?php if($judge>=0){ ?>
					<img class="good" src="assets/images/test/合格.png" height="20%"><br>
					<?php } ?>
					<!-- 水寶老師 (絕對位置) !-->
					<div><image class="col-lg-offset-1 col-lg-3 col-md-3 teacher" src="assets/images/test/水寶老師.gif"></div>
				</div>
				
				<div class="hidden-lg hidden-md total_count" style="display:none;">
					<img src="assets/images/test/手機-黑板.jpg" height="100%"><br>
					<div class="judge">
						<?php echo $judge_info; ?>
					</div>
					<center><a class="end_btn" href='logout.php'>結束猜題</a></center>
					<?php if($judge>=0){ ?>
						<img class="good" src="assets/images/test/合格.png" height="20%"><br>
					<?php } ?>
					<!-- 水寶老師 (絕對位置) !-->
					<div><image class="col-xs-3 col-sm-3 m_teacher" src="assets/images/test/水寶老師.gif"></div>
				</div>
				
				<?php
				if(isset($_SESSION['lineID'])){
					require_once("line-API/push2.php");
				}
			}
		}else{
			//進入下一題
			$_SESSION['i']+=1;  
			header("refresh: 1.5; url = quiz.php");
		}
	}else{
		echo "<script>alert('哎呀！好像有點問題！再來一次吧！')</script>";
		header("refresh: 5; url = logout.php");
	}

	?>
</body>
</html>