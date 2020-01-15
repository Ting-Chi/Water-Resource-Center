<!doctype html>
<html lang="en">

<head>
  <?php require_once("head.php");?>

  <script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable({
            "order":[],
            "aoColumnDefs": [
              { "bSortable": false, "aTargets": [ 7 ] }
            ]
        });
    } );
</script>
</head>
<body>

    <?php require_once("chk_login.php");?>

    <?php 
        if(isset($_SESSION["chk"])){
            if($_SESSION["adminLOA"]==0){
    ?>
                <div class="wrapper">

                    <script type="text/javascript">
                        $(document).ready(function(){
                          $("li").removeClass("active");
                          $("li.admin").addClass("active");
                      });  
                    </script>
                  
                    <?php require_once("menu.php");?>

                    <div class="main-panel">
                        <?php
                            $title="管理員";
                            require_once("nav.php");
                        ?>
                        
                        <div class="content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="content table-responsive table-full-width">
                                                <table id="example" class="table table-hover text-center">
                                                    <thead>
                                                        <th class="text-center">會員編號</th>
                                                        <th class="text-center">廠區</th>
                                                        <th class="text-center">權限</th>
                                                        <th class="text-center">姓名</th>
                                                        <th class="text-center">性別</th>
                                                        <th class="text-center">手機</th>
                                                        <th class="text-center">Email</th>
                                                        <th></th>
                                                        <th></th>
                                                        
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            // 顯示登入人員資訊
                                                            require_once("mysql.php");

                                                            $fty_no = $_SESSION["fty_no"];
                                                            $adminLv_no = $_SESSION["adminLv_no"];

                                                            if ($adminLv_no==1) {
                                                                $sql = "select * from admin order by fty_no ASC,adminLv_no ASC";
                                                            }else{
                                                                $sql = "select * from admin where fty_no='$fty_no' order by fty_no ASC,adminLv_no ASC";
                                                            }

                                                            $U =mysql_query($sql) or die(mysql_error());
                                                            while ( $s =mysql_fetch_assoc($U) ){
                                                                echo "<tr>";
                                                                echo "<td>" . $s['admin_no'] . "</td>";

                                                                /* factory */
                                                                $fty=$s['fty_no'];
                                                                $ftySQL = "select * from factory where fty_no = $fty";
                                                                $ftyU =mysql_query($ftySQL) or die(mysql_error());
                                                                while ( $fty =mysql_fetch_assoc($ftyU) ){
                                                                    echo "<td>" . $fty["fty_na"] . "</td>";
                                                                }


                                                                /* level */
                                                                $lv=$s['adminLv_no'];

                                                                $levelSQL = "select * from admin_lv where adminLv_no = $lv";
                                                                $levelU =mysql_query($levelSQL) or die(mysql_error());
                                                                while ( $level =mysql_fetch_assoc($levelU) ){
                                                                    echo "<td>" . $level["adminLv_na"] . "</td>";
                                                                }


                                                                echo "<td>" . $s['admin_na'] . "</td>";

                                                                switch($s['admin_sex']){
                                                                    case 1:
                                                                    echo "<td>男</td>";
                                                                    break;
                                                                    case 2:
                                                                    echo "<td>女</td>";
                                                                    break;
                                                                }

                                                                echo "<td>" . $s['admin_phone'] . "</td>";
                                                                echo "<td>" . $s['admin_email'] . "</td>";


                                                                if ($adminLv_no == 1){  //如果是super可修改所有管理者資料

                                                                    if ($s['admin_no'] == $admin_no) { //super不能停用自己僅顯示修改
                                                                        echo "<td colspan='2'>" . "<a id='stop' href=adminEdit.php?admin_no=". $s['admin_no'] ." class='btn btn-info btn-fill btn-wd'>修改</a></td>";

                                                                    }else{

                                                                        if($lv == 1){ //若同是super不能修改
                                                                            echo "<td>" . "<a id='stop' href='#' class='btn btn-info btn-fill' disabled>修改</a></td>";
                                                                            echo "<td>" . "<a id='stop' href='#' class='btn btn-danger btn-fill' disabled>停用</a></td>";
                                                                        }else{

                                                                            echo "<td>" . "<a id='stop' href=adminEdit.php?admin_no=". $s['admin_no'] ." class='btn btn-info btn-fill'>修改</a></td>";

                                                                            if ($s['admin_enable']=="0"){
                                                                                echo "<td>" . "<a id='stop' href=adminEnable.php?admin_no=". $s['admin_no'] ." class='btn btn-danger btn-fill'>停用</a></td>";
                                                                            }else{
                                                                                echo "<td>" . "<a id='start' href=adminEnable.php?admin_no=". $s['admin_no'] ." class='btn btn-danger btn-md'>重新啟用</a></td>";
                                                                            }
                                                                        }
                                                                    }

                                                                }else{

                                                                    if ($s['admin_no'] == $admin_no) {  //廠長僅能修改自己資料
                                                                        echo "<td>" . "<a id='stop' href=adminEdit.php?admin_no=". $s['admin_no'] ." class='btn btn-info btn-fill btn-wd'>修改</a></td>";

                                                                    }else if($adminLv_no <= 2){

                                                                        if ($s['admin_enable']=="0"){
                                                                            echo "<td>" . "<a id='stop' href=adminEnable.php?admin_no=". $s['admin_no'] ." class='btn btn-danger btn-fill '>停用</a></td>";
                                                                        }else{
                                                                            echo "<td>" . "<a  href=adminEnable.php?admin_no=". $s['admin_no'] ." class='btn btn-danger btn-md'>重新啟用</a></td>";
                                                                        }   
                                                                    }
                                                                }
                                                            }
                                                        ?>
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
