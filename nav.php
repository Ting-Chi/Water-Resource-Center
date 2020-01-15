
<?php require_once("chk_login.php");?>

<?php if(isset($_SESSION["chk"])){?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button"
                    class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar bar1"></span>
                    <span class="icon-bar bar2"></span>
                    <span class="icon-bar bar3"></span>
                </button>
                <h4><?php echo $title;?></h4>
            </div>

            <?php 
                $admin_no = $_SESSION["admin_no"];

                require_once("mysql.php");

            ?>

            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">

                    <?php 
                        $fty_no = $_SESSION["fty_no"];
                        $sql = "select * from factory where fty_no = $fty_no";
                        $U =mysql_query($sql) or die(mysql_error());
                        while ( $s =mysql_fetch_assoc($U) ){
                            echo "<li><p id='h'>". $s["fty_na"]."</p></li>";
                        }



                        $adminLv_no = $_SESSION["adminLv_no"];
                        $sql = "select * from admin_lv where adminLv_no = $adminLv_no";
                        $U =mysql_query($sql) or die(mysql_error());
                        while ( $s =mysql_fetch_assoc($U) ){
                            echo "<li><p id='h'>". $s["adminLv_na"]."</p></li>";
                        }

                        echo "<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>";

                        if (isset($_SESSION["admin_na"])){  //user name
                            echo "<li><p id='h'>". $_SESSION["admin_na"]."</p></li>";
                        }

                        if ($_SESSION["admin_sex"]=="1")    {
                            echo "<li><p id='h'>先生</p></li>";
                        }elseif ($_SESSION["admin_sex"]=="2") {
                            echo "<li><p id='h'>小姐</p></li>";
                        }
                    ?>
                    
                    
                    <li>
                        <?php echo "<a id='btn' href = adminInfo.php?admin_no=" . $admin_no . " target='view_frame'>會員帳號</a>" ?>
                    </li>
                    
                    <li>
                       	 <a href="logout.php">
                        	<i class="ti-settings"></i>
    						<p>登出</p>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
<?php }?>
