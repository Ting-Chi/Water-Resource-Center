<!DOCTYPE html>
<html>
	<head>
		<title>基本資料填寫 - 前後測系統</title>
		<?php require_once('userNewSource.php');  //啟用BS,JS,CSS效果 ?> 
	</head>
	<body>
		<div class="bg_image" style="overflow-y:scroll;overflow-x:hidden">
			
			<!-- 放入廠區名稱 !-->
			<div id="event_name">&nbsp;</div>
			
			<!-- 第一步：判定是前後測 !-->
			
			<div id="step1" class="user_step">
				<div class="step_name">第一次測驗?</div>
				<div class="row Option_first_image">
					<div class="col-xs-5 col-md-2 first_img">
						<a href="#" onclick="javascript:step1()">
							<img src="assets/images/icon/y.png">
						</a>
						<h2 align="center">初次體驗</h2>
					</div>
					<div class="col-xs-6 col-md-2 first_img">
						<a href="quiz.php">
							<img src="assets/images/icon/n.png">
						</a>
						<h2>第二次測驗</h2>
					</div>
				</div>
			</div>
			
			<script>
				function step1(){
					document.getElementById('step1').style.display='none';
					document.getElementById('step2').style.display='block';
				}
			</script>
		
			<?php 
			require_once("mysql.php");
			
			$sql = "select * from userclass";
			$t = mysql_query($sql) or die( mysql_error()); ?>
			
			<!-- 第二步：抓取資料庫廠區欄(userClass_area) !-->
			
			<div id="step2" class="user_step" style="display:none">
				<div class="step_name">廠區選擇
					<button type="button" class="btn btn-default btn_up" onclick="javascript:up2()">上一步</button>
				</div>
				
				<div class="Option_margin_top">
					<?php 
					$sql_topic_grade = "select * from topic_grade where topicGrade_enable=0"; //撈啟用中的等級資料
					$sql_topicGrade=mysql_query($sql_topic_grade) or die( mysql_error());
					
					while ($s_topicGrade = mysql_fetch_array ($sql_topicGrade)){ 
						$gradeIndex[] = $s_topicGrade['fty_no']; 
					}
					
					$sql_areaFactory = "select * from factory where fty_enable=0 and fty_no!=0 and fty_no!=6"; //撈啟用中廠區資料
					$sql_area=mysql_query($sql_areaFactory) or die( mysql_error());
					
					while ($s_area = mysql_fetch_array ($sql_area)){
						if (in_array($s_area['fty_no'],$gradeIndex)){?>
							<div class="row col-xs-11 col-md-7">
								<button type="button" class="btn btn-primary btn-lg btn-block" onclick="javascript:step2(<?php echo $s_area['fty_no'];?>,'<?php echo $s_area['fty_na'];?>區')"><?php echo $s_area['fty_na']; ?></button>
								<br><br>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			</div>
			
			<script>
				function step2(area,area_na){
					document.getElementById('step2').style.display='none';
					document.getElementById('step3').style.display='block';
					s2=area;
					$('#event_name').html(area_na);
				}
				
				function up2(){
					document.getElementById('step1').style.display='block';
					document.getElementById('step2').style.display='none';
					s1='';
				}
			</script>

			<!-- 第三步：抓取資料庫性別欄(sex) !-->
			
			<div id="step3" class="user_step" style="display:none">
				<div class="step_name">性別選擇
					<button type="button" class="btn btn-default btn_up" onclick="javascript:up3()">上一步</button>
				</div>
				<div class="row Option_margin_top10">
					<div class="sex_img">
						<a href="#" onclick="javascript:step3(1)">
							<img src="assets/images/icon/男.png">
						</a>
					
						<a href="#" onclick="javascript:step3(2)">
							<img src="assets/images/icon/女.png">
						</a>
					</div>
				</div>
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			</div>
			
			<script>
				function step3(sex){
					document.getElementById('step3').style.display='none';
					document.getElementById('step4').style.display='block';
					s3=sex;
				}
				
				function up3(){
					document.getElementById('step2').style.display='block';
					document.getElementById('step3').style.display='none';
					s2='';
				}
			</script>
			
			<!-- 第四步：取資料庫年齡欄(old) !-->
			
			<div id="step4" class="user_step" style="display:none">
				<div class="step_name">年齡選擇
					<button type="button" class="btn btn-default btn_up" onclick="javascript:up4()">上一步</button>
				</div>
					<?php if(!isset($_GET['i_next'])){ ?>
					<SCRIPT LANGUAGE="JavaScript"> 
						s_width=screen.width;
						if ((s_width>=992))
						   { location.href='userNew.php?i_next=6';} //斷行用
						if ((s_width>=751) &&(s_width<=991))
						   { location.href='userNew.php?i_next=99';} //斷行用
						if (s_width<=750)
						   { location.href="userNew.php?i_next=99"; } //斷行用

					</SCRIPT> 
					<?php } ?>
					<?php
					$t=mysql_query($sql) or die( mysql_error()); 
					$i_old=1;
					while ($s = mysql_fetch_array ($t)){
						if($s['userClass_old']!=''){ ?>
							
							<?php if($i_old==1 or $i_old==$_GET['i_next']){ echo "<div class='row Option_margin_top else_img'>"; } ?>
							
								<a href="#" onclick="javascript:step4(<?php echo $s['userClass_no'];?>)">
									<img src="assets/images/icon/<?php echo $s['userClass_old'];?>.png">
								</a>
							
							<?php if($i_old==($_GET['i_next']-1) or $i_old==9){ echo "</div>"; } ?>
						<?php $i_old++;} ?>
					<?php } ?>
				<br><br><br><br><br>
			</div>
			
			<script>
				function step4(old){
					document.getElementById('step4').style.display='none';
					document.getElementById('step5').style.display='block';
					s4=old;
				}
				
				function up4(){
					document.getElementById('step3').style.display='block';
					document.getElementById('step4').style.display='none';
					s3='';
				}
			</script>
			
			<!-- 第五步：抓取資料庫教育程度欄(study) !-->
			
			<div id="step5" class="user_step" style="display:none;">
				<div class="step_name">教育程度
					<button type="button" class="btn btn-default btn_up" onclick="javascript:up5()">上一步</button>
				</div>
				<?php 
				$t=mysql_query($sql) or die( mysql_error());
				$i_study=1;
				while ($s = mysql_fetch_array ($t)){
					if($s['userClass_study']!=''){ ?>
						<?php if($i_study==1 or $i_study==$_GET['i_next']){ echo "<div class='row Option_margin_top else_img'>"; } ?>
						
							<a href="#" onclick="javascript:step5(<?php echo $s['userClass_no'];?>)">
								<img src="assets/images/icon/<?php echo $s['userClass_study'];?>.png">
							</a>
							
						<?php if($i_study==($_GET['i_next']-1) or $i_study==6){ echo "</div>"; } ?>
					<?php $i_study++;} ?>
				<?php } ?>
				<br><br><br><br><br><br><br><br><br>
			</div>
			
			<script>
				function step5(study){
					document.getElementById('step5').style.display='none';
					document.getElementById('step6').style.display='block';
					s5=study;
				}
				
				function up5(){
					document.getElementById('step4').style.display='block';
					document.getElementById('step5').style.display='none';
					s4='';
				}
			</script>
			
			<!-- 第六步：抓取資料庫服務單位欄(team) !-->
			
			<div id="step6" class="user_step" style="display:none">
				<div class="step_name">服務單位
					<button type="button" class="btn btn-default btn_up" onclick="javascript:up6()">上一步</button>
				</div>
				<?php 
				$t=mysql_query($sql) or die( mysql_error()); 
				$i_team=1;
				while ($s = mysql_fetch_array ($t)){
					if($s['userClass_team']!=''){ ?>
						<?php if($i_team==1 or $i_team==$_GET['i_next']){ echo "<div class='row Option_margin_top else_img'>"; } ?>
					
							<a href="#" onclick="javascript:step6(<?php echo $s['userClass_no'];?>)">
								<img src="assets/images/icon/<?php echo $s['userClass_team'];?>.png">
							</a>
							
						<?php if($i_team==($_GET['i_next']-1) or $i_team==7){ echo "</div>"; } ?>
					<?php $i_team++;} ?>
				<?php } ?>
				
				<br><br><br><br><br>
			</div>
			
			<script>
				function step6(team){
					document.getElementById('step6').style.display='none';
					document.getElementById('step7').style.display='block';
					s6=team;
				}
				
				function up6(){
					document.getElementById('step5').style.display='block';
					document.getElementById('step6').style.display='none';
					s5='';
				}
			</script>	
			
			<!-- 第七步：填寫Line ID !-->
			
			<div id="step7" class="user_step" style="display:none">
				<div class="step_name">Line ID
					<button type="button" class="btn btn-default btn_up" onclick="javascript:up7()">上一步</button>
				</div>
				<div class="row Option_line margin_left_5 col-md-2">
					<?php if(isset($_GET['lineID'])){ $lineID=$_GET['lineID'];}else{ $lineID="s80144659";}?>
					<input type="text" class="form-control" id="lineID" value="<?php echo $lineID;?>"></input>
					<h4 class="header" style="color:red">※ 非必填，不過我就不能 Line 著你囉！</h4>
					<button class="btn btn-default btn-lg" onclick="submit_info()">跳過</button>
					<button class="btn btn-primary btn-lg" onclick="submit_info()">送出</button>
				</div>
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			</div>
			
			<script>
				function submit_info(){
					s7=$("#lineID").val();
					window.location = 'userNew_res.php?area='+s2+'&sex='+s3+'&old='+s4+'&study='+s5+'&team='+s6+'&lineID='+s7;
				}
				
				function up7(){
					document.getElementById('step6').style.display='block';
					document.getElementById('step7').style.display='none';
					s7='';
				}
			</script>
		</div>
		<div id="go_index">
			<a href="index.php"><img height="45vh" src="assets/images/icon/回首頁.png"></a>
		</div>
	</body>
</html>