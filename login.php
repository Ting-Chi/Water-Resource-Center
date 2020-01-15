<!doctype html>
<html lang="en">

<head>
  <?php require_once("head.php");?>

  <style type="text/css">
    input#ok{
      width: 270px;
      height: 50px;
      font-size: 20px;
      color: #ffffff;
      padding: 0 10px;
      background-color: #1C5AA5;
      opacity: 0.9;
    }
  </style>

  <script>
        function refresh_code(){ 
            //製造驗證圖片
            document.getElementById("imgcode").src="captcha.php"; 
        } 
  </script>
</head>
<body  >

  <div class="content col-lg-12">
  <div id="login">
        
          <div class="container-fluid" align="center">
          <br><br><br><br><br><br>

            <form method="post" action="login_res.php" name="f1">
                <h7>Login</h7>
                <br>
                <?PHP
                    if(isset($_GET['imgError'])){
                    echo "<p style='color:red'>驗證碼錯誤(注意區分大小寫)</p>";
                    }

                    if(isset($_GET['error'])){
                    echo "<p style='color:red'>帳號密碼錯誤</p>";
                    }

                    if(isset($_GET['noEnable'])){
                    echo "<p style='color:red'>此帳號已被停用</p>";
                    }
                  ?>
                <div class="input-group col-lg-2">
                  <br>
                  <input type="text" class="form-control border-input" placeholder="帳號" name="id" id="id" required><br><br><br>

                  <input type="password" class="form-control border-input" placeholder="密碼" name="pwd" id="pwd" required><br><br><br>

                  <p>請輸入下圖字樣：(點擊圖片可以更換)</p>
                  <p><img id="imgcode" src="captcha.php" onclick="refresh_code()"></p>
                  <input type="text" name="checkword" class="form-control border-input" placeholder="驗證碼(大小寫有差)" maxlength="10" required><br><br><br>
                  <input type = "submit" value = "登入" id="ok">
                </div>
            </form>

          </div>
          </div>
        </div>

</body>

      <?php require_once("js_file.php");?>


</html>
