<!doctype html>
<html lang="en">
  
  <head>
    <?php require_once("head.php");?>
  
    <script>

        //製作防呆判斷
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
                    $title="修改管理者";
                    require_once("nav.php");
                ?>
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-10 col-md-10">
                                <div class="card">
                                    <div class="content">

                                        <?php
                                            $adminNo_edit = $_GET["admin_no"];
                                            $_SESSION["adminNo_edit"] = $_GET["admin_no"];

                                            require_once("mysql.php");

                                            $sql = "SELECT * FROM admin where admin_no = $adminNo_edit";
                                            $result = mysql_query($sql);
                                            $row = mysql_fetch_assoc($result);
                                        ?>

                                        <form name=f1 method=post action=adminEdit_res.php >
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>廠區</label>
                                                        <?php 
                                                            $fty=$row['fty_no'];
                                                            $sql = "select * from factory where fty_no = $fty";
                                                            $U =mysql_query($sql) or die(mysql_error());
                                                            while ( $s =mysql_fetch_assoc($U) ){
                                                                echo "<select class='form-control' disabled>";
                                                                    echo "<option>".$s["fty_na"]."</option>";
                                                                echo"</select>";
                                                            }
                                                        ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>權限</label>
                                                        <?php 
                                                            $Level_no = $row["adminLv_no"];
                                                            $sql = "select * from admin_lv where adminLv_no = $Level_no";
                                                            $U =mysql_query($sql) or die(mysql_error());
                                                            while ( $s =mysql_fetch_assoc($U) ){
                                                                echo "<select class='form-control' disabled>";
                                                                    echo "<option>".$s["adminLv_na"]."</option>";
                                                                echo"</select>";
                                                            }
                                                        ?> 
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>姓名</label>
                                                        <input type="text" name="na" value=<?php echo $row['admin_na'] ?> class="form-control border-input" required >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>帳號</label>
                                                        <input type="text" id="id" name="id" value=<?php echo $row['admin_id'] ?> class="form-control border-input" disabled><span id="id_Eorr" class="error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>密碼</label>
                                                        <input type="password" id="pwd" name="pwd" value=<?php echo $row['admin_pwd'] ?> class="form-control border-input" required><span id="pwd_Eorr" class="error"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>手機</label>
                                                        <input type="text" id="phone" name="phone" value=<?php echo $row['admin_phone'] ?> class="form-control border-input" required><span id="phone_Eorr" class="error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>性別</label>
                                                        <br>
                                                        <div class="col-md-3">
                                                            <div class="radio">
                                                                <input type="radio" name="sex" class=radio-inline value="1" <?php if($row['admin_sex']=='1') {echo("checked");}?>>男
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="radio">
                                                                <input type="radio" name="sex" class=radio-inline value="2" <?php if($row['admin_sex']=='2') {echo("checked");}?>>女   
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">電子信箱</label>
                                                        <input type="email" name="email" value='<?php echo $row['admin_email'] ?>' class="form-control border-input">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-left">
                                                <input type="submit" value="修改" class="btn btn-info btn-fill btn-wd"></input>
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
