<?php

	/* 輸入申請的Line Developers 資料  */
	$channel_id = "	1515460268";
	$channel_secret = "d41c5632df8bc774e4904c0a08df4fda";
	$channel_access_token = "61QINkIIbluphvdnbZppteyptXInJ08nqXKq3X7S3YEma6++Df70VkPr1OHpC8p8awguhN30180pkmd9FtalKwj5AcgStgtcpgnCH0/I+nPzspFJYACKYJ7QYhC1xiUk2g8QZ+V1wbZYsd0nQMfVSwdB04t89/1O/w1cDnyilFU=";

	// 準備Post回Line伺服器的資料 
	$header = ["Content-Type: application/json", "Authorization: Bearer {" . $channel_access_token . "}"];
	
	global $header, $receive;
	
	//$from = "Udae8f3db97195a54503ba4251aaa0e6f";
	
	$url = "https://api.line.me/v2/bot/message/push";
		
	
	
	if (isset($end_state)){
		$data = ["to" => $from, "messages" => array(["type" => "text", "text" => $end_state])];
		
		$context = stream_context_create(array(
		"http" => array("method" => "POST", "header" => implode(PHP_EOL, $header), "content" => json_encode($data), "ignore_errors" => true)
		));
		file_get_contents($url, false, $context);
	}
	
?>