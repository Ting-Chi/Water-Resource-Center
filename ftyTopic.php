<!doctype html>
<html lang="en">
  <head>
    <?php require_once("head.php");?>

    <script type="text/javascript">  //表格控制項
        $(document).ready(function() {
            $('#example').DataTable({
                //預設排序的欄位
                "order":[1, 'asc'] 

                //關掉這幾欄的排序
                "aoColumnDefs": [  
                  { "bSortable": false, "aTargets": [ 0,4,5,6,7,8,9 ] }
                ]

                //關掉分頁
                "bPaginate": false   
            });
			
			
        });
     </script>

     <script type="text/javascript">
        function checkAll(){
            $('#checkAll').on('change', function() {
                if(this.checked) {
                    $(".checkbox").addClass("checked");
                }else{
                    $(".checkbox").removeClass("checked");
                }
                $("input:checkbox").prop('checked', $(this).prop("checked"));
				Change_chk();
            });
			
        }                               
     </script>
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
                $title="題目分類";
                require_once("nav.php");
            ?>
            <div class="content">
                <form name=f1 method=post action=ftyTopic_res.php onsubmit="return chkChecked();">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-10 col-md-7">
                                <div class="card">
                                    <div class="header">
                                        <h4 class="title">新增至廠區類別</h4>
                                    </div>

                                    <?php 
                                        $adminLv_no = $_SESSION["adminLv_no"];
                                        $fty_no = $_SESSION["fty_no"];
                                        $fty="0";
                                        $ftyChk= 'false';
                                        $gradeChk= 'false';

                                    ?>

                                    <div class="content">      
                                        <div class="row">
                                        <!-- 根據權限顯示選單 -->    
                                            <div class="col-md-3">
                                                <div class="form-group">

                                                    <?php
                                                        require_once("mysql.php");

                                                        /* - factory  select - */

                                                        echo "<label>廠區</label>"; 
                                                        if($adminLv_no==1){?>
                                                            <select name='fty' id='fty' class="form-control border-input" onChange="location.href='ftyTopic.php?fty='+this.value" ><?php

                                                                echo "<option value='no'>請選擇</option>";
                                                                $sql = "select * from factory where fty_enable = 0";
                                                                $U =mysql_query($sql) or die(mysql_error());
                                                                while ( $s =mysql_fetch_assoc($U) ){
                                                                    echo "<option value = ".$s['fty_no'].">". $s['fty_na']."</option>";
                                                                } ?>
                                                            </select><?php 
                                                        }else{
                                                            echo "<select name='fty' id='fty' class='form-control border-input'>";
                                                                $sql = "select * from factory where fty_no = $fty_no";
                                                                    $U =mysql_query($sql) or die(mysql_error());
                                                                    while ( $s =mysql_fetch_assoc($U) ){
                                                                    echo "<option value = ". $fty_no .">". $s['fty_na']."</option>";
                                                                }
                                                            echo "</select>";       
                                                        }?>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <?php    
                                                    /* - factory grade select - */

                                                    if($adminLv_no==1){
                                                        if(isset($_GET['fty'])){
                                                            $fty=$_GET["fty"];
                                                            $_SESSION["fty"]=$fty;
                                                        }
                                                    }else{
                                                        $fty = $fty_no;
                                                        $_SESSION["fty"]=$fty;  
                                                    }
                                                    
                                                    echo "<label>題目類別</label>"; ?>

                                                    <select name='grade' id='grade' class='form-control border-input' onchange='chgSelect();'><?php
                                                        echo "<option value='no'>請選擇</option>";
                                                        $sql = "select * from topic_grade where fty_no = $fty and topicGrade_enable=0";
                                                        $U =mysql_query($sql) or die(mysql_error());
                                                        while ( $s =mysql_fetch_assoc($U)){
                                                            echo "<option value = ".$s['topicGrade_no'].">". $s['topicGrade_na']."</option>";   
                                                        }

                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
											<div class="col-md-3">
                                                <div class="form-group">
                                                <?php    
                                                    /* - factory grade amount input - */
													
													echo "<label>出題數</label>"; 

                                                    if (isset($_GET["grade"])){
                                                        $sql_gradeAmount = "select * from topic_grade where topicGrade_no=".$_GET["grade"];
                                                        $sql_Amount =mysql_query($sql_gradeAmount) or die(mysql_error());
                                                        $s_amount =mysql_fetch_assoc($sql_Amount);

                                                        if (isset($_GET["noEdit"])){
                                                            echo "<input class='form-control border-input' onchange='Change_amount();' name='amount' id='amount' value='".$s_amount['topicGrade_amount']."' required disabled></input>";  
                                                        }else{
                                                            echo "<input class='form-control border-input' onchange='Change_amount();' name='amount' id='amount' value='".$s_amount['topicGrade_amount']."' required></input>";  
                                                        }
                                                        
														 
													} ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <!-- 根據顯示選單顯示結果 -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <?php

                                                        /*
                                                            -有選擇才會抓到get
                                                        */

                                                        if($adminLv_no==1){  
                                                            $ftyChk='true';

                                                            $sql = "select * from factory where fty_no = $fty";
                                                            $U =mysql_query($sql) or die(mysql_error());
                                                            while ( $s =mysql_fetch_assoc($U) ){
                                                                echo "<span class='ftySelect'>所選廠區：".$s['fty_na']."</span>";
                                                            }
                                                        }else{

                                                            $sql = "select * from factory where fty_no = $fty";
                                                            $U =mysql_query($sql) or die(mysql_error());
                                                            while ( $s =mysql_fetch_assoc($U) ){
                                                                echo "<span class='ftySelect'>所選廠區：".$s['fty_na']."</span>";
                                                            }

                                                        }

                                                        if(isset($_GET['grade'])){
                                                            $gradeChk='true';

                                                            $grade=$_GET["grade"];
                                                            $_SESSION["grade"]=$grade;

                                                            $sql = "select * from topic_grade where topicGrade_no = $grade";
                                                                $U =mysql_query($sql) or die(mysql_error());
                                                                while ( $s =mysql_fetch_assoc($U) ){
                                                                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                                echo "<span class='ftySelect'>類別：".$s['topicGrade_na']."</span>";
                                                            }
                                                        }

                                                    ?>


                                                    <script type="text/javascript">
                                                        //再送出前確認是否都有選取
                                                        function chkChecked() {
                                                            var fty = <?php echo $ftyChk;?>;
                                                            var grade = <?php echo $gradeChk;?>;

                                                            if (fty == false || grade == false){
                                                                alert("請確實選擇廠區及類別");
                                                                return false;
                                                            }else{
                                                                return true;
                                                            }

                                                        };

                                                    </script>

                                                    <script type="text/javascript">
                                                      //根據選擇顯示該廠區類別表單
                                                        function chgSelect(){ 
                                                            var fty = <?php echo $fty;?>; 
                                                            var grade = f1.grade.value;  
                                                            location.href="ftyTopic.php?fty=" + fty + "&grade=" + grade;
                                                        }
                                                    </script>
                                                </div>
										    </div>
                                        </div>
										
										<div class="row">
											<div class="col-md-9">
												<!-- 已選題目數 < 出題數時顯示 -->

										<?php 
                                                if (isset($_GET["noEdit"])){?>
                                                    <div class="alert alert-danger" id="amount_alert" style="display:none">
                                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                        <strong>警告！這個類別只有總部才能修改</strong>
                                                    </div>
                                                    
                                        <?php   }else{
                                                    if (isset($_GET["grade"])){ ?>
    													<div class="alert alert-danger" id="amount_alert" style="display:none">
    														<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    														<strong>警告！這個類別的題目低於設定題數 <span id="amount_span"><?php echo $s_amount['topicGrade_amount'];?></span> 題 (目前僅 <span id="chked"></span> 題) 將不會讓民眾作答！</strong>
    													</div>
    													<div class="alert alert-danger" id="amount_zeroAlert" style="display:none">
    														<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    														<strong>警告！這個類別的出題數為 0 題，將不會讓民眾作答！</strong>
    													</div>
    													<div class="alert alert-danger" id="amount_maxAlert" style="display:none">
    														<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    														<strong>警告！最大出題數為 99 題</strong>
    													</div>
										<?php       }
                                                } 



                                                ?>
											</div>
											<div class="col-md-3">
												<div class="clearfix">
													<nav class="pull-right">
														<input type='submit' id="submitBtn" value='新增' class="btn btn-info btn-fill"></input>                 
													</nav>                                                                           
												</div>
											</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="content table-responsive">
							
                                        <?php
                                            require_once("mysql.php");

                                            if(isset($_GET['grade'])){    /* 預勾以前所選的題目 - */
                                                $chked = array();
                                                if(!isset($_GET["noEdit"])){
                                                    $sql = "select * from fty_topic where fty_no = $fty && topicGrade_no = $grade && ftyTopic_enable = 0";
                                                }else{
                                                    $sql = "select * from fty_topic where fty_no = 0 && topicGrade_no = $grade && ftyTopic_enable = 0";
                                                }
                                                
												$U =mysql_query($sql) or die(mysql_error());
                                                while ( $q =mysql_fetch_array($U) ){
                                                    $chked[]= $q["topic_no"];
                                                }
                                        ?>
                                        <script type="text/javascript">
                                            //即時判斷 預計出題數(amount)  已選類別題數(count($chked))											
											function Change_amount() {
												var amount=Math.floor($("#amount").val());
												var chked=$('input#chk:checked').length;
												
												if((isNaN(amount)) || (amount<0)){ //判斷是否為數字
													$("#amount").val('');
													amount=0;
													alert('請輸入數字');
												}
												
												if (chked >= amount){
													$("#amount_alert").hide();
												}else{
													$("#amount_alert").show();}
												if(amount==0){													
													$("#amount_zeroAlert").show();
												}else{
													$("#amount_zeroAlert").hide();}
												if(amount>99){													
													$("#amount_maxAlert").show();
													$("#amount_alert").hide();
													$("#amount").val(99);
												}else{
													$("#amount_maxAlert").hide();
													$("#amount").val(amount);}
												
												$("#amount_span").html(amount);
                                            };
											
											//讀取已選題數，回傳給id="chked"
											function Change_chk(){	
												$("#chked").html($('input#chk:checked').length);
												
												amount=$("#amount").val(); //預計出題數
												chked=$('input#chk:checked').length; //已選題目數
												
												if (chked >= amount){
													$("#amount_alert").hide();
												}else{
													$("#amount_alert").show();}
												if(amount==0){													
													$("#amount_zeroAlert").show();
												}else{
													$("#amount_zeroAlert").hide();}
											}
                                        </script>
										<table id="example" class="table table-hover text-center">
                                            <thead>
                                                <th>
                                                    <div class='checkbox'>
                                                        <label class='checkbox-inline' onclick="checkAll()">
                                                            <?php
                                                                if(isset($_GET["noEdit"])){
                                                                    echo "<input type='checkbox' name='CheckAll' id='checkAll' disabled>";
                                                                }else{
                                                                    echo "<input type='checkbox' name='CheckAll' id='checkAll'>";
                                                                }
                                                            ?>
                                                        </label>   
                                                    </div>
                                                </th>
                                                <th class="text-center">題號</th>
                                                <th class="text-center">題型</th>
                                                <th class="text-center">放置題目</th>
                                                <th class="text-center">題目圖片置入</th>
                                                <th class="text-center">答案A</th>
                                                <th class="text-center">答案B</th>
                                                <th class="text-center">答案C</th>
                                                <th class="text-center">答案D</th>
                                                <th class="text-center">正確解答</th>
                                            </thead>
                                            <tbody>
                                            <?php  

                                                $sql = "select * from topic where topic_enable=0";
                                                $U =mysql_query($sql) or die(mysql_error());
                                                while ( $s =mysql_fetch_assoc($U) ){
                                                    echo "<tr>";
                                                    if (in_array($s['topic_no'], $chked)){
                                            ?>
                                                        <td>
                                                            <div>
                                                                <div class='checkbox'>
                                                                    <label class='checkbox-inline'>
                                                                    <?php 
                                                                        if(isset($_GET["noEdit"])){
                                                                            echo "<input class='chk' type='checkbox' name='chkTopic[]' id='chk' onchange='Change_chk();' value=".$s['topic_no']." checked disabled>";
                                                                        }else{
                                                                            echo "<input class='chk' type='checkbox' name='chkTopic[]' id='chk' onchange='Change_chk();' value=".$s['topic_no']." checked>";
                                                                        }
                                                                    ?>
                                                                        
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                      
                                            <?php   }else{ ?>
                                                        <td>
                                                            <div>
                                                                <div class='checkbox'>
                                                                    <label class='checkbox-inline'>
                                                                    <?php 
                                                                        if(isset($_GET["noEdit"])){
                                                                            echo "<input class='chk' type='checkbox' name='chkTopic[]' id='chk' onchange='Change_chk();' value=".$s['topic_no']." disabled>";
                                                                        }else{
                                                                            echo "<input class='chk' type='checkbox' name='chkTopic[]' id='chk' onchange='Change_chk();' value=".$s['topic_no'].">";
                                                                        }
                                                                    ?>
                                                                        
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </td>
                                            <?php   }
                                                    
                                                    echo "<td>" . $s['topic_no'] . "</td>";

                                                    if ($s['topic_types']=='c') {
                                                        echo "<td>選擇</td>";
                                                    }else{
                                                        echo "<td>是非</td>";
                                                    }

                                                    echo "<td>" . $s['topic_content'] . "</td>";
                                                        
                                                    $img = "assets/images/topic/".$s['topic_img'] ;
                                                    echo "<td><img src='". $img ."' height='60' width='90'></td>";
                                                
                                                    echo "<td>" . $s['topic_a1'] . "</td>";
                                                    echo "<td>" . $s['topic_a2'] . "</td>";
                                                    echo "<td>" . $s['topic_a3'] . "</td>";
                                                    echo "<td>" . $s['topic_a4'] . "</td>";
                                                    echo "<td>" . $s['topic_ans'] . "</td>";
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                        <!-- 頁面載入後，先計算已選題數 !-->
										<script type="text/javascript">
											$("#chked").html($('input#chk:checked').length);
																						
											if (($("#amount").val()) <= ($('input#chk:checked').length)){
													$("#amount_alert").hide();
												}else{
													$("#amount_alert").show();
											}
											
											if($("#amount").val()==0){													
												$("#amount_zeroAlert").show();
											}else{
												$("#amount_zeroAlert").hide();}
											
											if($("#amount").val()>99){													
												$("#amount_maxAlert").show();
												$("#amount_alert").hide();
											}else{
												$("#amount_maxAlert").hide();}
										</script>
										<?php }  //if的}?>

                                    </div> 
                                </div>                              
                            </div>      
                        </div>
                    </div>
                </form>
            </div>
        </div>
</div>
<?php }else{  //判斷是否有權限if
        echo "<script>alert('抱歉你無此權限！'); location.href = 'index_admin.php'</script>";
      }
    } //判斷是否有登入if?>
</body> 
   <?php require_once("js_file.php");?>
</html>
