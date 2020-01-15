<!doctype html>
<html lang="en">

<head>
	<?php require_once("head.php");?>
	<?php require_once("chk_login.php");?>
	<?php require_once("js_file.php");?>
	<!-- jquery-ui 資源檔 (這兩個檔 require_once 會無效) -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>
  
<body>
<?php if(isset($_SESSION["chk"])){

	require_once('mysql.php');
	
	//檢查權限
	$sql_authority = "select * from authority where adminLv_no=".$_SESSION["adminLv_no"];
	$sql_LOA = mysql_query($sql_authority) or die(mysql_error());
	$s_LOA = mysql_fetch_assoc($sql_LOA);
	
	if ($s_LOA['analysisLOA']==0){ ?>
		<div class="wrapper">
			<script type="text/javascript">
			$(document).ready(function(){
			  $("li").removeClass("active");
			  $("li.analysis").addClass("active");
			}); 
			
			$(function(){
				//性別全選/全不選控制				
				$('#sex_all').change(function() {
					if($(this).is(':checked')) {
						$(".div_sex").addClass("checked"); //特效
						$('.sex').prop("checked", "checked"); //功能
					}else{
						$(".div_sex").removeClass('checked');
						$('.sex').removeAttr("checked");
					}
				});
							
				//選男、女時呼叫checkOrRemoveCheckAll()
				$(".div_sex").change(function(){
					checkOrRemoveCheckAll();
				});

				//年齡全選/全不選控制				
				$('#old_all').change(function() {
					if($(this).is(':checked')) {
						$(".div_old").addClass("checked");
						$('.old').prop("checked", "checked");
						
					}else{
						$(".div_old").removeClass('checked');
						$('.old').removeAttr("checked");
					}
				});
				
				//選0-7歲、8-12歲...時呼叫checkOrRemoveCheckAll()
				$(".div_old").change(function(){
					checkOrRemoveCheckAll();
				});
				
				//教育程度全選/全不選控制				
				$('#study_all').change(function() {
					if($(this).is(':checked')) {
						$(".div_study").addClass("checked");
						$('.study').prop("checked", "checked");
					}else{
						$(".div_study").removeClass('checked');
						$('.study').removeAttr("checked");
					}
				});
				
				//選國小、國中時呼叫checkOrRemoveCheckAll()				
				$(".div_study").change(function(){
					checkOrRemoveCheckAll();
				});
				
				//服務單位全選/全不選控制				
				$('#team_all').change(function() {
					if($(this).is(':checked')) {
						$(".div_team").addClass("checked");
						$('.team').prop("checked", "checked");
						
					}else{
						$(".div_team").removeClass('checked');
						$('.team').removeAttr("checked");
					}
				});
				
				//選公家機關、學術單位時呼叫checkOrRemoveCheckAll()				
				$(".div_team").change(function(){
					checkOrRemoveCheckAll();
				});
			  
			});

			function checkOrRemoveCheckAll(){
				if($('.sex:checked').length == $('.div_sex').length){
					$('.sex_all').addClass("checked"); //特效
					$('#sex_all').prop("checked", "checked"); //功能
				}else{
					$(".sex_all").removeClass('checked');
					$('#sex_all').removeAttr("checked");}
									
				if($('.old:checked').length == $('.div_old').length){
					$('.old_all').addClass("checked"); //特效
					$('#old_all').prop("checked", "checked"); //功能
				}else{
					$(".old_all").removeClass('checked');
					$('#old_all').removeAttr("checked");}

					
				if($('.study:checked').length == $('.div_study').length){
					$('.study_all').addClass("checked"); //特效
					$('#study_all').prop("checked", "checked"); //功能
				}else{
					$(".study_all").removeClass('checked');
					$('#study_all').removeAttr("checked");}
					
				if($('.team:checked').length == $('.div_team').length){
					$('.team_all').addClass("checked"); //特效
					$('#team_all').prop("checked", "checked"); //功能
				}else{
					$(".team_all").removeClass('checked');
					$('#team_all').removeAttr("checked");}
			}

		
			</script>
			
			<?php require_once("menu.php");?>

			<div class="main-panel"> 
				<?php
				$title="前後測分析";
				require_once("nav.php");
				require_once("mysql.php");
						
				$sql="select * from userclass";
				$t=mysql_query($sql) or die( mysql_error());
				
				?>
				<div class="content">
					<div class="container-fluid">
						<form method="get" name="ana_form" id="ana_form">
							<div class="row">
								<div class="col-md-6 col-lg-3 col-sm-6">
									<div class="card">
										<div class="content">
											<h5 class="title">廠區</h5>
											<div class="row">
												<div class="form-group">
													<div class="col-md-4 col-lg-8">
														<div class="radio">
															<?php if($_SESSION["adminLv_no"]==1){ ?>
																<input type='radio' value="0" name="area" id="area_all" checked>全部</input>
															<?php } ?>
														</div>
														<?php
														//抓取資料庫廠區欄   //注意：這是抓 factory 資料表
														$sql_factory="select * from factory where fty_enable=0 and fty_no!=0 and fty_no!=6 ";
														$sql_fty=mysql_query($sql_factory) or die( mysql_error());
														while ($s_fty = mysql_fetch_array ($sql_fty)){
															if(($_SESSION["adminLv_no"]!=1) and ($s_fty['fty_no']==$_SESSION["fty_no"])){ //如果不是super，只能看自己廠區
																echo "<div class='radio'>";
																echo "	<input type='radio' value='".$s_fty['fty_no']."' name='area'>".$s_fty['fty_na']."</input>";
																echo "</div>";
																break;
															}elseif($_SESSION["adminLv_no"]==1){ //如果不是super，只能看自己廠區
																echo "<div class='radio'>";
																echo "	<input type='radio' value='".$s_fty['fty_no']."' name='area'>".$s_fty['fty_na']."</input>";
																echo "</div>";
															}
														}
														
														?>		
													</div>
												</div>
											 </div>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-3 col-sm-6">
									<div class="card">
										<div class="content">
											<h5 class="title">性別</h5>
											<div class="row">
												<div class="form-group">
													<div class="col-md-4 col-lg-8">
														<div class="checkbox sex_all">
															<input type="checkbox" value="0" name="sex[]" id="sex_all">全部
														</div>
														<?php
															//抓取資料庫性別欄
															$t=mysql_query($sql) or die( mysql_error());
															while ($s = mysql_fetch_array ($t)){
																if($s['userClass_sex']!=''){	
																	echo "<div class='checkbox div_sex'>";
																	echo "	<input type='checkbox' value='".$s['userClass_no']."' name='sex[]' class='sex'>".$s['userClass_sex']."</input>";
																	echo "</div>";
																}
															}
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-12 col-sm-12">
									<div class="card">
										<div class="content">
											<h5 class="title">年齡</h5>
											<div class="row">
												<div class="form-group">										
													<div class="col-md-4 col-lg-4 col-sm-4">
														<div class="checkbox old_all">
															<input type="checkbox" name="old[]" value="0" id='old_all'>全部
														</div>
														
														<?php
															//抓取資料庫年齡欄
															$t=mysql_query($sql) or die( mysql_error());
															while ($s = mysql_fetch_array ($t)){
																if($s['userClass_old']!=''){
																	if ((($s['userClass_no']%4)==0) and ($s['userClass_no']!=1)) { echo "<div class='col-md-4 col-lg-4 col-sm-4'>"; } //每四個換一列 (開頭div)
																	echo "<div class='checkbox div_old' >";
																	echo "	<input type='checkbox' value='".$s['userClass_no']."' name='old[]' class='old'>".$s['userClass_old'];
																	echo "</div>";
																	if (($s['userClass_no']%4)==3){ echo "</div>"; } //每四個換一列 (結尾div)
																}
															}
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="card">
										<div class="content">
											<h5 class="title">教育程度</h5>
											<div class="row">
												<div class="form-group">										
													<div class="col-md-3 col-lg-3 col-sm-3">
														<div class="checkbox study_all">
															<input type="checkbox" name="study[]" value="0" id='study_all'>全部
														</div>
														<?php
															//抓取資料庫教育程度欄
															$t=mysql_query($sql) or die( mysql_error());
															while ($s = mysql_fetch_array ($t)){
																if($s['userClass_study']!=''){
																	if ((($s['userClass_no']%2)==0) and ($s['userClass_no']!=1)) { echo "<div class='col-md-3 col-lg-3 col-sm-3'>"; } //每兩個換一列 (開頭div)
																	echo "<div class='checkbox div_study'>";
																	echo "	<input type='checkbox' value='".$s['userClass_no']."' name='study[]' class='study'>".$s['userClass_study'];
																	echo "</div>";
																	if (($s['userClass_no']%2)==1){ echo "</div>"; } //每兩個換一列 (結尾div)
																}
															}
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="card">
										<div class="content">
											<h5 class="title">服務單位</h5>
											<div class="row">
												<div class="form-group">										
													<div class="col-md-3 col-lg-3 col-sm-3">
														<div class="checkbox team_all">
															<input type="checkbox" name="team[]" value="0" id='team_all'>全部
														</div>
														<?php
															//抓取資料庫教育程度欄
															$t=mysql_query($sql) or die( mysql_error());
															while ($s = mysql_fetch_array ($t)){
																if($s['userClass_team']!=''){
																	if ((($s['userClass_no']%2)==0) and ($s['userClass_no']!=1)) { echo "<div class='col-md-3 col-lg-3 col-sm-3'>"; } //每兩個換一列 (開頭div)
																	echo "<div class='checkbox div_team'>";
																	echo "	<input type='checkbox' value='".$s['userClass_no']."' name='team[]' class='team'>".$s['userClass_team'];
																	echo "</div>";
																	if (($s['userClass_no']%2)==1){ echo "</div>"; } //每兩個換一列 (結尾div)
																}
															}
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<script type="text/javascript">
								
								$(function() {
									$( "#date_start" ).datepicker({
									dateFormat : "yy/mm/dd",
									monthNamesShort: [ "一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月" ],
									dayNamesMin: [ "日","一","二","三","四","五","六" ],
									changeMonth : true,
									changeYear : true,
									onClose: function( selectedDate ) {
										$( "#date_end" ).datepicker( "option", "minDate", selectedDate );
									}
									});

									$( "#date_end" ).datepicker({
									dateFormat : "yy/mm/dd",
									monthNamesShort: [ "一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月" ],
									dayNamesMin: [ "日","一","二","三","四","五","六" ],
									changeMonth : true,
									changeYear : true,
									onClose: function( selectedDate ) {
										$( "#date_start" ).datepicker( "option", "maxDate", selectedDate );
									}
									});
								});
								</script>

								<?php
								
								//先取得今日日期
								$tw_date = new DateTime("now");
								$tw_date->modify("-6 month"); //再減6個月
								
								
								//抓使用者選擇的時間範圍 (沒抓到預設全部)
								if (isset($_GET['date_start']) and isset($_GET['date_end'])){
									$date_start = str_replace('/','',$_GET['date_start']).'000000';
									$date_end = str_replace('/','',$_GET['date_end']).'999999';
									$dateChoice = 'and user_time >= '.$date_start.' and user_time <= '.$date_end ;
								}else{
									$dateChoice = 'and user_time >= '.$tw_date->format("Ymd000000");} //選擇近6個月資料	
									
								?> 
								
								<div class="row">
								    <div class="col-lg-12 col-md-12">
										<div class="card">									
											<div class="content">
												<div class="row">
													<div class="col-sm-8">
														<h5 class="title">日期範圍</h5><br>
														<?php 
												
														$date_start = $tw_date->format("Y/m/d"); //預設六個月前
														$date_end =  date('Y/m/d'); //今日 ?>
														
														<div class="row">
															<div class="col-sm-12">
																<div class="col-sm-4"  >
																	<div class="col-sm-11">
																		<input type="text" class="form-control border-input" name="date_start" id='date_start' value="<?php echo $date_start;?>" required>
																	</div>
																	至
																</div>
																<div class="col-sm-4">
																	<div class="col-sm-11">
																		<input type="text" class="form-control border-input" name="date_end" id='date_end' value="<?php echo $date_end;?>" required>
																	</div>
																	止
																</div>
															</div>
														</div>	
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							<div class="row">
								<center><input type="button" class="btn btn-info btn-fill btn-wd btn_search" value="查詢" onclick="checkForm()"></center>
								<script>
								function checkForm(){
									check_notice='';
									if($('input[class="sex"]:checked').length ==0){
										check_notice=check_notice+'請勾選「性別」欄位\n';
									}
									if($('input[class="study"]:checked').length ==0){
										check_notice=check_notice+'請勾選「教育程度」欄位\n';
									}
									if($('input[class="old"]:checked').length ==0){
										check_notice=check_notice+'請勾選「年齡」欄位\n';
									}
									if($('input[class="team"]:checked').length ==0){
										check_notice=check_notice+'請勾選「服務單位」欄位\n';
									}
									
									//去除字符串首尾空格
									String.prototype.trim = function(){
										return this.replace(/(^\s*)|(\s*$)/g, "");
									}
										
									
									//驗證是否日期
									if(isDate(document.all.date_start.value.trim())==false){
											document.all.date_start.select();
											return ;
									}
									if(isDate(document.all.date_end.value.trim())==false){
										document.all.date_end.select();
										return ;
									}
									
									if(!check_notice){
										ana_form.submit();
									
									}else{
										alert(check_notice);
									}
									
									
									/**  斷輸入框中輸入的日期格式是否為 yyyy-mm-dd 或 yyyy-m-d  */  
									
									function isDate(dateString){
										if(dateString.trim()==""){ };
										
										//年月日正規表達式
										var r=dateString.match(/^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/); 
										if(r==null){
											alert("日期格式錯誤");
											return false;
										}
										
										var d=new Date(r[1],r[3]-1,r[4]);   
										var num = (d.getFullYear()==r[1]&&(d.getMonth()+1)==r[3]&&d.getDate()==r[4]);
										
										if(num==0){
											alert("日期格式錯誤");
										}
										return (num!=0);
									}
								}
								</script>
							</div>
							<br>   
						</form>						
						<div class="col-lg-12 col-md-12 col-sm-12" id="reChoose" style="display:none" >
							<div class="card">
								<div class="content">
									<a href="analysis.php"><center><input type="button" class="btn btn-info btn-fill btn-wd" value="重新選擇"></center></a>
								</div>
							</div>
						</div>
						<?php if(isset($_GET['old'])){  ?>
						<div class="container-fluid">
							<script type="text/javascript">
								//一開始載入
								$('#ana_form').hide();
								$('.btn_search').hide();
								$('#reChoose').show();
							</script>
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<div class="card">
										<div class="content">
											<div class="row">
												<div class="form-group">										
													<div class="col-md-12 col-sm-12">

														<?php
														$area=$_GET['area'];
														$old = $_GET['old']; 
														$study = $_GET['study'];
														$sex = $_GET['sex'];
														$team = $_GET['team'];
														$sel='';
														
														require_once("mysql.php");
														
														//-------------------------------------------------------------------------------------------//
														//長條圖資料
														
														if ($area!=0){ 
														
															$sel=$sel." and fty_no=".$area;   //如果area不等於0 表示area有被選到-全部-以外的條件 所以要加入判斷	
														
															//撈出廠區類別 (選個別廠區才有效)
															$sql_area_grade="select * from topic_grade where fty_no=$area";
															$sql_grade=mysql_query($sql_area_grade) or die( mysql_error());
															
															//類別篩選
															echo "<center>依類別篩選：&nbsp;&nbsp;";
															
															if((!isset($_GET['topicGrade_no'])) and (!isset($_GET['amount']))){ 
																$_SESSION['url']=$_SERVER['REQUEST_URI']; } //先把初步篩選(不含類別/題目數的)網址紀錄起來
															
															while ($s_grade = mysql_fetch_array ($sql_grade)){
																echo "<a href='".$_SERVER['REQUEST_URI']."&topicGrade_no=".$s_grade['topicGrade_no']."&topicGrade_na=".$s_grade['topicGrade_na']."'><button class='btn btn-danger btn-fill'>".$s_grade['topicGrade_na']."</button></a>&nbsp;";}
															
															//出題數篩選
															echo "&nbsp;&nbsp;&nbsp;&nbsp;出題數：&nbsp;&nbsp;";
															
															$sql_Grade_amount="select * from user where fty_no=$area and user_amount!=0 group by user_amount";
															$sql_amount=mysql_query($sql_Grade_amount) or die( mysql_error());
															while ($s_amount = mysql_fetch_array ($sql_amount)){ 																
																echo "<a href=".$_SERVER['REQUEST_URI']."&amount=".$s_amount['user_amount']."><button class='btn btn-danger btn-fill'>".$s_amount['user_amount']."</button></a>&nbsp;";
															} 
															
															echo "&nbsp;&nbsp;<a href='".$_SESSION['url']."'><button class='btn btn-info btn-fill '>清除</button></a>&nbsp;";
															echo "</center>";
															
														}else{  //選全部廠區時
															
															if(!isset($_GET['amount'])){ 
																$_SESSION['url']=$_SERVER['REQUEST_URI']; } //先把初步篩選(不含類別/題目數的)網址紀錄起來
																
															echo "<center>&nbsp;&nbsp;&nbsp;&nbsp;出題數：&nbsp;&nbsp;";
															
															$sql_Grade_amount="select * from user where user_amount!=0 group by user_amount";
															$sql_amount=mysql_query($sql_Grade_amount) or die( mysql_error());
															while ($s_amount = mysql_fetch_array ($sql_amount)){ 																
																echo "<a href=".$_SESSION['url']."&amount=".$s_amount['user_amount']."><button class='btn btn-danger btn-fill'>".$s_amount['user_amount']."</button></a>&nbsp;";
																		
															} 
															
															echo "<a href='".$_SESSION['url']."'><button class='btn btn-info btn-fill '>清除</button></a>&nbsp;";
															echo "</center>";
														}												
														
														if (!in_array('0',$old)){ $old=implode(" or user_old=", $old); $sel=$sel." and ( user_old=".$old.") ";}		
														if (!in_array('0',$study)){ $study=implode(" or user_study=", $study); $sel=$sel." and ( user_study=".$study.") ";} 
														if (!in_array('0',$sex)){ $sex = implode(" or user_sex=", $sex); $sel=$sel." and ( user_sex=".$sex.") ";}
														if (!in_array('0',$team)){ $team = implode(" or user_team=", $team); $sel=$sel." and ( user_team=".$team.") ";}
														
														if (isset($_GET['topicGrade_no'])){ $sel=$sel." and topicGrade_no=".$_GET['topicGrade_no'];}
														if (isset($_GET['amount'])){ $sel=$sel." and user_amount=".$_GET['amount'];}
													 														
														$sql_1= "select user_test1,count(user_test1) from user where user_test1>=0 and user_test2>=0  $sel $dateChoice group by user_test1";
														$sql_2= "select user_test2,count(user_test2) from user where user_test1>=0 and user_test2>=0  $sel $dateChoice group by user_test2";
														
														//echo $sql_1."<br><br>";
														//echo $sql_2;
																												
														$t1=mysql_query($sql_1) or die( mysql_error());
														$t2=mysql_query($sql_2) or die( mysql_error());
														
														$t1_nums=mysql_num_rows($t1);
														$t2_nums=mysql_num_rows($t2);
														
														if(($t1_nums!=0)and($t2_nums!=0)){ //有資料才製作圖表
															
															
															$area=$_GET['area'];
															
															if ($area!=0){ 
																
																//撈出所有廠區
																$areaSelect="where fty_no=".$area;
																$sql_areaSelect="select * from factory $areaSelect";
																$sql_areaSel=mysql_query($sql_areaSelect) or die( mysql_error());
																while ($s_areaSel = mysql_fetch_array ($sql_areaSel)){
																	$area=$s_areaSel['fty_na'];
																}																
															}
															
															elseif ($area==0){$area='全部廠區';} ?>
														
															<div class="header">
																<h4 class="title" align="center">前後測試統計圖 - <?php echo $area;?><?php if(isset($_GET['topicGrade_na'])){echo " - ".$_GET['topicGrade_na'];}?><?php if(isset($_GET['amount'])){echo " - 出 ".$_GET['amount']." 題 ";}?></h4>
															</div>
															<div id="bar-chart"></div><br><br><br><br>
															
															<div class="header">
																<h4 class="title" align="center">性別分佈</h4>
																<div id="pie-chart1"></div>
																<h4 class="title" align="center">年齡分佈</h4>
																<div id="pie-chart2"></div>
																<h4 class="title" align="center">教育程度</h4>
																<div id="pie-chart3"></div>
																<h4 class="title" align="center">服務單位</h4>
																<div id="pie-chart4"></div>
															</div>
															
													
															<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
															<script src='https://www.google.com/jsapi'></script>
															
															<?php															
															//初始化
																
															$test1_total=array();  //產生陣列															
															$test2_total=array();  
																		
															while ($s1 = mysql_fetch_array ($t1)){
																$test1_total[$s1['user_test1']]=$s1['count(user_test1)'];  //抓答對題目量
															}
															while ($s2 = mysql_fetch_array ($t2)){
																$test2_total[$s2['user_test2']]=$s2['count(user_test2)'];
															} 
																														
															//取最大答對數
															$max_quiz=max(max(array_keys($test2_total)),max(array_keys($test1_total)));
															
															//每筆資料存放處
															$chart_data='';
															
															for($i=0;$i<=$max_quiz;$i++){
																if (!isset($test1_total[$i])){ $test1_total[$i]=0; }
																if (!isset($test2_total[$i])){ $test2_total[$i]=0; }
																	
																$chart_data=$chart_data.",['".$i."',".$test1_total[$i].",".$test2_total[$i]."]"; } 
																
															
															//-------------------------------------------------------------------------------------------//
															//圓餅圖
																														
															$select_sex='';$select_old='';$select_study='';$select_team='';
															
															//額外篩選才要額外下sql
															if (isset($_GET['topicGrade_no'])){ $select_sex=$select_sex." and topicGrade_no=".$_GET['topicGrade_no'];}
															if (isset($_GET['topicGrade_no'])){ $select_old=$select_old." and topicGrade_no=".$_GET['topicGrade_no'];}
															if (isset($_GET['topicGrade_no'])){ $select_study=$select_study." and topicGrade_no=".$_GET['topicGrade_no'];}
															if (isset($_GET['topicGrade_no'])){ $select_team=$select_team." and topicGrade_no=".$_GET['topicGrade_no'];}
															
															if (isset($_GET['amount'])){ $select_sex=$select_sex." and user_amount=".$_GET['amount'];}
															if (isset($_GET['amount'])){ $select_old=$select_old." and user_amount=".$_GET['amount'];}
															if (isset($_GET['amount'])){ $select_study=$select_study." and user_amount=".$_GET['amount'];}
															if (isset($_GET['amount'])){ $select_team=$select_team." and user_amount=".$_GET['amount'];}

															if(!isset($_GET['topicGrade_no']) and !isset($_GET['amount'])){ }
															
															$sql_sex= "select user_sex,count(user_sex) from user where user_test1>=0 and user_test2>=0 $select_sex $sel $dateChoice group by user_sex";
															$sql_old= "select user_old,count(user_old) from user where user_test1>=0 and user_test2>=0 $select_old $sel $dateChoice group by user_old";
															$sql_study= "select user_study,count(user_study) from user where user_test1>=0 and user_test2>=0 $select_study $sel $dateChoice group by user_study";
															$sql_team= "select user_team,count(user_team) from user where user_test1>=0 and user_test2>=0 $select_team $sel $dateChoice group by user_team";
															
															//echo $sql_sex;
															//echo $sql_old;
															//echo $sql_study;
															//echo $sql_team;
															
															$sex_1=mysql_query($sql_sex) or die( mysql_error());
															$old_1=mysql_query($sql_old) or die( mysql_error());
															$study_1=mysql_query($sql_study) or die( mysql_error());
															$team_1=mysql_query($sql_team) or die( mysql_error());

															//初始化
																
															$sex_total=array();  //產生陣列
															$sex=array();

															$j=0;
																		
															while ($sex_2 = mysql_fetch_array ($sex_1)){

																$sex_total[$j]=$sex_2['count(user_sex)']; //抓總性別
																switch ($sex_2['user_sex'])
																{
																	case 1:
																	  $sex[$j] = '男';
																	  break; 
																	case 2:
																	  $sex[$j] = '女';
																	  break; 
																}
																 
																$j++;
																	
															}
																
															$old_total=array();  //產生陣列
															$old=array();
															
															$w=0;
															
															while ($old_2 = mysql_fetch_array ($old_1)){

																$old_total[$w]=$old_2['count(user_old)']; //抓總年齡
																switch ($old_2['user_old'])
																{
																	case 1:
																	  $old[$w] = '0-7歲';
																	  break; 
																	case 2:
																	  $old[$w] = '8-12歲';
																	  break; 
																	case 3:
																	  $old[$w] = '13-20歲';
																	  break; 
																	case 4:
																	  $old[$w] = '21-30歲';
																	  break; 
																	case 5:
																	  $old[$w] = '31-40歲';
																	  break;
																	case 6:
																	  $old[$w] = '41-50歲';
																	  break;
																	case 7:
																	  $old[$w] = '51-60歲';
																	  break; 
																	case 8:
																	  $old[$w] = '61-70歲';
																	  break; 
																	case 9:
																	  $old[$w] = '71歲以上';
																	  break; 
																	 
																	
																}
																
																$w++;
																				
															}
															
															$study_total=array();  //產生陣列
															$study=array();

															$j=0;
																		
															while ($study_2 = mysql_fetch_array ($study_1)){

																$study_total[$j]=$study_2['count(user_study)']; //抓總教育程度
																switch ($study_2['user_study'])
																{
																	case 1:
																	  $study[$j] = '幼稚園以下';
																	  break; 
																	case 2:
																	  $study[$j] = '國小';
																	  break; 
																	case 3:
																	  $study[$j] = '國中';
																	  break; 
																	case 4:
																	  $study[$j] = '高中';
																	  break; 
																	case 5:
																	  $study[$j] = '大學';
																	  break; 
																	case 6:
																	  $study[$j] = '研究所以上';
																	  break; 
																}
																 
																$j++;
																
															} 
															
															$team_total=array();  //產生陣列
															$team=array();

															$e=0;
															
															while ($team_2 = mysql_fetch_array ($team_1)){
																
																$team_total[$e]=$team_2['count(user_team)']; //抓總服務單位
																switch ($team_2['user_team'])
																{
																	case 1:
																	  $team[$e] = '學術單位';
																	  break; 
																	case 2:
																	  $team[$e] = '公家機關';
																	  break; 
																	case 3:
																	  $team[$e] = '民間企業';
																	  break; 
																	case 4:
																	  $team[$e] = '公益團體';
																	  break; 
																	case 5:
																	  $team[$e] = '組織';
																	  break; 
																	case 6:
																	  $team[$e] = '社團';
																	  break; 
																	case 7:
																	  $team[$e] = '其他';
																	  break; 
																}
																 
																$e++;
																
															} 
															
															$sexPie_data=''; //資料先設為空
															
															foreach($sex as $key => $value ){  //$sex=年齡中文欄位
																if (!isset($sex_total[$key])){ $sex_total[$key]=0; }
																		
																if ($key!=6){ //資料格式整理
																	$sexPie_data=$sexPie_data."['".$value."',".$sex_total[$key]."],";
																}else{
																	$sexPie_data=$sexPie_data."['".$value."',".$sex_total[$key]."]";
																}
															} 
															
															$oldPie_data=''; //資料先設為空
															
															foreach($old as $key => $value ){  //$old=年齡中文欄位
																if (!isset($old_total[$key])){ $old_total[$key]=0; }
																		
																if ($key!=6){ //資料格式整理
																	$oldPie_data=$oldPie_data."['".$value."',".$old_total[$key]."],";
																}else{
																	$oldPie_data=$oldPie_data."['".$value."',".$old_total[$key]."]";
																}
															} 
															
															$studyPie_data=''; //資料先設為空
															
															foreach($study as $key => $value ){  //$study=教育程度中文欄位
																if (!isset($study_total[$key])){ $study_total[$key]=0; }
																		
																if ($key!=6){ //資料格式整理
																	$studyPie_data=$studyPie_data."['".$value."',".$study_total[$key]."],";
																}else{
																	$studyPie_data=$studyPie_data."['".$value."',".$study_total[$key]."]";
																}
															} 
															
															$teamPie_data=''; //資料先設為空
															foreach($team as $key => $value ){  //$team=服務單位中文欄位
																if (!isset($team_total[$key])){ $team_total[$key]=0; }
																		
																if ($key!=6){ //資料格式整理
																	$teamPie_data=$teamPie_data."['".$value."',".$team_total[$key]."],";
																}else{
																	$teamPie_data=$teamPie_data."['".$value."',".$team_total[$key]."]";
																}
															} 
															
															
															
															?>												
																
															<script type="text/javascript">
																google.load("visualization", "1", {packages:["corechart"]});
																google.setOnLoadCallback(drawCharts);
																
																function drawCharts() {
																  
																  // BEGIN BAR CHART
																  /*
																  // create zero data so the bars will 'grow'
																  var barZeroData = google.visualization.arrayToDataTable([
																	['Day', 'Page Views', 'Unique Views'],
																	['Sun',  0,      0],
																	['Mon',  0,      0],
																	['Tue',  0,      0],
																	['Wed',  0,      0],
																	['Thu',  0,      0],
																	['Fri',  0,      0],
																	['Sat',  0,      0]
																  ]);
																	*/
																  // actual bar chart data
																  
																	
																	var barData = google.visualization.arrayToDataTable([
																		['題數', '前測', '後測']
																		<?php echo $chart_data; ?>
																	]);
																	 
																	// set bar chart options
																	var barOptions = {
																		focusTarget: 'category',
																		backgroundColor: 'transparent',
																		colors: ['#A5C8EF', '#FFCC2D'],
																		fontName: 'Open Sans',
																		chartArea: {
																			left: 50,
																			right:80,
																			top: 10,
																			width: '100%',
																			height: '80%'
																		},
																		
																		bar: {
																			groupWidth: '80%'
																		},
																		
																		hAxis: {title:'正確題數',
																			textStyle: {
																				fontSize: 12
																			},
																			
																		},
																		
																		vAxis: {
																			title:'人數',
																			textStyle: {
																				fontSize: 12
																			},
																		
																			minValue: 0,
																			baselineColor: '#DDD',
																			gridlines: {
																				color: '#DDD',
																				count: 4
																			}
																		},
																		
																		legend: {
																			textStyle: {
																				fontSize: 12
																			}
																		},
																		
																		animation: {
																			duration: 1200,
																			easing: 'out',
																			startup: true
																		}
																	  };
																	  
																	// draw bar chart twice so it animates
																	var barChart = new google.visualization.ColumnChart(document.getElementById('bar-chart'));
																	//barChart.draw(barZeroData, barOptions);
																	barChart.draw(barData, barOptions);
																	  
																	  
																	  
																	// BEGIN PIE CHART
																	  
																	// pie chart data
																	var pieData1 = google.visualization.arrayToDataTable([
																		['性別', '人數總和'],
																		<?php echo $sexPie_data; ?>
																	]);
																	
																	var pieData2 = google.visualization.arrayToDataTable([
																		['年齡', '人數總和'],
																		<?php echo $oldPie_data; ?>
																	]);
																	
																	var pieData3 = google.visualization.arrayToDataTable([
																		['教育程度', '人數總和'],
																		<?php echo $studyPie_data; ?>
																	]);
																	
																	var pieData4 = google.visualization.arrayToDataTable([
																		['服務單位', '人數總和'],
																		<?php echo $teamPie_data; ?>
																	]);
																	  
																	// pie chart options
																	var pieOptions = {
																		backgroundColor: 'transparent',
																		pieHole: 0.4,
																		colors: [ "#A5C8EF", 
																				  "#FFCC2D", 
																				  "#9EDA77", 
																				  "#FCA7A7", 
																				  "#FF8F56", 
																				  "#FB5660", 
																				  "turquoise", 
																				  "forestgreen", 
																				  "navy", 
																				  "gray"],
																		pieSliceText: 'value',
																		
																		tooltip: {
																			text: 'percentage'
																		},
																		
																		fontName: 'Open Sans',
																		
																		chartArea: {
																			width: '100%',
																			height: '94%'
																		},
																		
																		legend: {
																			textStyle: {
																				fontSize: 15
																			}
																		}
																	};
																	// draw pie chart
																	var pieChart = new google.visualization.PieChart(document.getElementById('pie-chart1'));
																	pieChart.draw(pieData1, pieOptions);
																	
																	var pieChart = new google.visualization.PieChart(document.getElementById('pie-chart2'));
																	pieChart.draw(pieData2, pieOptions);
																	
																	var pieChart = new google.visualization.PieChart(document.getElementById('pie-chart3'));
																	pieChart.draw(pieData3, pieOptions);
																	
																	var pieChart = new google.visualization.PieChart(document.getElementById('pie-chart4'));
																	pieChart.draw(pieData4, pieOptions);
																}
															</script>
														<?php }else{ echo "<h1 align='center'>查無資料，請重新選擇<h5>"; } ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	<?php 
	}else{  
		echo "<script>alert('您無此權限！麻煩您重新操作一次'); location.href='index_admin.php'</script>";
	} 
} 
?>
</body>
</html>
