<!doctype html>
<html lang="en">
<head>
    <?php require_once("head.php");?>

    <script type="text/javascript">

    $(function() {  //判斷選擇題選項是否重複
      $('#chk_Choose').click(function() {
        if(($('.ch_ans1').val()==$('.ch_ans2').val()) ||
           ($('.ch_ans1').val()==$('.ch_ans3').val()) || 
           ($('.ch_ans1').val()==$('.ch_ans4').val()) ||
           ($('.ch_ans2').val()==$('.ch_ans3').val()) || 
           ($('.ch_ans2').val()==$('.ch_ans4').val()) || 
           ($('.ch_ans3').val()==$('.ch_ans4').val())){

           $('#c_msg').text('每個答案皆不可以重複!')

           return false;
        } else {
          return true;
        }
      });
    });

    </script>

    <script> 

      $(function (){
        //讀取圖片判斷是否為圖檔並顯示縮圖
        function preview(input) {
            // 若有選取檔案
            if (input.files && input.files[0]) {

              var file = input.files[0];
              type = file.type; //type=檔案型態

              if(type != "image/png" && type != "image/jpg" && type != "image/gif" && type != "image/jpeg" ) { //假如檔案格式不等於 png 、jpg、gif、jpeg
                alert("檔案格式不符合: png, jpg or gif"); //顯示警告
                $(".img").val(""); //將檔案欄設為空

              }else{
                // 建立一個物件，使用 Web APIs 的檔案讀取器(FileReader 物件)來讀取使用者選取電腦中的檔案
                var reader = new FileReader(); 
                  //事先定義好，當讀取成功後會觸發的事情
                reader.onload = function (e) {
                  // 這裡看到的 e.target.result 物件，是使用者的檔案被 FileReader 轉換成 base64 的字串格式，
                  // 在這裡我們選取圖檔，所以轉換出來的，會是如 『data:image/jpeg;base64,.....』這樣的字串樣式。
                  // 我們用它當作圖片路徑就對了。
                  $('.preview').attr('src', e.target.result);
                }
                  // 因為上面定義好讀取成功的事情，所以這裡可以放心讀取檔案
                  reader.readAsDataURL(input.files[0]);
              } 
            }
        }
     
        $("body").on("change", ".img", function (){
            preview(this);
        })


        //判斷是否為excel檔
        function excel(input){
          if (input.files && input.files[0]) {

            var file = input.files[0];
            type = file.type; //type=檔案型態
            //alert(type);

            if(type != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") { //假如檔案格式不等於 xls
              alert("檔案格式不符合: xls"); //顯示警告
              $(".excel").val(""); //將檔案欄設為空
            }
          }
        }

        $("body").on("change", ".excel", function (){
            excel(this);
        })
        
      })

    </script>
</head>
  
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
                      $("li.topic").addClass("active");
                    }); 
                </script>
            
                <?php require_once("menu.php");?>
                  
                <div class="main-panel">
                  <?php
                      $title="新增題目";
                      require_once("nav.php");
                  ?>
                  <div class="content">
                        <div class="row">
                            <div class="panel-group" id="accordion">
                                <?PHP
                                    if(isset($_GET['chk_repeat'])){?>
                                      <div class="alert alert-warning fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>糟糕!</strong>&nbsp;&nbsp;此題目已存在
                                      </div>
                                <?php  }?>
                                <!-- Excel -->
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">從Excel新增</a>
                                        </h4>
                                       
                                    </div>
                                    <div id="collapse1" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="content">
                                                <form name="form2" method="post" action="topicExcel_res.php" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <a href="download.php?file=Excel_sample.rar" class="btn btn-dark btn-fill btn-sm">Excel格式及說明下載</a>
                                                                <br><br>
                                                                <input type="hidden" name="leadExcel" value="true">
                                                                <input type="file" name="inputExcel" class="form-control border-input" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix">
                                                        <nav class="pull-left">
                                                            <input type="submit" value="新增" name="send" class="btn btn-info btn-md">
                                                            <input type="reset" value="清除" name="clear" class="btn btn-danger btn-md">
                                                        </nav>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!--yesno-->
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">是非題</a>
                                        </h4>
                                    </div>
                                    <div id="collapse2" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="content">
                                                <form name=f1 action=topicNew_res.php method="post" enctype="multipart/form-data" onsubmit="return chk()">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="radio" style="display:none">
                                                                    <input type="radio" name="types" value="y" checked>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label>上傳圖片</label><br>
                                                                    <img class="preview" style="max-width: 300px; max-height: 300px;">
                                                                    <input type="file" name="yn_img" class="img" required><br>
                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <label>題目</label><br>
                                                                    
                                                                    <textarea class="topic" name="yn_content" placeholder="題目" style=" width:390px; height:250px" required></textarea>
                                                                </div>
                                                            </div>
                                                            <br><br><label>正確答案</label><br>
                                                            <div class="col-lg-3">
                                                                <div class="radio">
                                                                    <input type="radio" name="yn_answer" class=radio-inline value="1" checked>O
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="radio">
                                                                    <input type="radio" name="yn_answer" class=radio-inline value="2">X
                                                                </div>
                                                            </div>
                                                            <br><br><br><br>
                                                            
                                                            
                                                            <nav class="pull-left">
                                                                <br>
                                                                <input  type=submit value="新增" class="btn btn-info btn-md">
                                                                <input  type=reset value="清除" class="btn btn-danger btn-md" onclick="resetIMG()">
                                                            </nav>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!--choose-->
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">選擇題</a>
                                        </h4>
                                    </div>
                                    <div id="collapse3" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="content">
                                                <form name=f1 action=topicNew_res.php method="post" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                    <div class="radio" style="display:none">
                                                                        <input type="radio" name="types" value="c" checked>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>上傳圖片</label><br>
                                                                        <img class="preview" style="max-width: 300px; max-height: 300px;">
                                                                        <input type="file" name="ch_img" class="img" required><br>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <label>題目</label><br>
                                                                        <textarea class=topic name="ch_content" placeholder="題目" style=" width:390px; height:250px" required></textarea>
                                                                    </div>
                                                                </div>
                                                            <span id="c_msg" style="color: red;"></span><br>
                                                            <label>答案A</label>&nbsp;&nbsp;<input type=text name=ch_ans1 class="ch_ans1" required><br>
                                                            <label>答案B</label>&nbsp;&nbsp;<input type=text name=ch_ans2 class="ch_ans2" required><br>
                                                            <label>答案C</label>&nbsp;&nbsp;<input type=text name=ch_ans3 class="ch_ans3" required><br>
                                                            <label>答案D</label>&nbsp;&nbsp;<input type=text name=ch_ans4 class="ch_ans4" required><br>
                                                          

                                                            <br><br><label>正確答案</label><br>
                                                            <div class="col-lg-3">
                                                                <div class="radio">
                                                                    <input type="radio" name=ch_answer class=radio-inline value="a" checked>A
                                                                </div>
                                                                </div>
                                                            <div class="col-lg-3">
                                                                <div class="radio">
                                                                    <input type="radio" name=ch_answer class=radio-inline value="b">B
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="radio">
                                                                    <input type="radio" name=ch_answer class=radio-inline value="c">C
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="radio">
                                                                    <input type="radio" name=ch_answer class=radio-inline value="d">D
                                                                </div>
                                                            </div>
                                                            <br>
                                                            
                                                            <nav class="pull-left">
                                                                <br>
                                                                <input type=submit id="chk_Choose" value="新增" class="btn btn-info btn-md">
                                                                <input type=reset value="清除" class="btn btn-danger btn-md" onclick="resetIMG()">
                                                            </nav>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script type="text/javascript">  //重設圖片預覽變成原本的圖片
                                    function resetIMG(){
                                      $('.preview').attr('src', '');
                                    }
                                </script>
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
