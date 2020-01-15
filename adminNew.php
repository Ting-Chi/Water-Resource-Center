<!doctype html>
<html lang="en">
  
  <head>
    <?php require_once("head.php");?>
  
    <script>  
        $(document).ready(function(){

            var ruleId=/^\w+$/;  //帳號密碼僅能輸入英數_
            $("#id").blur(function(){
                if(ruleId.test($(this).val())){
                    $('#id_Eorr').text('')
                    $(this).css("border-color","green")

                }else{
                   $('#id_Eorr').text('只能輸入英文數字及底線!')
                    $(this).css("border-color","red")
                }
            })

            var rulePwd=/^\w+$/;
            $("#pwd").blur(function(){
                if(rulePwd.test($(this).val())){
                    $('#pwd_Eorr').text('')
                    $(this).css("border-color","green")

                }else{
                   $('#pwd_Eorr').text('只能輸入英文數字及底線!')
                    $(this).css("border-color","red")
                }
            })

            var rulePhone=/^\d{10}$/; //手機僅能輸入09開頭後8碼
            $("#phone").blur(function(){
                if(rulePhone.test($(this).val())){
                    $('#phone_Eorr').text('')
                    $(this).css("border-color","green")

                }else{
                   $('#phone_Eorr').text('不符合規則，請輸入正確手機號碼!')
                    $(this).css("border-color","red")
                }
            });
        })

        
    </script>
  </head>
  
  <body>

  <?php require_once("chk_login.php");?>
  <?php 
    if(isset($_SESSION["chk"])){
        if($_SESSION["adminLOA_new"]==0){
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
                    $title="新增管理者";
                    require_once("nav.php");
                ?>
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?PHP
                                if(isset($_GET['chk_id'])){?>
                                  <div class="alert alert-warning fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>糟糕!</strong>&nbsp;&nbsp;此帳號已存在
                                  </div>
                            <?php  }?>
                            <div class="col-lg-10 col-md-10">
                                <div class="card">
                                    <div class="content">

                                        <form name=f1 method=post action=adminNew_res.php>
                                            <?php
                                                require_once("mysql.php");
                                                $sql = "select * from factory where fty_enable=0";
                                                $U =mysql_query($sql) or die(mysql_error());
                                            ?>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>廠區</label>
                                                        <select name="fty_no" id="fty_no" class="form-control border-input" onChange="location.href='adminNew.php?fty='+this.value">
                                                            <?php
                                                                while ( $s =mysql_fetch_assoc($U) ){
                                                                    echo "<option value = ".$s['fty_no'].">". $s['fty_na']."</option>";
                                                                }
                                                            ?>
                                                        </select>

                                                        <?php 
                                                            if(isset($_GET['fty'])){
                                                                $ftyLv = $_GET['fty']; 
                                                            }
                                                        ?>

                                                        <script type="text/javascript">
                                                            var fty = <?php echo $ftyLv;?>;
                                                            document.getElementById("fty_no").options[fty].selected = "true";
                                                        </script>
                                                    </div>
                                                </div>

                                                <?php
                                                    $sql = "select * from admin_lv where adminLv_enable=0";
                                                    $U =mysql_query($sql) or die(mysql_error());
                                                ?>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>權限</label>
                                                        <select name="adminLv_no" id="adminLv_no" class="form-control border-input">
                                                            <?php
                                                                while ( $s =mysql_fetch_assoc($U) ){
                                                                    echo "<option value = ".$s['adminLv_no'].">". $s['adminLv_na']."</option>";
                                                                }
                                                            ?>
                                                        </select>

                                                        <script type="text/javascript">
                                                            if(fty!=0){
                                                                document.getElementById("adminLv_no").options[0].remove();
                                                            }
                                                        </script>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>姓名</label>
                                                        <input type="text" name="na" class="form-control border-input" placeholder="輸入姓名" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>帳號</label>
                                                        <input type="text" id="id" name="id" class="form-control border-input" placeholder="輸入帳號" required><span id="id_Eorr" class="error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>密碼</label>
                                                        <input type="password" id="pwd" name="pwd" class="form-control border-input" placeholder="輸入密碼" required><span id="pwd_Eorr" class="error"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>手機</label>
                                                        <input type="text" id="phone" name="phone" class="form-control border-input" placeholder="手機號碼"><span id="phone_Eorr" class="error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>性別</label>
                                                        <br>
                                                        <div class="col-md-3">
                                                            <div class="radio">
                                                                <input type="radio" name="sex" class=radio-inline value="1" checked>男
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="radio">
                                                                <input type="radio" name="sex" class=radio-inline value="2">女   
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">電子信箱</label>
                                                        <input type="email" name="email" class="form-control border-input" placeholder="email">
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

<?php 
        }else{  //判斷是否有權限if
             echo "<script>alert('抱歉你無此權限！'); location.href = 'index_admin.php'</script>";
        }
    } //判斷是否有登入if?>
</body>
    <?php require_once("js_file.php");?>
</html>
