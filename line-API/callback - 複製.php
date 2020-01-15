<?php

/* 輸入申請的Line Developers 資料  */
	$channel_id = "	1548009310";
	$channel_secret = "9aa2a71a7cfe50f8b743186d3314f426";
	$channel_access_token = "WdrLo8gdf1kezUPZmcRAg28H+klFW6ZarVqZqGW3h8kx8QEe+68ZuQfOU4rt8u4Ycy8ohj/qpvMaGx+AFWvKslDHlYrzMsiXHZsc6giWYIBRhqdn3tamrwFoA9V+HTh4GaDzHlttpIuuTvVM4RlPXgdB04t89/1O/w1cDnyilFU=";


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
					
					$sql= "update line_Connect set lineConnect_lineid='$message' ,lineConnect_idWrite=0 where lineConnect_userid='$from'";
					mysql_query($sql) or die( mysql_error());
					$reply="我已經把 Line ID: ".$message." 綁定囉 ♥";
					
				}else{
					
					if ($message=="成為好朋友"){ //帳號綁定(1)
						if($from==$s_lineConn['lineConnect_userid']){ 
							$reply="我知道你唷！";
						}else{
							$reply="告訴我你的 Line ID吧！\n我會把測驗結果跟你的遊戲排名通通 Line 給你唷";
							$sql_newFriend= "insert into line_Connect(lineConnect_userid,lineConnect_idWrite) values ('$from','1')";
							mysql_query($sql_newFriend) or die( mysql_error());
						}
						
					}elseif ($message=="試煉開始"){ //進入前測(填基本資料)
						$reply="污水知識王就是你！來挑戰吧！\nhttp://163.17.9.118/userNew.php?lineID=".$s_lineConn['lineConnect_lineid'];
						
					}elseif ($message=="闖關遊戲"){ //進入遊戲
						$reply="成為最強水資源大師，收服吧！\nhttp://163.17.9.118/games/01ass/index.php?lineID=".$s_lineConn['lineConnect_lineid'];
					
					}elseif ($message=="遊戲英雄榜"){ //撈排行榜
						
						//初沉排行榜
						$sql_ass_ranking= "select * from game_score where gameScore_type = '01ass' order by gameScore_score desc limit 5";
						$sql_ass_rank=mysql_query($sql_ass_ranking) or die( mysql_error());
						
						$i_ass_rank=1;
						$reply_rank="💦初沉原理大冒險\n";
						
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
						$noTopic=["你是不是欺負我聽不懂 :((","再說一次吧!"];
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
	
	function getObjContent($filenameExtension){
			
		global $channel_access_token, $receive;
		
		$objID = $receive->events[0]->message->id;
		$url = 'https://api.line.me/v2/bot/message/'.$objID.'/content';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer {' . $channel_access_token . '}',
		));
		
		$json_content = curl_exec($ch);
		curl_close($ch);

		if (!$json_content) {
			return false;
		}
		
		//$fileURL = './update/'.$objID.'.'.$filenameExtension;
		$fileURL = 'Lighthouse.jpg';
		
		$fp = fopen($fileURL, 'w');
		fwrite($fp, $json_content);
		fclose($fp);
			
		if ($filenameExtension=="mp3"){
			//使用getID3套件分析mp3資訊
			require_once("getID3/getid3/getid3.php");
			$getID3 = new getID3;
			$fileData = $getID3->analyze($fileURL);
			//$audioInfo = var_dump($fileData);
			$playSec = floor($fileData["playtime_seconds"]);
			$re = array($myURL.$objID.'.'.$filenameExtension, $playSec*1000);
			return $re;
		}
		return $myURL.$objID.'.'.$filenameExtension;
	}
	
?>