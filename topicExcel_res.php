<!DOCTYPE html>
<html>
<head>
	<title></title>

	<meta charset="utf-8">
</head>
<body>
<?php
	include_once ('mysql.php');
	if (isset($_POST["send"])) {
		$leadExcel=$_POST["leadExcel"];;

		if($leadExcel == "true"){

			//獲取上傳的文件名
			$filename = $_FILES['inputExcel']['name'];

			//上傳到服務器上的臨時文件名
			$tmp_name = $_FILES['inputExcel']['tmp_name'];
			$msg = uploadFile($filename,$tmp_name);
		}
	}
	/*if (isset($_POST["clear"])) {
		$sql = "TRUNCATE TABLE net_mailuser";
		if(!mysql_query($sql)){
			return false;
		}
		echo '<script>alert(\'電子報會員資料已清空！\');window.location=\'test1.php\';</script>';
	}*/
	?>

	<?php
	//導入Excel文件
	function uploadFile($file,$filetempname) {
		//自己設置的上傳文件存放路徑
		$filePath = 'uploads/';
		$str = ""; 

		require_once("Classes/PHPExcel/IOFactory.php");

		$filename=explode(".",$file);//把上傳的文件名以「.」好為準做一個數組。
		$time=date("y-m-d-H-i-s");//去當前上傳的時間
		$filename[0]=$time;//取文件名替換
		$name=implode(".",$filename); //上傳後的文件名
		$uploadfile=$filePath.$name;//上傳後的文件名地址

		//move_uploaded_file() 函數將上傳的文件移動到新位置。若成功，則返回 true，否則返回 false。
		$result=move_uploaded_file($filetempname,$uploadfile);//假如上傳到當前目錄下
		if($result) { //如果上傳文件成功，就執行導入excel操作

			$objPHPExcel = PHPExcel_IOFactory::load($uploadfile);
			$objPHPExcel->setActiveSheetIndex(0);
			$sheet = $objPHPExcel->getActiveSheet();
			$highestRow = $sheet->getHighestRow(); // 取得總行數
			$highestColumn = $sheet->getHighestColumn(); // 取得總列數
			$topicField = array("topic_types", "topic_content",	"topic_a1",	"topic_a2",	"topic_a3", "topic_a4",	"topic_ans");
			$FieldNum = 0;

			//循環讀取excel文件,讀取一條,插入一條
			for($j=1;$j<=$highestRow;$j++){
				for($k='A';$k<=$highestColumn;$k++){
					if ($j == 1){
						$a = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
						if ( $a != $topicField[$FieldNum]){
							echo '<script>alert(\'Excel欄位格式有錯！請依照範例檔案格式！\');window.location=\'topicNew.php\';</script>';
						}
						$FieldNum ++;
					}
					$str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().','; 
					//讀取單元格	
				}

				$strs = explode(",",$str);//explode:函數把字符串分割為陣列
				//print_r($strs)."<br>";

				require_once("mysql.php");
  				$sql = "select * from topic";
  				$result=mysql_query($sql) or die(mysql_error());
  				$num = mysql_num_rows($result);

  				for ($i = 1; $i <= $num; $i++)	{
					$row = mysql_fetch_assoc($result);

					if ($row["topic_content"]==$strs[1]){
						$sql = "UPDATE `topic` set `topic_types`='$strs[0]',`topic_img`='2017_11_10 02_26_47.jpg', `topic_a1`='$strs[2]', `topic_a2`='$strs[3]', `topic_a3`='$strs[4]', `topic_a4`='$strs[5]', `topic_ans`='$strs[6]' where topic_content = '$strs[1]' ";
  						mysql_query($sql) or die(mysql_error());
  						$i = $num+1;
					}

					if ($i==$num) {
						$sql = "INSERT INTO topic(topic_types,topic_content,topic_img,topic_a1,topic_a2,topic_a3,topic_a4,topic_ans) VALUES('$strs[0]','$strs[1]','2017_11_10 02_26_47.jpg','$strs[2]','$strs[3]','$strs[4]','$strs[5]','$strs[6]')";
  						mysql_query($sql) or die(mysql_error());
					}
				}

				$str = ""; 
			}
				echo '<script>alert(\'新增完成！\');window.location=\'topic.php\';</script>';

			unlink($uploadfile); //刪除上傳的excel文件	

		}else{
			echo '<script>alert(\'請選擇檔案！\');window.location=\'topicNew.php\';</script>';	
		}
	}
?>

</body>
</html>