<!DOCTYPE html>
<html>
	<head>
		<title>基本資料填寫</title>
		<?php require_once('userNewSource.php');  //啟用BS,JS,CSS效果 ?>
	</head>
	<body>
		<?php
		require_once("mysql.php");

		$sql_eventName = "select * from topic_grade where topicGrade_event=1";
		$sql_eventNa = mysql_query($sql_eventName) or die( mysql_error()); 
		$s_eventNa=mysql_fetch_array($sql_eventNa); 
		?>
			
		<div class="bg_image">

			<div id="event_name"><?php echo $s_eventNa['topicGrade_na'];?>專用</div>
			
			<!-- 第一步：判定是前後測 !-->
			
			<div id="step1" class="user_step" style="display:none;">
				<h1 class="header step_name">第一次測驗?</h1>
				<div class="row Option_image">
					<div class="col-xs-5 col-md-2">
						<a href="#" onclick="javascript:step1()">
							<img src="assets/images/icon/y.png">
						</a>
					</div>
					<div class="col-xs-5 col-md-2">
						<a href="quiz.php">
							<img src="assets/images/icon/n.png">
						</a>
					</div>
				</div>
			</div>
			
			<script>
				function step1(){
					document.getElementById('step1').style.display='none';
					document.getElementById('step2').style.display='block';
				}
			</script>
			
			<!-- 瑞城同學只要填性別 !-->
			<div id="step2" class="user_step" >
				<h4 class="header step_name">性別選擇
				<!--<button type="button" class="btn btn-default" onclick="javascript:up2()">上一步</button>!--></h4>
				
				<div class="row Option_image">
					<!-- 抓取資料庫性別欄(sex) !-->
					<?php
					$sql = "select * from userclass";
					$t=mysql_query($sql) or die( mysql_error()); 
					while ($s = mysql_fetch_array ($t)){
						if($s['userClass_sex']!=''){ ?>
							<div class="col-xs-5 col-md-2">
								<a href="#" onclick="javascript:submit_info(<?php echo $s['userClass_no'];?>)">
									<img src="assets/images/icon/<?php echo $s['userClass_sex'];?>.png">
								</a>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
			
			<div id="go_index">
				<a href="index.php"><img height="45vh" src="assets/images/icon/回首頁.png"></a>
			</div>
			<script>
				function submit_info(s2){
					window.location = 'userNew_res.php?new=2&area=6&grade_no=<?php echo $s_eventNa['topicGrade_no'];?>&amount=<?php echo $s_eventNa['topicGrade_amount'];?>&event=1&sex='+s2+'&old=2&study=2&team=1&lineID=&email=';
				}
				
				function up2(){
					document.getElementById('step1').style.display='block';
					document.getElementById('step2').style.display='none';
				}
			</script>
		</div>
	</body>
</html>