<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>成績登錄中</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
	<!-- jQuery (Bootstrap 所有外掛均需要使用) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- Bootstrap -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	
	<link href="ranking.css" rel="stylesheet">
	
	<?php session_start();?>
</head>

<body style="background-color:#821115;">
	<?php if(isset($_POST['gameType']) and (!isset($_POST['player']))){ //未填寫大名跟ID?>
		<div class="">	
			<img src="排行輸入.png" class="rank_logo">
			<form name="PlayForm" method="post" action="play_res.php?insert=ok">
				<div class="yellow_form">
					<div class="form-group">
						<label color="#fff">暱稱：</label>
						<input type="text" name="player" placeholder="暱稱" class="form-control">
					</div>
					<div class="form-group">
						<label color="#fff">Line ID：</label>
						<input type="text" name="lineId" value="<?php if(isset($_SESSION['lineID'])){ echo $_SESSION['lineID'];} ?>" class="form-control">
					</div>
					<img src="輸入按鈕.png" class="submit_btn" onclick="javascript:form_submit();">
				</div>
				<input type="text" name="score"  style="display:none;" value="<?php echo $_POST['score']; ?>" required>
				<input type="text" name="gameType" style="display:none;" value="<?php echo $_POST['gameType']; ?>" required>
			</form>
			<script>
				function form_submit(){
					PlayForm.submit();
				}
			</script>
		</div>
				
	<?php
	}elseif(isset($_POST['gameType']) and (isset($_GET['insert']))){ //都填好了才新增
	
		$score=$_POST['score'];
		$player=$_POST['player'];
		$gameType=$_POST['gameType'];
		

		require_once("../mysql.php");

		if($player==''){ $player="無名英雄"; } 
		
		if(isset($_POST['lineId'])){
			
			$lineId=$_POST['lineId'];
			$sql="insert into game_score (gameScore_player ,gameScore_type,gameScore_score) VALUES ( '$player' ,'$gameType' ,'$score')";
			mysql_query($sql)or die(mysql_error());
			
			//新增到資料庫
			$sql_lineConn="select * from line_connect where lineConnect_lineid='$lineId'";
			$sql_line=mysql_query($sql_lineConn)or die(mysql_error());
			$s_line =mysql_fetch_assoc($sql_line);
			
			require_once("game_push.php");
			
		/*$sql_Ranking="SELECT (@i:=@i+1) as i, game_score.* FROM game_score,(select   @i:=0)   as   it where gameScore_lineid=$lineId order by gameScore_score desc ";
		$sql_Rank=mysql_query($sql_Ranking)or die(mysql_error());
		$s_Rank =mysql_fetch_assoc($sql_Rank);*/
		
		}else{

			$sql="insert into game_score (gameScore_player ,gameScore_type,gameScore_score,gameScore_lineid) VALUES ( '$player' ,'$gameType' ,'$score' ,'')";
			mysql_query($sql)or die(mysql_error());
			
		}
		
		header("refresh:0; url='ranking.php?gameType=" . $gameType . "'") ; 
		

	}else{ ?>
		<script type="text/javascript">
			alert('讀取錯誤：麻煩您重新操作一次。');
			window.location = '../logout.php';		
		</script> 
	<?php } ?>
</body>
</html>