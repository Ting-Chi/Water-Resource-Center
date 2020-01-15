<?php

/* 輸入申請的Line Developers 資料  */
	$channel_id = "	1515460268";
	$channel_secret = "d41c5632df8bc774e4904c0a08df4fda";
	$channel_access_token = "61QINkIIbluphvdnbZppteyptXInJ08nqXKq3X7S3YEma6++Df70VkPr1OHpC8p8awguhN30180pkmd9FtalKwj5AcgStgtcpgnCH0/I+nPzspFJYACKYJ7QYhC1xiUk2g8QZ+V1wbZYsd0nQMfVSwdB04t89/1O/w1cDnyilFU=";


//  當有人發送訊息給bot時 我們會收到的json
// 	{
// 	  "events": 
// 	  [
// 		  {
// 			"replyToken": "nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",
// 			"type": "message",
// 			"timestamp": 1462629479859,
// 			"source": {
// 				 "type": "user",
// 				 "userId": "U206d25c2ea6bd87c17655609a1c37cb8"
// 			 },
// 			 "message": {
// 				 "id": "325708",
// 				 "type": "text",
// 				 "text": "Hello, world"
// 			  }
// 		  }
// 	  ]
// 	}
	
	 
	// 將收到的資料整理至變數
	$receive = json_decode(file_get_contents("php://input"));
	
	// 讀取收到的訊息內容
	$text = $receive->events[0]->message->text;
	
	// 讀取訊息來源的類型 	[user, group, room]
	$type = $receive->events[0]->source->type;
	
	// 由於新版的Messaging Api可以讓Bot帳號加入多人聊天和群組當中
	// 所以在這裡先判斷訊息的來源
	if ($type == "room")
	{
		// 多人聊天 讀取房間id
		$from = $receive->events[0]->source->roomId;
	} 
	else if ($type == "group")
	{
		// 群組 讀取群組id
		$from = $receive->events[0]->source->groupId;
	}
	else
	{
		// 一對一聊天 讀取使用者id
		$from = $receive->events[0]->source->userId;
	}
	
	// 讀取訊息的型態 [Text, Image, Video, Audio, Location, Sticker]
	$content_type = $receive->events[0]->message->type;
	
	// 準備Post回Line伺服器的資料 
	$header = ["Content-Type: application/json", "Authorization: Bearer {" . $channel_access_token . "}"];
	
	// 回覆訊息
	reply($content_type, $text);
		
	function reply($content_type, $message) {
	 
	 	global $header, $from, $receive;
	 	
		$url = "https://api.line.me/v2/bot/message/push";
		
		$data = ["to" => $from, "messages" => array(["type" => "text", "text" => $message])];
		
		switch($content_type) {
		
			case "text" :
				$content_type = "文字訊息";
				
				require_once("../mysql.php");

				$sql_lineConnect= "select * from line_Connect where lineConnect_userid='$from'";
				$sql_lineConn=mysql_query($sql_lineConnect) or die( mysql_error());
				$s_lineConn= mysql_fetch_assoc ($sql_lineConn);
				
				if ($s_lineConn['lineConnect_idWrite']==1){ //1表示可綁定帳號
					
					if (mb_strlen($message,"Big5") == strlen($message)){
						$sql= "update line_Connect set lineConnect_lineid='$message' ,lineConnect_idWrite=0 where lineConnect_userid='$from'";
						mysql_query($sql) or die( mysql_error());
						$reply="我已經把 Line ID: ".$message." 綁定囉 ♥";
					}else{
						$reply="好像有點問題耶 再試一次 ID 吧!";
					}
					
				}else{
					
					if ($message=="成為好朋友"){ //帳號綁定(1)
						if($from==$s_lineConn['lineConnect_userid']){ 
							$reply="我知道你唷！";
						}else{
							$reply="告訴我你的 Line ID吧！\n我會把測驗結果跟你的遊戲排名通通 Line 給你唷";
							$sql_newFriend= "insert into line_Connect(lineConnect_userid,lineConnect_idWrite) values ('$from','1')";
							mysql_query($sql_newFriend) or die( mysql_error());
						}
						
					}elseif ($message=="刪除"){ //進入前測(填基本資料)
						
						if(isset($s_lineConn['lineConnect_lineid'])){
							$reply="水寶已經完全不記得 ".$s_lineConn['lineConnect_lineid']." 是誰了...";
							
							$sql_delID= "delete from line_connect where lineConnect_lineid='".$s_lineConn['lineConnect_lineid']."'";
							mysql_query($sql_delID) or die( mysql_error());
						}else{
							$reply="？？？？（水寶問號）";
						}

					}elseif ($message=="試煉開始"){ //進入前測(填基本資料)
						$reply="污水知識王就是你！來挑戰吧！\nhttp://163.17.9.118/userNew.php?lineID=".$s_lineConn['lineConnect_lineid'];
						
					}elseif ($message=="闖關遊戲"){ //進入遊戲
						$reply="成為最強水資源大師，收服吧！\nhttp://163.17.9.118/index.php?lineID=".$s_lineConn['lineConnect_lineid'];
					
					}elseif ($message=="遊戲英雄榜"){ //撈排行榜
						
						//初沉排行榜
						$sql_ass_ranking= "select * from game_score where gameScore_type = '01ass' order by gameScore_score desc limit 5";
						$sql_ass_rank=mysql_query($sql_ass_ranking) or die( mysql_error());
						
						$i_ass_rank=1;
						$reply_rank="💦剷除垃圾滑水道\n";
						
						while ( $s_ass_rank =mysql_fetch_assoc($sql_ass_rank) ){
							$reply_rank=$reply_rank."\n第".$i_ass_rank."名 ★ ".$s_ass_rank['gameScore_score']." 分 － ". $s_ass_rank['gameScore_player'];
							$i_ass_rank++;
						}
						
						//污泥排行榜
						$sql_muni_ranking= "select * from game_score where gameScore_type = '05muni' order by gameScore_score desc limit 5";
						$sql_muni_rank=mysql_query($sql_muni_ranking) or die( mysql_error());
						
						$i_muni_rank=1;
						$reply_rank=$reply_rank."\n\n💦污泥壓縮小吃部\n";
						
						while ( $s_muni_rank =mysql_fetch_assoc($sql_muni_rank) ){
							$reply_rank=$reply_rank."\n第".$i_muni_rank."名 ★ ".$s_muni_rank['gameScore_score']." 分 － ". $s_muni_rank['gameScore_player'];
							$i_muni_rank++;
						}
						
						$reply=$reply_rank."\n\n下一個冠軍就是你\n快來挑戰吧 ✊"; //回傳給line伺服器的資料
						
					}else{
						$noTopic=["你是不是欺負我聽不懂 :((","再說一次吧!","真的嗎?"];
						$reply=$noTopic[rand(0,1)];
					}
				}
				
					//回傳給line伺服器(1)
					//$data = ["to" => $from, "type"=>"template","template" => array(["type" => "confirm", "text" => "確定?","actions" =>array([array(["type" =>"message", "label" =>"Yes","text" =>"yes"]),array(["type" =>"message", "label" =>"no","text"=> "no"])])])];
					$data = ["to" => $from, "messages" => array(["type" => "text", "text" => $reply])];
					
					$context = stream_context_create(array(
					"http" => array("method" => "POST", "header" => implode(PHP_EOL, $header), "content" => json_encode($data), "ignore_errors" => true)
					));
					file_get_contents($url, false, $context);
					
					//回傳給line伺服器(2)
					
					/*$message = getObjContent("https://cywater.ddns.net/assets/images/quiz/1.jpg");   // 讀取圖片內容
					$data = ["to" => $from, "messages" => array(["type" => "image", "originalContentUrl" => $message, "previewImageUrl" => $message])];

					$context = stream_context_create(array(
					"http" => array("method" => "POST", "header" => implode(PHP_EOL, $header), "content" => json_encode($data), "ignore_errors" => true)
					));
					file_get_contents($url, false, $context);*/
					
					break;
				
				
			case "image" :
				$content_type = "圖片訊息";
				$message = getObjContent("jpeg");   // 讀取圖片內容
				$data = ["to" => $from, "messages" => array(["type" => "image", "originalContentUrl" => $message, "previewImageUrl" => $message])];
				break;
				
			case "video" :
				$content_type = "影片訊息";
				$message = getObjContent("mp4");   // 讀取影片內容
				$data = ["to" => $from, "messages" => array(["type" => "video", "originalContentUrl" => $message, "previewImageUrl" => $message])];
				break;
				
			case "audio" :
				$content_type = "語音訊息";
				$message = getObjContent("mp3");   // 讀取聲音內容
				$data = ["to" => $from, "messages" => array(["type" => "audio", "originalContentUrl" => $message[0], "duration" => $message[1]])];
				break;
				
			case "location" :
				$content_type = "位置訊息";
				$title = $receive->events[0]->message->title;
				$address = $receive->events[0]->message->address;
				$latitude = $receive->events[0]->message->latitude;
				$longitude = $receive->events[0]->message->longitude;
				$data = ["to" => $from, "messages" => array(["type" => "location", "title" => $title, "address" => $address, "latitude" => $latitude, "longitude" => $longitude])];
				break;
				
			case "sticker" :
				$content_type = "貼圖訊息";
				$packageId = $receive->events[0]->message->packageId;
				$stickerId = $receive->events[0]->message->stickerId;
				$data = ["to" => $from, "messages" => array(["type" => "sticker", "packageId" => '1', "stickerId" => '120'])];
				break;
				
			default:
				$content_type = "未知訊息";
				break;
	   	}
		
		/*$context = stream_context_create(array(
		"http" => array("method" => "POST", "header" => implode(PHP_EOL, $header), "content" => json_encode($data), "ignore_errors" => true)
		));
		file_get_contents($url, false, $context);*/
	}
?>