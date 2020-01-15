<!DOCTYPE html>
<html lang="en">
<html>
<head>
  <?php require_once("head.php");?>
  <link rel="stylesheet" href="assets/css/index.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="assets/js/jquery.rwdImageMaps.js"></script>
  <!-- <link rel="stylesheet" href="assets/css/bootstrap-horizon.css"> -->

  <script>
    $(document).ready(function(e) {
        $('img[usemap]').rwdImageMaps();
    });
	</script>
</head>

<body>
<div class="wrapper">
	<div class="content">
		<div class="row">
			<!-- 遊樂園影像地圖 -->
			<div id="playground">
				<div id="play">
					<img src="assets/images/index/play.png" usemap="#Map">
                    <map name="Map">
                      <area shape="rect" coords="400,20,800,300" href="games/01ass/index.html">
                      <area shape="rect" coords="800,50,1200,400" href="movie.php">
                      <area shape="rect" coords="700,500,1100,800" href="games/04DFwater/index.html">
                      <area shape="rect" coords="520,322,750,532" href="games/05muni/index.html">
                      <area shape="rect" coords="250,650,500,930" href="games/02puch/index.html">
                      <area shape="rect" coords="43,321,450,564" href="games/03crashdirty/index.html">
                    </map>
				</div>
			</div>

			<!-- 手機版影像地圖 -->
			<div id="phone" class="row row-horizon">
				<img  src="assets/images/index/phone/phone-01.png" usemap="#Map2">
                <map name="Map2">
                  <area shape="circle" coords="210,340,180" href="games/01ass/index.html">
                  <area shape="circle" coords="630,340,180" href="movie.php">
                  <area shape="circle" coords="1040,340,180" href="games/02puch/index.html">
                  <area shape="circle" coords="1460,340,180" href="games/03crashdirty/index.html">
                  <area shape="circle" coords="1880,340,180" href="games/04DFwater/index.html">
                  <area shape="circle" coords="2290,340,180" href="games/05muni/index.html">
                  <area shape="circle" coords="2710,440,140" href="userNew.php">
                  <area shape="rect" coords="2940,120,3250,260" href="movie.php">
                  <area shape="rect" coords="2940,340,3300,580" href="survey.php">
                </map>
		         
			</div>
		</div>
		<!-- 問卷 -->
		<a href="userNew.php"><div class="row" id="quiz"></div></a>
		<div class="row" id="ticketBg">
			<img src="assets/images/index/ticketBg.png" usemap="#Map1">
			<map name="Map1">
				<area shape="rect" coords="120,180,400,340" href="#aa">
				<area shape="rect" coords="510,180,790,340" href="#aa">
				<area shape="rect" coords="880,180,1160,340" href="survey.php">
            </map>
		</div>
		<div class="row" id="aa">
			<div class="col-xs-12 col-sm-12 col-lg-6" id="new">
				<div class="panel-group" id="accordion">
					<?php
						require_once("mysql.php");
						$sql = "select * from news";
						$U =mysql_query($sql) or die(mysql_error());
						while ( $s =mysql_fetch_assoc($U) ){
					?>
					<div class="panel panel-warning">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $s['news_no']; ?>">
									<span class="text-warning"><?php echo $s['news_date']?></span>
									<span><?php echo $s['news_title'];?></span>
								</a>
							</h4>
						</div>
						<div id="collapse<?php echo $s['news_no']; ?>" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="content">
									<div class="row">
										<div class="col-lg-9">
											<p><?php echo $s['news_content'];?></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php }?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-lg-6" id="media">
				<video controls>
					<source src="assets/media/demo.mp4" type="video/mp4">
					Your browser does not support HTML5 video.
				</video>
			</div>
		</div>
	</div>
	<footer><?php if(isset($_GET['lineID'])){ $_SESSION['lineID']=$_GET['lineID'];} ?></footer>
</div>
</body>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
</html>