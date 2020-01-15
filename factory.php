<!doctype html>
<html lang="en">
  <head>
    <?php require_once("head.php");?>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({
                "order":[0, 'asc'],
                "aoColumnDefs": [
                  { "bSortable": false, "aTargets": [ 5,6 ] }
                ]
            });
        } );
     </script>

  </head>

  <body>
  <?php require_once("chk_login.php");?>
  <?php 
    if(isset($_SESSION["chk"])){
      if($_SESSION["ftyLOA"]==0){
  ?>

        <div class="wrapper">
          <script type="text/javascript">
            $(document).ready(function(){
              $("li").removeClass("active");
              $("li.factory").addClass("active");
            });
          </script>
          
          <?php require_once("menu.php");?>
          
        <div class="main-panel">
          <?php
              $title="廠區查詢";
              require_once("nav.php");
          ?>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">廠區資訊</h4>
                                </div>
                                <div class="content table-responsive">
                                    <table id="example" class="table table-striped text-center">
                                        <thead class="text-center">
                                            <th class="text-center">廠區編號</th>
                                        	<th class="text-center">廠區名稱</th>
                                        	<th class="text-center">連絡電話</th>
                                        	<th class="text-center">Email</th>
                                        	<th class="text-center">廠區地址</th>
                                          <th></th><th></th>
                                            
                                        </thead>

                                        <tbody>
                                        <?php
                                            require_once("mysql.php");

                                            $sql = "select * from factory";
                                            $U =mysql_query($sql) or die(mysql_error());
                                            
                                            while ( $s =mysql_fetch_assoc($U) ){
                                                echo "<tr>";
                                                echo "<td>" . $s['fty_no'] . "</td>";
                                                echo "<td>" . $s['fty_na'] . "</td>";
                                                echo "<td>" . $s['fty_phone'] . "</td>";
                                                echo "<td>" . $s['fty_email'] . "</td>";
                                                echo "<td>" . $s['fty_address'] . "</td>";

                                                if($s['fty_no']=='0'){
                                                  echo "<td colspan='2'><a class='btn btn-info btn-fill btn-wd' href='ftyEdit.php?fty_no=" . $s['fty_no'] ."'>修改</a></td>";
                                                }else{
                                                  echo "<td><a class='btn btn-info btn-fill' href='ftyEdit.php?fty_no=" . $s['fty_no'] ."'>修改</a></td>";
                                                  
                                                  if ($s['fty_enable']=="0"){
                                                      echo "<td><a class='btn btn-danger btn-fill ' href=ftyEnable.php?fty_no=". $s['fty_no'] ."&area=0>停用</a></td>";
                                                  }else{
                                                      echo "<td><a class='btn btn-danger btn-md' href=ftyEnable.php?fty_no=". $s['fty_no'] ."&area=0>重新啟用</a></td>";
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
