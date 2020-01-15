<!doctype html>
<html lang="en">
  <head>
    <?php require_once("head.php");?>
  </head>
  
  <body>
    <?php require_once("chk_login.php");?>

    <?php if(isset($_SESSION["chk"])){?>
    <?php if($_SESSION["topicLOA"]==0){?>
        <div class="wrapper">
            <script type="text/javascript">
                $(document).ready(function(){
                  $("li").removeClass("active");
                  $("li.topic").addClass("active");
                }); 
            </script>
        
            <?php require_once("menu.php");?>
              

            <div class="main-panel">
               <?php
                    $title="題目類別查詢";
                    require_once("nav.php");
                ?>
                <div class="content">
                    <?php 
                    if ($_SESSION["topicLOA_newgrade"] == 0) {?>
                    <!--topicGrade NEW-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="header">
                                        <h4 class="title">新增題目類別</h4>
                                    </div>
                                    <div class="content">
                                        <?php 
                                            $adminLv_no = $_SESSION["adminLv_no"];
                                            $fty_no = $_SESSION["fty_no"];

                                            if($adminLv_no<=2){
                                                require_once("mysql.php");

                                        ?>
                                    
                                        <form name=f1 method=post action=topicGrade_res.php>
                                            <div class="row">
                                               <div class="col-md-2">
                                                   <div class="form-group">
                                                        <?php 
                                                
                                                            echo "<label>廠區</label>"; 
                                                            if($adminLv_no==1){
                                                                echo "<select name='fty' id='fty' class='form-control border-input'>";
                                                                        $sql = "select * from factory where fty_enable = 0";
                                                                        $U =mysql_query($sql) or die(mysql_error());
                                                                        while ( $s =mysql_fetch_assoc($U) ){
                                                                            echo "<option value = ".$s['fty_no'].">". $s['fty_na']."</option>";
                                                                        }
                                                                        echo "<option value = 0 >全區</option>";
                                                                echo "</select>";
                                                            }else{
                                                                echo "<select name='fty' id='fty'>";
                                                                        $sql = "select * from factory where fty_no = $fty_no";
                                                                        $U =mysql_query($sql) or die(mysql_error());
                                                                        while ( $s =mysql_fetch_assoc($U) ){
                                                                            echo "<option value = ". $fty_no .">". $s['fty_na']."</option>";
                                                                        }
                                                            }
                                                                echo "</select>";
                                                        ?>
                                                    </div>
                                                </div>
												<div class="col-md-3">
                                                   <div class="form-group">
                                                        <?php 
                                                            echo "<label>類別名稱</label>"; 
                                                            echo "<input type='text' name='topicGrade_Name' class='form-control border-input' required>";

                                                        ?>                                                    
                                                    </div>
                                                </div>  
												<div class="col-md-1">
													<div class="form-group">
													<?php    
														echo "<label>出題數</label>"; 
														echo "<input class='form-control border-input' onchange='Change_amount();' name='amount' id='amount' required></input>";  
															
											}//ftytopic=2的 ?>
													</div>
												</div>
												<script type="text/javascript">
												//即時判斷 預計出題數(amount)  已選類別題數(count($chked))											
												function Change_amount() {
													var amount=Math.floor($("#amount").val());
													
													if((isNaN(amount)) || (amount<0)){ //判斷是否為數字
														$("#amount").val('');
														amount=0;
														alert('請輸入數字');
													}
													
													if(amount>99){													
														$("#amount").val(99);
														alert('出題上限為99題');
													}else{
														$("#amount").val(amount);}
													
													$("#amount_span").html(amount);
												};
											</script>
                                            </div>
                                            <div class="clearfix">
                                                <nav class="pull-left">
                                                    <input id='btn' type='submit' value='新增' class="btn btn-md btn-default">
                                                </nav>                                                                       
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                    
                    <!-- 顯示各廠區題目類別-->
                    <div class="row">
                        <?php
                            /*  factory grade  */
                            require_once("mysql.php");
                            if($adminLv_no==1){
                                $sql = "select * from factory where fty_enable=0";
                            }else{
                                $sql = "select * from factory where fty_no = $fty_no";
                            }

                            $U =mysql_query($sql) or die(mysql_error());
                            while ( $s =mysql_fetch_assoc($U)){
                                if($adminLv_no==1){
                                    $fty_no = $s['fty_no'];
                                }

                                $fty = $s['fty_no'];
                        ?>
                               <div class="col-lg-6 col-md-6 ">
                                    <div class="card">
                                        <div class="header">                                
                                            <h4 class='title'><?php echo $s['fty_na']; ?></h4>                                        
                                        </div>
                                                       
                                        <div class="content table-responsive table-full-width">
                                            <table class="table table-striped">
                                                <thead>
                                                    <th>類別編號</th>
                                                	<th>類別名稱</th>
                                                    <th>出題數</th>
													<th></th>
                                                    <th></th>
                                                    
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        if($adminLv_no =='1'){
                                                            $gradeSQL = "select * from topic_grade where fty_no=$fty_no";
                                                        }
                                                        else{
                                                            $gradeSQL = "select * from topic_grade where fty_no=$fty_no or fty_no=0";
                                                        }

                                                        $G =mysql_query($gradeSQL) or die(mysql_error());
                                                        $num=1;
                                                        while ( $g =mysql_fetch_assoc($G)){
                                                            echo "<td>". $num; $num+=1 ."</td>";
                                                            echo "<td>". $g['topicGrade_na'] ."</td>";
															echo "<td>出 ". $g['topicGrade_amount'] ." 題</td>";
                                                        
                                                            $grade = $g['topicGrade_no'];

                                                            //若是總部的類別便不能修改, 多傳一個noEdit變數
                                                            if ($g['fty_no']=="0"){
                                                                if($adminLv_no =='1'){
                                                                    echo "<td><a id='seeTopicBtn' href='ftyTopic.php?fty=0&grade=$grade' class='btn btn-info btn-fill'>觀看題目</a></td>";
                                                                }else{
                                                                    echo "<td><a id='seeTopicBtn' href='ftyTopic.php?fty=0&grade=$grade&noEdit' class='btn btn-info btn-fill'>觀看題目</a></td>";
                                                                }
                                                            }else{
                                                                echo "<td><a id='seeTopicBtn' href='ftyTopic.php?fty=$fty&grade=$grade' class='btn btn-info btn-fill'>觀看題目</a></td>"; 
                                                            }

                                                            
                                                            if ($g['topicGrade_enable']=="0"){
                                                                echo "<td><a id='stop' href='topicGradeEnable.php?topicGrade_no=$grade' class='btn btn-danger btn-fill'>停用</a></td><tr>";
                                                            }else{ 
                                                                echo "<td><a id='start' href='topicGradeEnable.php?topicGrade_no=$grade' class='btn btn-danger btn-md'>重新啟用</a></td><tr>";
                                                            }
                                                        }
                                                    ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php } //while的} ?>  
                    </div>
                </div>               
            </div>
        </div>
<?php }else{  //判斷是否有權限if
                echo "<script>alert('抱歉你無此權限！'); location.href = 'index_admin.php'</script>";
            }
        } //判斷是否有登入if
?>
</body>

      <?php require_once("js_file.php");?>


</html>
