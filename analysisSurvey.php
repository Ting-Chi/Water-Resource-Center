<!doctype html>
<html lang="en">

<head>
	<?php require_once("head.php");?>
	<?php require_once("chk_login.php");?>
	<?php require_once("js_file.php");?>
	
	<link rel="stylesheet" href="assets/css/easypiechart.css"/>
	
	<!-- jquery-ui 資源檔 (這兩個檔 require_once 會無效) -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<?php if(isset($_SESSION["chk"])){ //檢查是否登入
	
	require_once('mysql.php'); 
	
	//檢查權限
	$sql_authority = "select * from authority where adminLv_no=".$_SESSION["adminLv_no"];
	$sql_LOA = mysql_query($sql_authority) or die(mysql_error());
	$s_LOA = mysql_fetch_assoc($sql_LOA);
	
	if ($s_LOA['surveyLOA']==0){ ?>
		<div class="wrapper">
			<script type="text/javascript">
			$(document).ready(function(){
			  $("li").removeClass("active");
			  $("li.submenu").addClass("active");
			}); 
			
			
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
			
			<?php require_once("menu.php");?>
			

			<div class="main-panel">
				<?php
				$title="問卷分析";
				require_once("nav.php");
				
				//先取得今日日期
				$tw_date = new DateTime("now");
				$tw_date->modify("-6 month"); //再減6個月
				
				
				//抓使用者選擇的時間範圍 (沒抓到預設全部)
				if (isset($_GET['date_start']) and isset($_GET['date_end'])){
					$date_start = str_replace('/','',$_GET['date_start']).'000000';
					$date_end = str_replace('/','',$_GET['date_end']).'999999';
					$dateChoice = 'and survey_time >= '.$date_start.' and survey_time <= '.$date_end ;
				}else{
					$dateChoice = 'and survey_time >= '.$tw_date->format("Ymd000000");} //選擇近6個月資料	
					
					
				?> 
				
				<div class="content">
					<div class="container-fluid">
						<form method="get" name="date_form" action="analysisSurvey.php">
							<div class="row">
							   <div class="col-lg-12 col-md-12">
									<div class="card">									
										<div class="content">
											<div class="row">
												<div class="col-sm-3">
													<h4 class="title" align="">選擇廠區</h4><br>
													<div class="form-group">
														<select class="form-control border-input" name="factory">
															<?php 
															//撈出啟用中的廠區 (如果不是super，只能看自己廠區)
															if($_SESSION["adminLv_no"]==1){
																$sql_factory = "select * from factory where fty_enable=0 and fty_no!=0";
															}else{
																$sql_factory = "select * from factory where fty_no=".$_SESSION["fty_no"];}
																
															$sql_fty = mysql_query($sql_factory) or die(mysql_error());
															
															while($s_fty = mysql_fetch_assoc($sql_fty)){
																if (isset($_GET['factory'])){  //如果廠區存在(表示user已選廠區or日期)才記住使用者選的廠區&日期
																	if ($_GET['factory']==$s_fty['fty_no']){
																		echo "<option value='".$s_fty['fty_no']."' selected>".$s_fty['fty_na']."</option>"; 
																	}else{
																		echo "<option value='".$s_fty['fty_no']."'>".$s_fty['fty_na']."</option>";
																	}
																}else{
																	echo "<option value='".$s_fty['fty_no']."'>".$s_fty['fty_na']."</option>";
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="col-sm-8">
													<h4 class="title" align="">日期範圍</h4><br>
													<?php 
											
													//判斷使用者有沒有填起始時間
													if(isset($date_start)){ 
														$date_start = substr($date_start, 0, 4).'/'.substr($date_start, 4, 2).'/'.substr($date_start, 6, 2); //有設定，轉換成 yyyy/mm/dd 格式	
													}else{
														$date_start = $tw_date->format("Y/m/d"); } //沒有設定，就用我們預設的	
													
													//判斷使用者有沒有填結束時間					
													if(!isset($date_end)){
														$date_end =  date('Y/m/d'); 
													}else{ 
														$date_end = substr($date_end, 0, 4).'/'.substr($date_end, 4, 2).'/'.substr($date_end, 6, 2); } ?>
													
													<div class="row">
														<div class="col-sm-12">
															<div class="col-sm-4"  >
																<div class="col-sm-11">
																	<input type="text" class="form-control border-input" name="date_start" id='date_start' value="<?php if (isset($_GET['date_start'])){ echo $_GET['date_start']; }else{ echo $date_start; }?>" required>
																</div>
																至
															</div>
															<div class="col-sm-4">
																<div class="col-sm-11">
																	<input type="text" class="form-control border-input" name="date_end" id='date_end' value="<?php if (isset($_GET['date_end'])){ echo $_GET['date_end']; }else{ echo $date_end; } ?>" required>
																</div>
																止
															</div>
															<input type="button" class="btn btn-info btn-md" value="送出" onclick="validator()">
														</div>
													</div>	
													<script>
														//去除字符串首尾空格
														String.prototype.trim = function(){
															return this.replace(/(^\s*)|(\s*$)/g, "");
														}
															
														//驗證是否日期
														function validator(){
															if(isDate(document.all.date_start.value.trim())==false){
																document.all.date_start.select();
																return ;
															}
															
															if(isDate(document.all.date_end.value.trim())==false){
																document.all.date_end.select();
																return ;
															}
															date_form.submit();
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
													</script>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						
							<div class="row">
								<div id="main" class="col-sm-offset-1 col-sm-10">
									<?php 
									if(isset($_GET['factory'])){
										$factory=$_GET['factory'];
										
										//撈出回答的資料
										$sql="select survey_time,surveytopic_aid,fty_no,survey_score,count(survey_score) from survey where surveytopic_aid>0 and fty_no=$factory $dateChoice group by surveytopic_aid,survey_score";//每筆回答數據
										$U =mysql_query($sql) or die(mysql_error());

										$i=1; //表示目前正在處理第x題
										$count=0; //累計該題($now)的回答總數
										
										//抓出此廠區最後一題的題號
										$sql_minMaxQuizNo="select min(surveytopic_aid),max(surveytopic_aid) from surveytopic where fty_no=$factory ";
										$s_minMaxQuizNo =mysql_query($sql_minMaxQuizNo) or die(mysql_error());

										while ($minMaxQuizNo=mysql_fetch_assoc($s_minMaxQuizNo)){ 
											$min_QuizNo = $minMaxQuizNo['min(surveytopic_aid)']; 
											$max_QuizNo = $minMaxQuizNo['max(surveytopic_aid)'];
										}

										$now=$min_QuizNo ; //目前處理的是第幾題
													
										//撈出資料並計算
										while ($s=mysql_fetch_assoc($U)){

											if (($now!=$s['surveytopic_aid'])and($now<$s['surveytopic_aid'])){ 
												
												$quizTotal[$i]=$count; //將回答總數存入陣列

												//各滿意度百分比計算
												if (isset($partTotal[$i][1])){$p[$i][1]=round(($partTotal[$i][1]/$quizTotal[$i])*100);} else {$p[$i][1]=0;} //如果存在，就計算百分比(5分的筆數/該題總數)，反之為0
												if (isset($partTotal[$i][2])){$p[$i][2]=round(($partTotal[$i][2]/$quizTotal[$i])*100);} else {$p[$i][2]=0;}
												if (isset($partTotal[$i][3])){$p[$i][3]=round(($partTotal[$i][3]/$quizTotal[$i])*100);} else {$p[$i][3]=0;}
												if (isset($partTotal[$i][4])){$p[$i][4]=round(($partTotal[$i][4]/$quizTotal[$i])*100);} else {$p[$i][4]=0;}
												if (isset($partTotal[$i][5])){$p[$i][5]=round(($partTotal[$i][5]/$quizTotal[$i])*100);} else {$p[$i][5]=0;} //如果存在，就計算百分比(1分的筆數/該題總數)，反之為0
												$i++;$count=0; //歸零以計算下一題的回答總數
												$now=$s['surveytopic_aid']; //確保now真的在目前處理的題號
											}
											
											switch ($s['survey_score']){
												
												case 5:
												$partTotal[$i][5]=$s['count(survey_score)']; //5分的筆數存入陣列
												break; 
												
												case 4:
												$partTotal[$i][4]=$s['count(survey_score)'];
												break; 
												
												case 3:
												$partTotal[$i][3]=$s['count(survey_score)'];
												break; 
												
												case 2:
												$partTotal[$i][2]=$s['count(survey_score)'];
												break; 
												
												case 1:
												$partTotal[$i][1]=$s['count(survey_score)']; //1分的筆數存入陣列
												break;
											}		

											$count+=$s['count(survey_score)'];

										}
										
										//計算最後一題的滿意度分析
										if ($now==$max_QuizNo){
												
												$quizTotal[$i]=$count; //將回答總數存入陣列
												
												//各滿意度百分比計算
												if (isset($partTotal[$i][1])){$p[$i][1]=round(($partTotal[$i][1]/$quizTotal[$i])*100);} else {$p[$i][1]=0;}
												if (isset($partTotal[$i][2])){$p[$i][2]=round(($partTotal[$i][2]/$quizTotal[$i])*100);} else {$p[$i][2]=0;}
												if (isset($partTotal[$i][3])){$p[$i][3]=round(($partTotal[$i][3]/$quizTotal[$i])*100);} else {$p[$i][3]=0;}
												if (isset($partTotal[$i][4])){$p[$i][4]=round(($partTotal[$i][4]/$quizTotal[$i])*100);} else {$p[$i][4]=0;}
												if (isset($partTotal[$i][5])){$p[$i][5]=round(($partTotal[$i][5]/$quizTotal[$i])*100);} else {$p[$i][5]=0;}
										}
										
										////////////////////////////////////////////////////////////////////////////////////////
										
										//撈出回答的資料
										$sql="select survey_time,surveytopic_aid,fty_no,survey_score,count(survey_score) from survey where fty_no=$factory $dateChoice group by surveytopic_aid,survey_score";//每筆回答數據
										$U =mysql_query($sql) or die(mysql_error());

										$i=1; //表示目前正在處理第x題
										$count=0; //累計該題($now)的回答總數
										
										//抓出此廠區最後一題的題號
										$sql_minMaxQuizNo="select min(surveytopic_aid),max(surveytopic_aid) from survey where fty_no=$factory ";
										$s_minMaxQuizNo =mysql_query($sql_minMaxQuizNo) or die(mysql_error());
										
										while ( $minMaxQuizNo =mysql_fetch_assoc($s_minMaxQuizNo) ){ 
											$min_QuizNo = $minMaxQuizNo['min(surveytopic_aid)']; 
											$max_QuizNo = $minMaxQuizNo['max(surveytopic_aid)'];
										}

										$now=$min_QuizNo ; //目前處理的是第幾題
										
										//撈出資料並計算
										while ($s=mysql_fetch_assoc($U)){

											if (($now!=$s['surveytopic_aid'])and($now<$s['surveytopic_aid'])){ 
												
												$bbb[$i]=$count; //將回答總數存入陣列
												
												//各滿意度百分比計算
												if (isset($aaa[$i][1])){$ccc[$i][1]=round(($aaa[$i][1]/$bbb[$i])*100);} else {$ccc[$i][1]=0;} //如果存在，就計算百分比(5分的筆數/該題總數)，反之為0
												if (isset($aaa[$i][2])){$ccc[$i][2]=round(($aaa[$i][2]/$bbb[$i])*100);} else {$ccc[$i][2]=0;}
												if (isset($aaa[$i][3])){$ccc[$i][3]=round(($aaa[$i][3]/$bbb[$i])*100);} else {$ccc[$i][3]=0;}
												if (isset($aaa[$i][4])){$ccc[$i][4]=round(($aaa[$i][4]/$bbb[$i])*100);} else {$ccc[$i][4]=0;}
												if (isset($aaa[$i][5])){$ccc[$i][5]=round(($aaa[$i][5]/$bbb[$i])*100);} else {$ccc[$i][5]=0;} //如果存在，就計算百分比(1分的筆數/該題總數)，反之為0
												$i++;$count=0; //歸零以計算下一題的回答總數
												$now=$s['surveytopic_aid']; //確保now真的在目前處理的題號
												
											}
											
											switch ($s['survey_score']){
												
												case 5:
												$aaa[$i][5]=$s['count(survey_score)']; //5分的筆數存入陣列
												break; 
												
												case 4:
												$aaa[$i][4]=$s['count(survey_score)'];
												break; 
												
												case 3:
												$aaa[$i][3]=$s['count(survey_score)'];
												break; 
												
												case 2:
												$aaa[$i][2]=$s['count(survey_score)'];
												break; 
												
												case 1:
												$aaa[$i][1]=$s['count(survey_score)']; //1分的筆數存入陣列
												break;
											}		

											$count+=$s['count(survey_score)'];

										}
										
										//計算最後一題的滿意度分析
										if ($now==$max_QuizNo){
												
												$bbb[$i]=$count; //將回答總數存入陣列
												
												//各滿意度百分比計算
												if (isset($aaa[$i][1])){$ccc[$i][1]=round(($aaa[$i][1]/$bbb[$i])*100);} else {$ccc[$i][1]=0;}
												if (isset($aaa[$i][2])){$ccc[$i][2]=round(($aaa[$i][2]/$bbb[$i])*100);} else {$ccc[$i][2]=0;}
												if (isset($aaa[$i][3])){$ccc[$i][3]=round(($aaa[$i][3]/$bbb[$i])*100);} else {$ccc[$i][3]=0;}
												if (isset($aaa[$i][4])){$ccc[$i][4]=round(($aaa[$i][4]/$bbb[$i])*100);} else {$ccc[$i][4]=0;}
												if (isset($aaa[$i][5])){$ccc[$i][5]=round(($aaa[$i][5]/$bbb[$i])*100);} else {$ccc[$i][5]=0;}
										}
									
											$sql_quizContent="select * from surveytopic where fty_no=$factory"; //撈出題目內容
											$sql_quizCont =mysql_query($sql_quizContent) or die(mysql_error());
											$j=1; //顯示題號用
										
										while ($sql_qCont=mysql_fetch_assoc($sql_quizCont)){ ?>
											<div class="card" id="pie-charts">
												<div class="card-block">
													<h3><?php echo $j.". ".$sql_qCont['surveytopic_content']; ?></h3>
													<?php 
													if (empty($p[$j][5]) and empty($p[$j][4]) and empty($p[$j][3]) and empty($p[$j][2]) and empty($p[$j][1])){
														echo "此範圍內資料不足/尚無人回應";
													}else{ ?>

														<span class="chart" data-percent="<?php echo $p[$j][5];?>">
															<span class="percent"></span>
														</span>
														<?php echo "<span id='txt'>非常滿意</span>";?>
														<?php require_once("easy-pie-chart.php");?>

														<?php 
														echo "<h3>滿意：".$p[$j][4]."% ";
														echo "普通：".$p[$j][3]."% ";
														echo "不滿意：".$p[$j][2]."% ";
														echo "非常不滿意：".$p[$j][1]."%</h3>"; ?>
													<?php } ?>
												</div>
											</div>
											<?php 
											$j++; 
										}
										
										if(mysql_num_rows($sql_quizCont)==0){ //判斷sql_qCont有幾行資料
											echo "尚未新增題目";
										}	
									}else{ $factory=0;} ?>		
								</div>
							</div>
						</form>
					</div>               
				</div>
			</div>
		</div>
	<?php 
	}else{  
		echo "<script>alert('您無此權限')</script>";
		header("refresh: 0.5; url = index_admin.php");
	} 
} 
?>

<!-- jquery easypiechart -->
	<script>
	$(function() {
		$('.chart').easyPieChart({
			easing: 'easeOutBounce',
			onStep: function(from, to, percent) {
				$(this.el).find('.percent').text(Math.round(percent));
			}
		});
		var chart = window.chart = $('.chart').data('easyPieChart');
		$('.js_update').on('click', function() {
			chart.update(Math.random()*200-100);
		});
	});
	</script>
</body>
</html>
