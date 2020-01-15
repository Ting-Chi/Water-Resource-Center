<!doctype html>
<html lang="en">
<head>
	<?php require_once("head.php");?>
	<?php require_once("chk_login.php");?>
</head>
  
<body>
<?php if(isset($_SESSION["chk"])){
	
	require_once("mysql.php");
	
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
			</script>
		
			<?php require_once("menu.php");?>
		  
		<div class="main-panel">
			<?php
			$title="問卷題目";
			require_once("nav.php");
			?>
			<div class="content">
				<div class="container-fluid">
					<div class="row">
					   <div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="header">
									<h4 class="title">新增問卷題目</h4>
								</div>
								<div class="content">
									<form action="surveyNew_res.php" method="post">
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label>新增題目</label>
													<?php  
													//撈出各廠區名稱 (根據權限及所屬廠區下sql)
													if($_SESSION["adminLv_no"]!=1){
														$factory_name = "select * from factory where fty_enable=0 and fty_no=".$_SESSION["fty_no"];
													}else{
														$factory_name = "select * from factory where fty_enable=0 and fty_no!=0"; }
													
													$factory_na = mysql_query($factory_name) or die(mysql_error());
													?>
													<input type="text" class="form-control border-input" name="newQuiz" required>                                            
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>廠區</label>
													<select class="form-control border-input" name="ftyName">
														<?php
														while ($fty_na = mysql_fetch_assoc($factory_na)){
																echo "<option value='".$fty_na['fty_no']."'>".$fty_na['fty_na']."</option>";
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-md-1">
												<br>
												<button type="submit" class="btn btn-info btn-fill">新增</button>
											</div>
											<?php if(isset($_GET['status']) and ($_GET['status']=="ok")){ ?>
											<div class="col-md-2">
												<div class="alert alert-success">
													<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
													<strong>新增成功!</strong>
													<script type="text/javascript"><!-- 讓「新增成功」圖示淡出-->
														$(document).ready(function(){
															$(".alert-success").delay(2500).fadeOut(1500);
														});
													</script>
												</div>
											</div>
											<?php } ?>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
			
					<div class="row">
						<div class="panel-group" id="accordion">
							<?php 
							//將各廠區的問題 各別顯示
							$factory_na = mysql_query($factory_name) or die(mysql_error()); 
							while ($fty_na = mysql_fetch_assoc($factory_na)){ 	
								if($fty_na['fty_no']!=0){ //總部不是廠區不用輸出 ?>
									<div class="panel panel-warning">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $fty_na['fty_na']; ?>"><?php echo $fty_na['fty_na']."區問卷"; ?></a>
											</h4>
										</div>
										<div id="collapse<?php echo $fty_na['fty_na']; ?>" class="panel-collapse collapse <?php if (empty($i)){ echo "in"; }?>"> <!-- 如果i是空的，表示是第一個選單(因為一開始沒有設定變數i)，所以class加in展開!-->
											<div class="panel-body">
												<div class="content">
													<div class="col-sm-offset-1 col-md-10" align="center">
														<div class="content table-responsive table-full-width">
															<table class="table table-striped">
																<?php  
																$i=1;
																$sql_surveytopic = "select * from surveytopic where fty_no=".$fty_na['fty_no']; //撈出指定廠區資料
																$s_topic = mysql_query($sql_surveytopic) or die(mysql_error());
																
																$nums=mysql_num_rows($s_topic); //判斷s_topic有幾行資料
																
																if($nums!=0){ ?>
																	<thead>
																		<th><center>題號</center></th>
																		<th><center>問卷內容</center></th>
																	<th></th>
																	</thead>
															<?php }else{ echo "尚未新增題目"; } ?>

															<tbody align="center">
																<?php
																
																
																if (isset($_GET['surveytopic_aid'])){ //刪除題目會進來
																	$surveytopic_aid = $_GET['surveytopic_aid'];
																	$sql_deleteQuiz = "delete from surveytopic where surveytopic_aid=$surveytopic_aid"; //題目、該題回答記錄都會被刪除
																	$sql_deleteQuiz_2 = "delete from survey where surveytopic_aid=$surveytopic_aid";
																	mysql_query($sql_deleteQuiz) or die(mysql_error());
																	mysql_query($sql_deleteQuiz_2) or die(mysql_error());
																	header("refresh:0; url=surveyNew.php") ;
																}
																
																while ($topic=mysql_fetch_assoc($s_topic)){ ?>
																	<tr>
																		<td><?php echo $i;?></td>
																		<td><?php echo $topic['surveytopic_content'];?></td>
																		<td><a type="button" class="btn btn-danger btn-fill" href="surveyNew.php?surveytopic_aid=<?php echo $topic['surveytopic_aid'];?>">刪除</a></td>
																	</tr>
																<?php $i++;} ?>
															</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
							<?php } ?>						
						</div>
					</div>
				</div>               
			</div>
		</div>
		</div>
	<?php 
	}else{  
		echo '您無此權限 (不過版面我沒做QQ)';
	} 
} 
?>
</body>
      <?php require_once("js_file.php");?>
</html>
