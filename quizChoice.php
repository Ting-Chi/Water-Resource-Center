<html>
<head>
	<title>類別選擇 - 前後測系統</title>
	<?php require_once('userNewSource.php');  //啟用BS,JS,CSS效果 ?>
	<?php session_start(); ?>
	<link href="assets/css/quizChoice.css" rel="stylesheet">
	<script>
		$(document).ready(function(e) {
			$('img[usemap]').rwdImageMaps();
		});
	</script>
</head>
<body>
	<div class="container">

		<?php 
		require_once("mysql.php");
		
		//選擇類別 (題目不夠出的會排除)
		
		$fty_no=$_GET['fty_no'];
		
        //先撈出 類別已選題數
		$chked = array();
        $sql_chked = "select topicGrade_no,count(topicGrade_no) from fty_topic where fty_no = $fty_no && ftyTopic_enable = 0 group by topicGrade_no";
		$sql_chk =mysql_query($sql_chked) or die(mysql_error());
		while ( $s_chk =mysql_fetch_array($sql_chk) ){
            $chked[$s_chk["topicGrade_no"]]= $s_chk["count(topicGrade_no)"];
        }
					
		//再撈出 預計出題數
		$sql_topicGrade= "select * from topic_grade where fty_no=$fty_no" ;
		$sql_grade=mysql_query($sql_topicGrade) or die( mysql_error()); 
		$sql_grade_nums = mysql_num_rows($sql_grade);
		
		?>
		
		<div id="sell_machine">
			<img src="assets/images/grade/販賣機台.jpg">
			
				<?php 
				$i_img=1; //選擇圖1~6之用
				while ($s_grade = mysql_fetch_array ($sql_grade)){

					//如果 類別已選題數($chked[題目類別編號]) > 預計出題數，才開放作答
					if (isset($chked[$s_grade["topicGrade_no"]]) and ($s_grade["topicGrade_amount"]!=0)){ //判斷類別已選題數是否存在or出題數是否為0 (已選/已出0題時進不了if)
						if (($chked[$s_grade["topicGrade_no"]]) >= ($s_grade["topicGrade_amount"])){
							if ($i_img==1){ echo "<div class='row col-xs-12' id='grade_choice1'>";} //決定是第一排or第二排
							if ($i_img==4){ echo "<div class='row col-xs-12' id='grade_choice2'>";} ?>
							
							
							<!--
							<a href="quizChoice.php?fty_no=<?php echo $fty_no?>&grade_no=<?php echo $s_grade['topicGrade_no']?>&amount=<?php echo $s_grade["topicGrade_amount"]?>">
								<img class="grade_img" src="/assets/images/grade/樣式<?php echo $i_img;?>.jpg">
									<span class="grade_na"><?php echo $s_grade['topicGrade_na']; ?></span>
								</img>
							</a>!-->
							
							<a href="quizChoice.php?fty_no=<?php echo $fty_no?>&grade_no=<?php echo $s_grade['topicGrade_no']?>&amount=<?php echo $s_grade["topicGrade_amount"]?>">
								&nbsp;&nbsp;<span class="grade_backup"><?php echo $s_grade['topicGrade_na']; ?>&nbsp;&nbsp;</span><br>
							</a>
							
							<?php
						}
					}
					if ($i_img==3 or $i_img==6 or $i_img==$sql_grade_nums){ echo "</div>";}
					$i_img++;
				}
				?>
						
			<!--<span class="header" id="text_lv">類別選擇</span>!-->
			
			<div id="go_index">
				<a href="index.php"><img height="45vh" src="assets/images/icon/回首頁.png"></a>
			</div>
		</div>
		
		<?php
					
		if(isset($_SESSION['user_no'])){ //先確定有抓到user_no (使用者編號)
			if(isset($_GET['grade_no'])){ //再做其他動作，否則判定錯誤
				
				$grade_no=$_GET['grade_no'];
				$amount=$_GET['amount'];
				
				//先把題號抽選出來放到陣列
				$sql= "select * from fty_topic where topicGrade_no=$grade_no and fty_no=$fty_no and ftyTopic_enable=0 order by rand() limit $amount "; 
				$t=mysql_query($sql) or die( mysql_error());

				//把出題數加進資料庫
				$amount_modify = "update user set user_amount='$amount',topicGrade_no='$grade_no' where user_no='$_SESSION[user_no]' ";
				mysql_query($amount_modify) or die(mysql_error());
				
				//初始化
				$_SESSION['aid']=array();  //產生陣列
				$_SESSION['total']=0; //計算答對題數
				$_SESSION['i']=1; //顯示目前題號(前端)
				$_SESSION['test']=1; //設定為前測 (1=前 2=後)

				$j=1;  //存入陣列的順序
				
				while ($s = mysql_fetch_array ($t)){
					
					$aid[$j]=$s['topic_no'];
					$_SESSION['aid']=$aid;
					$j+=1;
				}
				
				$_SESSION['j']=$j-1;
				
				//轉到前測畫面
				header("refresh: 0; url = quiz.php");
			}
		}else{ ?>
			<script type="text/javascript">
				alert('讀取錯誤：麻煩您重新操作一次。');
				window.location = 'logout.php';		
			</script> 
		<?php } ?>
	</div>
</body>
</html>