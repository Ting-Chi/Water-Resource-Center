
<?php require_once("chk_login.php");?>

<?php if(isset($_SESSION["chk"])){?>
<div class="sidebar" data-background-color="white" data-active-color="danger">
	<div class="sidebar-wrapper">
        <div class="logo">
            <a href="" class="simple-text">
            <img src="assets/images/icon/水寶head.png" height="10%" width="10%">
                水資源管理中心
            </a>
        </div>

        <?php 

            $adminLv_no = $_SESSION["adminLv_no"];
        ?>
        <ul class="nav">

            <?php 
                if ($_SESSION["newsLOA"] == 0) {?>
                    <li class="news">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="ti-panel"></i>
                            <p>最新消息管理<b class="caret"></b></p>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="news.php">公告查詢</a></li>
                            <li><a href="newsNew.php">新增公告</a></li>
                        </ul>
                    </li>
            <?php }?>
            
            

            <?php 
                if ($_SESSION["ftyLOA"] == 0) {?>
                    <li class="factory">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="ti-user"></i>
                            <p>廠區管理<b class="caret"></b></p>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="factory.php">廠區查詢</a></li>
                            <li><a href="ftyNew.php">新增廠區</a></li>
                        </ul>
                    </li>

            <?php }?>

            

            <?php 
                if ($_SESSION["adminLOA"] == 0) {?>
                    <li class="admin">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="ti-view-list-alt"></i>
                            <p>管理者管理 <b class="caret"></b> </p>
                            
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="admin.php">管理者查詢</a></li>

                            <?php if ($_SESSION["adminLOA_new"] == 0){?>
                                    <li><a href="adminNew.php">新增管理者</a></li>
                            <?php }?>

                            <?php if ($_SESSION["adminLOA_authority"] == 0){?>
                                    <li><a href="authority.php">權限管理</a></li>
                            <?php }?>
                        </ul>
                    </li>
            <?php }?>

            

            <?php 
                if ($_SESSION["topicLOA"] == 0) {?>
                   <li class="topic">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="ti-text"></i>
                            <p>題目管理 <b class="caret"></b></p>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="topic.php">題目總覽</a></li>
                            <li><a href="ftyTopic.php">新增至廠區類別</a></li>
                            <li><a href="topicNew.php">新增題目</a></li>
                            <li><a href="topicGrade.php">題目類別查詢</a></li>
                        </ul>
                    </li> 
            <?php }?>

            

            <?php 
                if ($_SESSION["surveyLOA"] == 0) {?>
                   <li class="submenu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="ti-pencil-alt2"></i>
                            <p>問卷管理<b class="caret"></b></p>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="surveyNew.php">問卷題目</a></li>
                            <li><a href="analysisSurvey.php">問卷分析</a></li>
                        </ul>
                    </li> 

            <?php }?>


            <?php 
                if ($_SESSION["analysisLOA"] == 0) {?>
                    <li class="analysis">
                        <a href="analysis.php">
                            <i class="ti-map"></i>
                            <p>前後測分析</p>
                        </a>
                    </li>
            <?php }?>
        </ul>      
    </div>   
 </div>
<?php }?>
