<!DOCTYPE html>
<html>
	<head>
		<title>問卷調查系統</title>
		<meta charset="utf-8">
		<font face="微軟正黑體">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php session_start(); ?>
		
		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">	
		<!-- jQuery (Bootstrap 所有外掛均需要使用) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	</head>
	<body>
		<?php 
			require_once('mysql.php'); 
			
			//撈出啟用中的廠區
			$sql_factory = "select * from factory where fty_enable=0 and fty_no!=0";
			$sql_fty = mysql_query($sql_factory) or die(mysql_error());
			
		?> 

		<form action="survey_res.php" method="post">
			<div id="page-wrapper">
				<div class="row">
					<div class="col-lg-10 col-lg-offset-1">
						<div class="panel panel-default">
							<div class="panel-heading">
							<?php if (isset($_GET['zh_TW'])){ echo $_GET['zh_TW']." - "; } ?>問卷系統
							</div>
							<div class="panel-body"> 
								<?php 
								if (empty($_GET['factory'])){
									echo "<div class=text-center><h1>請選擇廠區</h1>";
									while ( $s_fty = mysql_fetch_assoc($sql_fty) ){
										echo "<a href=survey.php?factory=".$s_fty['fty_no']."&zh_TW=".$s_fty['fty_na']."><input type=button value =".$s_fty['fty_na']." class='btn btn-primary btn-lg'></a>&nbsp;";
									}
									echo "</div>";
								} 
								
								//撈指定廠區的題目
								if (isset($_GET['factory'])){
									$factory = $_GET['factory'];
									$_SESSION['factory'] = $factory;
									$sql_surveyQuiz = "select * from surveytopic where fty_no=$factory";
									$sql_surQuiz = mysql_query($sql_surveyQuiz) or die(mysql_error());
								?>
								<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
										<tr><th>編號</th><th>問卷題目</th><th>選項1</th><th>選項2</th><th>選項3</th><th>選項4</th><th>選項5</th></tr>
									</thead>
									<tbody>
										<?php
										
										//顯示題目
										$i=1; 
										
										?>
										<!--
										<tr>
											<th><?php //echo $i; $i++;?></th>
											<th>請問您的性別</th>
											<th><label><input type="radio" name="quiz[0]" value="5" required>男</label></th>
											<th><label><input type="radio" name="quiz[0]" value="4">女</label></th>
											<th></th>
											<th></th>
											<th></th>
										</tr>
										!-->
										<?php
										while ($sql_Quiz = mysql_fetch_assoc($sql_surQuiz)){
											$Q_Content=$sql_Quiz['surveytopic_content'];
											$Q_id=$sql_Quiz['surveytopic_aid'];?>
										<tr>
											<th><?php echo $i; ?></th>
											<th><?php echo $Q_Content; ?></th>
											<th><label><input type="radio" name="quiz[<?php echo $Q_id; ?>]" value="5" checked>非常滿意</label></th>
											<th><label><input type="radio" name="quiz[<?php echo $Q_id; ?>]" value="4">滿意</label></th></th>
											<th><label><input type="radio" name="quiz[<?php echo $Q_id; ?>]" value="3">尚可</label></th></th>
											<th><label><input type="radio" name="quiz[<?php echo $Q_id; ?>]" value="2">不滿意</label></th></th>
											<th><label><input type="radio" name="quiz[<?php echo $Q_id; ?>]" value="1">非常不滿意</label></th></th>
										</tr>
										<?php $i++; } //while迴圈結尾 ?>
										
										<!--
										<tr>
											<th><?php echo $i; $i++;?></th>
											<th>我想再玩一次的原因</th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
										</tr>
										
										<tr>
											<th></th>
											<th>我想知道更多污水處理知識</th>
											<th><label><input type="radio" name="quiz[97]" value="5" required>是</label></th>
											<th><label><input type="radio" name="quiz[97]" value="4">否</label></th>
											<th></th>
											<th></th>
											<th></th>
										</tr>
										
										<tr>
											<th></th>
											<th>我覺得遊戲很好玩</th>
											<th><label><input type="radio" name="quiz[98]" value="5" required>是</label></th>
											<th><label><input type="radio" name="quiz[98]" value="4">否</label></th>
											<th></th>
											<th></th>
											<th></th>
										</tr>
										
										<tr>
											<th></th>
											<th>我想再次挑戰提升分數</th>
											<th><label><input type="radio" name="quiz[99]" value="5" required>是</label></th>
											<th><label><input type="radio" name="quiz[99]" value="4">否</label></th>
											<th></th>
											<th></th>
											<th></th>
										</tr>
										
										<tr>
											<th></th>
											<th>其他</th>
											<th colspan="5"><label><input type="text" name="quiz[100]"></label></th>
											
										</tr>
										!-->
										
										
									</tbody>
								</table>
								<?php }	//if迴圈結尾
								if (isset($sql_surQuiz)){
									if(mysql_num_rows($sql_surQuiz)==0){ //判斷sql_qCont有幾行資料
										echo "<center><h2>尚未新增題目</h2></center>";
									}
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		    <center>
			<div class="panel panel-default col-lg-10 col-lg-offset-1">
				<div class="panel-footer">
					<input type="button" onclick="location.href='index.php'" class='btn btn-default btn-lg' value="回首頁" >
					<?php if (isset($_GET['factory'])){?>				
					<input type="button" onclick="location.href='survey.php'" class='btn btn-default btn-lg' value="重新填寫" >
					<input type="submit" class="btn btn-primary btn-lg" value="確定送出">
					<?php }	?>
				</div>
			</div>	
		</form> 
	</body>
</html>
