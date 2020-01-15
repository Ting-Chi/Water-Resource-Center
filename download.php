<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>

</body>
</html>
<?php 
	$file = $_GET["file"];
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".basename($file));
	header("Content-Transfer-Encoding: binary");
	$fd = fopen($file, "rb");  //大檔案下載的解決方法～readfile($file)會出問題～
	if($fd)
	{
	    ob_end_clean();
	    fpassthru($fd);
	}
	fclose($fd);
?>
