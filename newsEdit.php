
<!doctype html>
<html lang="en">
  <head>
    <?php require_once("head.php");?>
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
            $title="修改公告";
            require_once("nav.php");
          ?>

          <div class="content">
            <div class="container-fluid">
              <?PHP
                  if(isset($_GET['chk_repeat'])){?>
                    <div class="alert alert-warning fade in">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>糟糕!</strong>&nbsp;&nbsp;此公告已存在
                    </div>
              <?php  }?>
              
              <div class="row">
                <div class="col-lg-10 col-md-10">
                  <div class="card">
                    <div class="content">
                      <?php
                          $newsNo_edit = $_GET["news_no"];
                          $_SESSION["newsNo_edit"] = $newsNo_edit;

                          require_once("mysql.php");

                          $sql = "SELECT * FROM news where news_no = $newsNo_edit";
                          $result = mysql_query($sql);
                          $row = mysql_fetch_assoc($result);

                          $_SESSION["news_title"] = $row['news_title'];
                      ?>
                      <form name=f1 method=post action=newsEdit_res.php>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">

                              <label><b>標題</b></label><br>
                              <textarea name="title" style="width:600px" placeholder="公告標題" required><?php echo $row['news_title']; ?></textarea><br><br>

                              <label><b>內容</b></label><br>
                              <textarea  name="news_content" placeholder="公告內容" style=" width:450px; height:150px"><?php echo $row['news_content']; ?></textarea><br><br>&nbsp;&nbsp;

                              <input type="submit" class="btn btn-info btn-md" value="修改"></input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <input type="reset" class="btn btn-danger btn-md"  value="清除">
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

<?php 
      }else{  //判斷是否有權限if
          echo "<script>alert('抱歉你無此權限！'); location.href = 'index_admin.php'</script>";
      }
  } //判斷是否有登入if
?>
</body>

      <?php require_once("js_file.php");?>


</html>
