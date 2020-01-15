<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">

	<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
	<script src="js/jquery-accordion-menu.js" type="text/javascript"></script>
 	<!--<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>-->
    <script>
        $(document).ready(function(){
            $('.inputform').focus(function(){
                $(this).css("border-color","#006cff")
            })
            $('.inputform').blur(function(){
                $(this).css("border-color","")
            })
            var rule1=/^.{3,5}$/;
            $("#nickname").blur(function(){
                if(rule1.test($(this).val())){
                    $('.error1').text('')
                    $(this).css("border-color","green")
                }else{
                    $('.error1').text('不符合規則，請輸入3-5個任意文字')
                    $(this).css("border-color","red")
                }
            })
            var rule2=/^[A-Z]\d{6}$/;
            $("#number").blur(function(){
                if(rule2.test($(this).val())){
                    $('.error2').text('')
                    $(this).css("border-color","green")
                }else{
                    $('.error2').text('不符合規則，請輸入大寫英文字母，並接上6位數字')
                    $(this).css("border-color","red")
                }
            })
            var rule3=/09\d{8}/;
            $("#phone").blur(function(){
                if(rule3.test($(this).val())){
                    $('.error3').text('')
                    $(this).css("border-color","green")
                }else{
                    $('.error3').text('不符合規則，請輸入「09xxxxxxxx」')
                    $(this).css("border-color","red")
                }
            })
            var rule4=/^0(2|3|4|5|6|7|8)\d{0,2}-\d{6,8}$/;
             $("#mobile").blur(function(){
                if(rule4.test($(this).val())){
                    $('.error4').text('')
                    $(this).css("border-color","green")
                }else{
                    $('.error4').text('不符合規則，請輸入「區碼-xxxxxx」')
                    $(this).css("border-color","red")
                }
            })
        })
    </script> 

</head>
<body>
	<form>
    <label for='nickname'>暱稱</label>：<input type='text' id='nickname' class='inputform' placeholder="輸入暱稱"><span class='error1'></span><br>

    <label for='number'>學號</label>：<input type='text' id='number' class='inputform' placeholder="輸入學號"><span class='error2'></span><br>

    <label for='phone'>電話</label>：<input type='text' id='phone' class='inputform' placeholder="輸入電話"><span class='error3'></span><br>

    <label for='mobile'>手機</label>：<input type='text' id='mobile' class='inputform' placeholder="輸入手機"><span class='error4'></span><br>
    
    <label for='address'>地址</label>：<input type='text' id='address' class='inputform' placeholder="輸入地址"><br>
</form>
</body>
</html>