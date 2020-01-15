<!doctype html>
<html lang="en">

<head>
  <?php require_once("head.php");?>
</head>

<style type="text/css">
  .content{
    overflow:hidden;
  }
</style>
<body>

<?php require_once("chk_login.php");?>

<?php 
  if(isset($_SESSION["chk"])){
    if($_SESSION["adminLOA_authority"]==0){

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
            $title="權限管理";
            require_once("nav.php");
          ?>
          <div class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="card card-plain">
                    <div class="content table-responsive table-full-width">
                      <form name=f1 method=post action=authority_res.php>
                        <table class="table table-hover text-center">
                          <thead>
                            <th class="text-center">權限</th>
                            <th class="text-center">最新消息</th>
                            <th class="text-center">廠區</th>
                            <th class="text-center">管理員管理</th>
                            <th class="text-center">新增管理員</th>
                            <th class="text-center">題目管理</th>
                            <th class="text-center">新增題目類別</th>
                            <th class="text-center">問卷</th>
                            <th class="text-center">前後測分析</th><tr>
                          </thead>

                          <tbody align="center">

                            <?php 
                              require_once("mysql.php");

                              $sql = "select * from authority";
                              $U =mysql_query($sql) or die(mysql_error());
                              while ( $s =mysql_fetch_assoc($U)){

                                
                                $adminLv_no = $s['adminLv_no'];

                                $adminSQL = "select * from admin_lv where adminLv_no = $adminLv_no";  //顯示權限名稱
                                $adminU =mysql_query($adminSQL) or die(mysql_error());
                                while ( $admin =mysql_fetch_assoc($adminU) ){
                                  echo "<td>".$admin['adminLv_na']."</td>";
                                  $adminNo =  $admin['adminLv_no'];
                                }?>

                                <td align="center">
                                  <div class="checkbox">
                                    <label class="checkbox-inline">
                                      <?php 
                                        if($s['newsLOA'] == 0){
                                          echo "<input class='chk' type='checkbox' name='". $adminNo ."[]' value='". $adminNo ."0' checked>";
                                        }else{
                                          echo "<input class='chk' type='checkbox' name='". $adminNo ."[]' value='". $adminNo ."0' >";
                                        }
                                        
                                      ?>
                                    </label>
                                  </div>
                                </td>

                                <td align="center">
                                  <div class="checkbox">
                                    <label class="checkbox-inline">
                                      <?php 
                                        if($s['ftyLOA'] == 0){
                                          echo "<input class='chk' type='checkbox' name='". $adminNo ."[]' value='". $adminNo ."1' checked>";
                                        }else{
                                          echo "<input class='chk' type='checkbox' name='". $adminNo ."[]' value='". $adminNo ."1'>";
                                        }
                                        
                                      ?>
                                    </label>
                                  </div>
                                </td>

                                <td align="center">
                                  <div class="checkbox">
                                    <label class="checkbox-inline">
                                      <?php 
                                        if($s['adminLOA'] == 0){
                                          echo "<input class='chk' type='checkbox' name='". $adminNo ."[]' value='". $adminNo ."2' checked>";
                                        }else{
                                          echo "<input class='chk' type='checkbox' name='". $adminNo ."[]' value='". $adminNo ."2'>";
                                        }
                                        
                                      ?>
                                    </label>
                                  </div>
                                </td>

                                <td align="center">
                                  <div class="checkbox">
                                    <label class="checkbox-inline">
                                      <?php 
                                        if($s['adminLOA_new'] == 0){
                                          echo "<input class='chk' type='checkbox' name='". $adminNo ."[]' value='". $adminNo ."3' checked>";
                                        }else{
                                          echo "<input class='chk' type='checkbox' name='". $adminNo ."[]' value='". $adminNo ."3'>";
                                        }
                                                
                                      ?>
                                    </label>
                                  </div>
                                </td>

                                <td align="center">
                                  <div class="checkbox">
                                    <label class="checkbox-inline">
                                      <?php 
                                        if($s['topicLOA'] == 0){
                                          echo "<input class='chk' type='checkbox' name='". $adminNo ."[]' value='". $adminNo ."4' checked>";
                                        }else{
                                          echo "<input class='chk' type='checkbox' name='". $adminNo ."[]' value='". $adminNo ."4'>";
                                        }
                                      ?>
                                    </label>
                                  </div>
                                </td>

                                <td align="center">
                                  <div class="checkbox">
                                    <label class="checkbox-inline">
                                      <?php 
                                        if($s['topicLOA_newgrade'] == 0){
                                          echo "<input class='chk' type='checkbox' name='". $adminNo ."[]' value='". $adminNo ."5' checked>";
                                        }else{
                                          echo "<input class='chk' type='checkbox' name='". $adminNo ."[]' value='". $adminNo ."5'>";
                                        }
                                      ?>
                                    </label>
                                  </div>
                                </td>

                                <td align="center">
                                  <div class="checkbox">
                                    <label class="checkbox-inline">
                                      <?php 
                                        if($s['surveyLOA'] == 0){
                                          echo "<input class='chk' type='checkbox' name='". $adminNo ."[]' value='". $adminNo ."6' checked>";
                                        }else{
                                          echo "<input class='chk' type='checkbox' name='". $adminNo ."[]' value='". $adminNo ."6'>";
                                        }
                                      ?>
                                    </label>
                                  </div>
                                </td>

                                <td align="center">
                                  <div class="checkbox">
                                    <label class="checkbox-inline">
                                      <?php 
                                        if($s['analysisLOA'] == 0){
                                          echo "<input class='chk' type='checkbox' name='". $adminNo ."[]' value='". $adminNo ."7' checked>";
                                        }else{
                                          echo "<input class='chk' type='checkbox' name='". $adminNo ."[]' value='". $adminNo ."7'>";
                                        }
                                      ?>
                                    </label>
                                  </div>
                                </td>


                                <tr>

                              <?php }?>
                            </tbody>
                          </table>
                          <br>

                          <div class="col-sm-offset-5 col-sm-10">
                            <input id='btn' type='submit' value='更新' class="btn btn-info btn-fill btn-wd"></input>
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

<?php
    }else{  //判斷是否有權限if
      echo "<script>alert('抱歉你無此權限！'); location.href = 'index_admin.php'</script>";
    }
  } //判斷是否有登入if?>
</body>

      <?php require_once("js_file.php");?>


</html>
