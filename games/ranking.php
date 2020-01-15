<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>英雄榜</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
	<!-- jQuery (Bootstrap 所有外掛均需要使用) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- Bootstrap -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	
	<link href="ranking.css" rel="stylesheet">

	<?php session_start(); ?>

</head>
<body>
<?php if(isset($_GET['gameType'])){ ?>
<div class="wrapper">
	<div class="content">
		<div class="bg_img col-md-offset-4">
			<img src="排行.jpg">
		</div>
		<div class="row table_row">
			<table>
			<?php
				require_once("../mysql.php");
				
				$gameType=$_GET['gameType'];
				$sql = "select * from game_score where  gameScore_type = '$gameType' order by gameScore_score desc limit 8";
				$U =mysql_query($sql) or die(mysql_error());
              	while ( $s =mysql_fetch_assoc($U) ){
              		echo "<tr><td>" . $s['gameScore_player'] ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
              		echo "<td>" . $s['gameScore_score'] . "</td></tr>";
              	}

			?>
			</table>
			<div class="again_img"><a href="<?php echo $gameType;?>/index.html"><img src="<?php echo $gameType;?>/assets/again.png"></a></div>
		</div>
	</div>
</div>

<?php }else{ ?>
	<script type="text/javascript">
		alert('讀取錯誤：麻煩您重新操作一次。');
		window.location = '../logout.php';		
	</script> 
<?php } ?>

</body>
</html>