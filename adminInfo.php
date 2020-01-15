
<!doctype html>
<html lang="en">
  <head>
    <?php require_once("head.php");?>
  </head>
  
  <body>

  <?php require_once("chk_login.php");?>

  <?php if(isset($_SESSION["chk"])){?>

  <div class="wrapper">
    
    <?php require_once("menu.php");?>
      

    <div class="main-panel">
      <?php
        $title="個人資料";
        require_once("nav.php");
      ?>


      <div class="content">
        <div class="container-fluid">
          <?php
          if(isset($_GET["admin_edit"])){?>
            <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>修改成功!</strong>
            </div>
        <?php  }?>
          <div class="row">
            <div class="col-lg-10 col-md-10">
              <div class="card">
                <div class="content">
                  <form>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <?php
                            $adminNo=$_GET['admin_no'];

                            require_once("mysql.php");

                            $sql = "SELECT * FROM admin where admin_no = '$adminNo'";
                            $U =mysql_query($sql) or die(mysql_error());
                            while ( $s =mysql_fetch_assoc($U) ){
                          ?>
                          <label>管理員編號：<?php echo $s['admin_no'];?></label><br><br>
                          <label>姓名：<?php echo $s['admin_na'];?></label><br><br>

                          <label>地區：
                            <?php 

                              $fty_no = $_SESSION["fty_no"];
                              $adminLv_no = $_SESSION["adminLv_no"];

                              /* factory */
                              $fty=$s['fty_no'];
                                
                              $ftySQL = "select * from factory where fty_no = $fty";
                              $ftyU =mysql_query($ftySQL) or die(mysql_error());
                              while ( $fty =mysql_fetch_assoc($ftyU) ){
                                echo "<td>" . $fty["fty_na"] . "</td>";
                              }
                            ?>
                          </label><br><br>

                          <label>權限：
                            <?php
                              /* level */
                              $lv=$s['adminLv_no'];
                                
                              $levelSQL = "select * from admin_lv where adminLv_no = $lv";
                              $levelU =mysql_query($levelSQL) or die(mysql_error());
                              while ( $level =mysql_fetch_assoc($levelU) ){
                                echo "<td>" . $level["adminLv_na"] . "</td>";
                              }

                            ?>  
                          </label><br><br>
                          <label>帳號：<?php echo $s['admin_id'];?></label><br><br>

                          <label>性別：
                            <?php 
                              switch($s['admin_sex']){
                                case 1:
                                  echo "男";
                                  break;
                                case 2:
                                  echo "女";
                                  break;
                              } 
                            ?>  
                          </label><br><br>
                          <label>手機：<?php echo $s['admin_phone'];?></label><br><br>
                          <label>Email：<?php echo $s['admin_email'];?></label><br><br>

                            <a href=adminEdit.php?admin_no=<?php echo $s['admin_no']?> class="btn btn-info btn-fill btn-wd" >修改</a>
                          <?php }  // while 的 }?> 
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php }?>
</body>

      <?php require_once("js_file.php");?>


</html>
