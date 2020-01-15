<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="user-scalable=no">
	<title>測驗中 - 前後測系統</title>
	<font face="微軟正黑體">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><!-- Bootstrap -->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script><!-- jQuery Bootstrap -->
	<link rel="stylesheet" href="assets/css/quiz.css">
	<?php session_start(); ?>
</head>
<body>
	<?php 
	if (isset($_SESSION['aid'])){ 

		require_once("mysql.php");
		
		//前後測答題畫面
		
		$aid=$_SESSION['aid'];
		$i=$_SESSION['i']; 
		$_SESSION['total_disable']=0; //防止透過F5洗答對題數 1=禁止計算答對數 0=允許
		
		$sql= "select * from topic where topic_no=$aid[$i] ";
		$t=mysql_query($sql) or die( mysql_error()) ; 
		$s = mysql_fetch_assoc ($t);
		$img = "assets/images/topic/".$s['topic_img']; ?>
					
		<!-- 教室背景圖(網頁版) -->
		<div class="col-lg-12 col-md-12 hidden-xs hidden-sm" id="bg_img">
			<div class="container-fluid">
				<div class="row">
					<center><span id="title">水寶考考你</span></center>
					<div class="col-lg-offset-2 col-lg-12 col-md-12" id="quiz"><!-- 黑板內容 -->
						
						<!-- 題號/題目 !-->
						<div class="row" id="quiz_title">
							<font id="quiz_no">Q<?php echo $_SESSION['i'];?>/<?php echo array_search(end($aid),$aid);?>&nbsp&nbsp</font>
							<font id="quiz_content"><b><?php echo $s['topic_content'];?></b></font>
						</div>
						<br>
						<div class="row">
							<div class="col-md-4 quiz_img">
								<!--圖片暫時拿掉!-->
								<img src="<?php echo $img;?>" height="200" ><br>
								<div id="before"><a href="logout.php">回首頁</a></div>
							</div>	
							<div class="col-md-6">
								<div class="row answer_area">
									
									<?php if ($s['topic_types']=='c'){ ?>
										
										<!-- 選項顯示 !-->
										<div class="quiz_option word_white" onclick="javascript:userAns('a')">
											<img src="assets/images/icon/option_1.png" height="50">&nbsp;<?php echo $s['topic_a1'];?>
										</div>
										<div class="quiz_option word_white" onclick="javascript:userAns('b')">
											<img src="assets/images/icon/option_2.png" height="50">&nbsp;<?php echo $s['topic_a2'];?>
										</div>
										<div class="quiz_option word_white" onclick="javascript:userAns('c')">
											<img src="assets/images/icon/option_3.png" height="50">&nbsp;<?php echo $s['topic_a3'];?>
										</div>
										<div class="quiz_option word_white" onclick="javascript:userAns('d')">
											<img src="assets/images/icon/option_4.png" height="50">&nbsp;<?php echo $s['topic_a4'];?>
										</div>
										<br>
										<div class="row">
											<!-- 作答按鈕 !-->
											<div class="col-md-offset-1 col-md-6 word_white">
												你的答案：
											</div>
										</div>
										<br>
										<div class="row col-md-offset-1 userAns">
											<a href="#" onclick="javascript:userAns('a')">
												<img src="assets/images/icon/ans_1.png" height="50">
											</a>
											<a href="#" onclick="javascript:userAns('b')">
												<img src="assets/images/icon/ans_2.png" height="50">
											</a>
											<a href="#" onclick="javascript:userAns('c')">
												<img src="assets/images/icon/ans_3.png" height="50">
											</a>
											<a href="#" onclick="javascript:userAns('d')">
												<img src="assets/images/icon/ans_4.png" height="50">
											</a>
										</div>
									<?php }
									
									if ($s['topic_types']=='y'){ ?>
										
										<!-- 作答按鈕 !-->
										<div class="row">
											<div class="col-md-3">
												<a href="#" onclick="javascript:userAns('1')"> <!-- 可能要改成 OX !-->
													<img src="assets/images/icon/correct.png" height="100">
												</a>
											</div>
											<div class="col-md-3">
												<a href="#" onclick="javascript:userAns('2')">
													<img src="assets/images/icon/wrong.png" height="100">
												</a>
											</div>
										</div>
									<?php } 
		
									$_SESSION['topic_ans']=$s['topic_ans'];
									$_SESSION['topic_no']=$s['topic_no']; ?>
									
									<script>
										function userAns(ans){
											$('.answer_area').hide();
											$('.Processing').html('系統處理中...');
											window.location = 'quiz_res.php?ans='+ans;												
										}
									</script>
								</div>
								<!-- 送出答案時 顯示的文字 !-->
								<span class="Processing"> </span>
							</div>
						</div>
					</div>
					<div class="row"><!-- 講桌 !-->
						<div class="col-lg-offset-4 col-lg-12 col-md-12" id="desk"></div>
					</div>	
					<!-- 水寶老師 (絕對位置) !-->
					<div><image class="col-lg-offset-1 col-lg-3 col-md-3 teacher" src="assets/images/test/水寶老師.gif"></div>
				</div>
			</div>
		</div>
		
		<!-- 黑板內容(手機版) -->
		<div class="m_quiz col-xs-12 col-sm-12 hidden-lg hidden-md">
			<div class="container-fluid">
				<!-- 題號/題目 !-->
				<div class="row" id="quiz_title">
					<font id="quiz_no">Q<?php echo $_SESSION['i'];?>/<?php echo array_search(end($aid),$aid);?>&nbsp&nbsp</font>
					<font id="m_quiz_content"><b><?php echo $s['topic_content'];?></b></font>
				</div>
				<br>
				<div class="row">
					<div class="col-md-4" id="quiz_img">
						<div class="col-lg-offset-1 col-md-10" id="quiz_img">
							<!--圖片暫時拿掉!-->
							<img src="<?php echo $img;?>" height="300"><br><br><br>
						</div>
					</div>	
				</div>
				
				<?php if ($s['topic_types']=='c'){ ?>
					<div class="row answer_area">
						<!-- 選項顯示 !-->
						<div class="quiz_option m_word_white" onclick="javascript:userAns('a')">
							<img src="assets/images/icon/option_1.png" height="80vmin">&nbsp;<?php echo $s['topic_a1'];?>
						</div>
						<div class="quiz_option m_word_white" onclick="javascript:userAns('b')">
							<img src="assets/images/icon/option_2.png" height="80vmin">&nbsp;<?php echo $s['topic_a2'];?>
						</div>
						<div class="quiz_option m_word_white" onclick="javascript:userAns('c')">
							<img src="assets/images/icon/option_3.png" height="80vmin">&nbsp;<?php echo $s['topic_a3'];?>
						</div>
						<div class="quiz_option m_word_white" onclick="javascript:userAns('d')">                 
							<img src="assets/images/icon/option_4.png" height="80vmin">&nbsp;<?php echo $s['topic_a4'];?>
						</div>
					</div>
					<div class="row answer_area" style="display:none;">
						<br><br><br>
						<!-- 作答按鈕 !-->
						<div class="col-md-2 m_word_white m_uesrAns">
							你的答案：
						</div>
						<br>
						<div class="col-xs-12 col-sm-12 m_uesrAns">
							<a href="#" onclick="javascript:userAns('a')">
								<img src="assets/images/icon/ans_1.png" height="100vmin">
							</a>
							<a href="#" onclick="javascript:userAns('b')">
								<img src="assets/images/icon/ans_2.png" height="100vmin">
							</a>
							<a href="#" onclick="javascript:userAns('c')">
								<img src="assets/images/icon/ans_3.png" height="100vmin">
							</a>
							<a href="#" onclick="javascript:userAns('d')">
								<img src="assets/images/icon/ans_4.png" height="100vmin">
							</a>
						</div>
					</div>
				<?php }
						
				if ($s['topic_types']=='y'){ ?>
					
					<!-- 作答按鈕 !-->
					<div class="row answer_area">
						<div class="col-xs-12 col-sm-12">
							<a href="#" onclick="javascript:userAns('1')"> <!-- 可能要改成 OX !-->
								<img src="assets/images/icon/correct.png" height="100vmin">
							</a>
							<a href="#" onclick="javascript:userAns('2')">
								<img src="assets/images/icon/wrong.png" height="100vmin">
							</a>
						</div>
					</div>
				<?php } 
		
				$_SESSION['topic_ans']=$s['topic_ans'];
				$_SESSION['topic_no']=$s['topic_no']; ?>
				
				<script>
					function userAns(ans){
						$('.answer_area').hide();
						$('.Processing').html('系統處理中...');
						window.location = 'quiz_res.php?ans='+ans;													
					}
				</script>
				
				<!-- 送出答案時 顯示的文字 !-->
				<span class="Processing"> </span>
				
				<div id="m_before"><a href="logout.php">回首頁</a></div>
				
				<div class="row"><!-- 講桌 !-->
					<div class="col-xs-12 col-sm-12" id="m_desk"></div>
				</div>	
				
				<!-- 水寶老師 (絕對位置) !-->
				<div><image class="col-xs-3 col-sm-3 m_teacher" src="assets/images/test/水寶老師.gif"></div>
			</div>
		</div>

	<?php
	}else{ ?>
		<script type="text/javascript">
			alert('讀取錯誤：麻煩您重新操作一次。');
			window.location = 'userNew.php';		
		</script> 
	<?php } ?>
</body>
</html>