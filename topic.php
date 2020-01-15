<!doctype html>
<html lang="en">
  <head>
    <?php require_once("head.php");?>

     <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({
                "order":[0, 'asc'],
                "aoColumnDefs": [
                  { "bSortable": false, "aTargets": [ 3,4,5,6,7,8,9,10 ] }
                ]
            });
        } );
     </script>
  </head>
  
    <body>
    <?php require_once("chk_login.php");?>

    <?php
        if(isset($_SESSION["chk"])){
            if($_SESSION["topicLOA"]==0){
    ?>

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
                            $title="題目總覽";
                            require_once("nav.php");
                        ?>
                        <div class="content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">                   
                                            <div class="content table-responsive">

                                                <table id="example" class="table table-striped text-center">
                                                    <thead>
                                                        <th class="text-center">題號</th>
                                                        <th class="text-center">題型</th>
                                                        <th class="text-center">放置題目</th>
                                                        <th class="text-center">題目圖片置入</th>
                                                        <th class="text-center">答案A</th>
                                                        <th class="text-center">答案B</th>
                                                        <th class="text-center">答案C</th>
                                                        <th class="text-center">答案D</th>
                                                        <th class="text-center">正確解答</th>
                                                        <th></th><th></th>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            require_once("mysql.php");
                                                            $sql = "select * from topic where topic_content!= 'topic_content'";
                                                            $U =mysql_query($sql) or die(mysql_error());
                                                            while ( $s =mysql_fetch_assoc($U) ){
                                                                echo "<tr>";
                                                                echo "<td>" . $s['topic_no'] . "</td>";

                                                                if ($s['topic_types']=='c') {
                                                                    echo "<td>選擇</td>";
                                                                }else{
                                                                    echo "<td>是非</td>";
                                                                }

                                                                echo "<td>" . $s['topic_content'] . "</td>";
                                                                        
                                                                $img = "assets/images/topic/".$s['topic_img'] ;
                                                                echo "<td><img src='". $img ."' height='84' width='120'></td>";
                                                                 
                                                                echo "<td>" . $s['topic_a1'] . "</td>";
                                                                echo "<td>" . $s['topic_a2'] . "</td>";
                                                                echo "<td>" . $s['topic_a3'] . "</td>";
                                                                echo "<td>" . $s['topic_a4'] . "</td>";
                                                                echo "<td>" . $s['topic_ans'] . "</td>";



                                                                if ($adminLv_no==1) {
                                                                    echo "<td>" . "<a href=topicEdit.php?topic_no=". $s['topic_no'] ." class='btn btn-info btn-fill'>修改</a></td>";


                                                                    if ($s['topic_enable']=="0"){
                                                                        echo "<td>" . "<a class='btn btn-danger btn-fill ' href=topicEnable.php?topic_no=". $s['topic_no'] .">停用</a></td>";
                                                                    }else{
                                                                        echo "<td>" . "<a class='btn btn-danger btn-md' href=topicEnable.php?topic_no=". $s['topic_no'] .">重新啟用</a></td>";
                                                                    }  

                                                                }else if($fty_no==$s['fty_no']){
                                                                    echo "<td>" . "<a href=topicEdit.php?topic_no=". $s['topic_no'] ." class='btn btn-info btn-fill'>修改</a></td>";

                                                                    if ($s['topic_enable']=="0"){
                                                                        echo "<td>" . "<a class='btn btn-danger btn-fill ' href=topicEnable.php?topic_no=". $s['topic_no'] .">停用</a></td>";
                                                                    }else{
                                                                        echo "<td>" . "<a class='btn btn-danger btn-md' href=topicEnable.php?topic_no=". $s['topic_no'] .">重新啟用</a></td>";
                                                                    } 
                                                                }else{

                                                                    echo "<td>" . "<a href=topicEdit.php?topic_no=". $s['topic_no'] ." class='btn btn-info btn-fill disabled'>修改</a></td>";

                                                                    if ($s['topic_enable']=="0"){
                                                                        echo "<td>" . "<a href=topicEnable.php?topic_no=". $s['topic_no'] ."  class='btn btn-danger btn-fill disabled '>停用</a></td>";
                                                                    }else{
                                                                        echo "<td>" . "<a href=topicEnable.php?topic_no=". $s['topic_no'] ."  class='btn btn-danger btn-md disabled'>重新啟用</a></td>";
                                                                    } 
                                                                } 
                                                            }
                                                        ?>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php 
            }else{  //判斷是否有權限if
                echo "<script>alert('抱歉你無此權限！'); location.href = 'index_admin.php'</script>";
            }
        } //判斷是否有登入if
?>
</body>
    <?php require_once("js_file.php");?>
</html>
