
<!doctype html>
<html lang="en">
  <head>
    <?php require_once("head.php");?>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable({
          "order":[0, 'asc'],
          "aoColumnDefs": [
            { "bSortable": false, "aTargets": [ 3 ] }
          ]
        });
    } );
   </script>
  </head>
  
  <body>

  <?php require_once("chk_login.php");?>

  <?php if(isset($_SESSION["chk"])){?>
    <?php if($_SESSION["newsLOA"]==0){?>

      <div class="wrapper">
        <script type="text/javascript">
          $(document).ready(function(){
            $("li").removeClass("active");
            $("li.news").addClass("active");
          }); 
      </script>
      
      <?php require_once("menu.php");?>
        
      <div class="main-panel">
        <?php
          $title="最新消息管理";
          require_once("nav.php");
        ?>
          <div class="content">
            <div class="container-fluid">
              <div class="row">
              <div class="panel-group" id="accordion">
                <?php
                  require_once("mysql.php");
                  if ($adminLv_no==1) {
                    $sql = "select * from news";
                  }else{
                    $sql = "select * from news where fty_no=0 or fty_no=$fty_no";
                  }
                  
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
                                <p><?php echo $s['news_content'];?></p>
                             
                              <div class="col-lg-3">
                                <a href="newsEdit.php?news_no=<?php echo $s['news_no'] ?>" class='btn btn-info btn-fill'>修改</a>
                                <a href="newsDelete.php?news_no=<?php echo $s['news_no'] ?>" class='btn btn-danger btn-fill'>刪除</a>
                              </div>
                            
                         
                        </div>
                      </div>
                    </div>
                  <?php }?>
                </div>
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


          
