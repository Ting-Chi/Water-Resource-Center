
<!doctype html>
<html lang="en">

<head>
  <?php require_once("head.php");?>
</head>

<body>

<?php require_once("chk_login.php");?>

<?php if(isset($_SESSION["chk"])){?>
  <div class="wrapper">
    
     <script type="text/javascript">
      $(document).ready(function(){
        $("li").removeClass("active");
        $("li.home").addClass("active");
      });  
    </script>
    
    <?php require_once("menu.php");?>
    
    <div class="main-panel">
        <?php
          $title="HOME";
          require_once("nav.php");
        ?>
      
      <div class="content">
        <div class="container-fluid">
          <div class="row">
          </div>
        </div>
      </div>
    </div>
  </div>
<?php }?>

</body>
    <?php require_once("js_file.php");?>
</html>
