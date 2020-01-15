<!doctype html>
<html lang="en">
  <head>
    <?php require_once("head.php");?>
  </head>

  <script>  
        $(document).ready(function(){

            var rulePhone=/^\d{9,10}$/; //僅能輸入9或10碼
            $("#phone").blur(function(){
                if(rulePhone.test($(this).val())){
                    $('#phone_Eorr').text('')
                    $(this).css("border-color","green")

                }else{
                   $('#phone_Eorr').text('不符合規則，請輸入正確號碼!')
                    $(this).css("border-color","red")
                }
            });
        })
    </script>  

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
                      $("li.factory").addClass("active");
                    });
                  </script>
                  
                  <?php require_once("menu.php");?>
                  
                
                <div class="main-panel">
                    <?php
                      $title="新增廠區";
                      require_once("nav.php");
                    ?>
                    <div class="content">
                        <div class="container-fluid">
                            <?php
                                if(isset($_GET['chk_repeat'])){?>
                                  <div class="alert alert-warning fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>糟糕!</strong>&nbsp;&nbsp;此廠區已存在
                                  </div>
                            <?php }?>
                            <div class="row">
                                <div class="col-lg-10 col-md-7">
                                    <div class="card">
                                        <div class="content">
                                            <form name=f1 method=post action=ftyNew_res.php>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>廠區名稱</label>
                                                            <input type="text" name="ftyName" class="form-control border-input" placeholder="輸入廠區" required>
                                                        </div>
                                                    </div>                                       
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>聯絡電話</label>
                                                            <input type="text" name="phone" id="phone" class="form-control border-input" placeholder="輸入聯絡電話" required>
                                                           <span id="phone_Eorr" class="error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">電子信箱</label>
                                                            <input type="email" name="email" class="form-control border-input" placeholder="Email">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <label>地址</label>
                                                            <input type="text" name="address" class="form-control border-input" placeholder="地址" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-left">
                                                    <input type="submit" value="新增" class="btn btn-info btn-md"></input>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="reset" class="btn btn-danger btn-md"  value="清除">
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
<?php       }else{  //判斷是否有權限if
                echo "<script>alert('抱歉你無此權限！'); location.href = 'index_admin.php'</script>";
            }
        } //判斷是否有登入if?>
</body>
    <?php require_once("js_file.php");?>
</html>
