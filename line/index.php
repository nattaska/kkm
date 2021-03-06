<?php 

require 'environment.php';

// require '../config/database.php';
//  $db = new Database();

 /*Return HTTP Request 200*/
//  http_response_code(200);

$datas = file_get_contents('php://input');
$deCode = json_decode($datas,true);
file_put_contents('log.txt', $datas . PHP_EOL, FILE_APPEND);

$replyToken = $deCode['events'][0]['replyToken'];
$userId = $deCode['events'][0]['source']['userId'];
$text = $deCode['events'][0]['message']['text'];

$LINEDatas['url'] = "https://api.line.me/v2/bot/profile/".$userId;
$LINEDatas['token'] = CHANNEL_ACCESS_TOKEN;
$results = getLINEProfile($LINEDatas);
$userProfile = json_decode($results['message'], true);
file_put_contents('log-profile.txt', $results['message'] . PHP_EOL, FILE_APPEND);

$replyMessages = [];
$replyMessages['replyToken'] = $replyToken;
$message = "สวัสดี ".$userProfile['displayName']."
IP : ".$_SERVER['HTTP_X_FORWARDED_FOR'];
$replyMessages['messages'][0] = getFormatTextMessage($message);
$replyMessages['messages'][1] = getFormatLocationMessage("Check-In");
// $replyMessages['messages'][0] = getFormatTextMessage("สวัสดี ".$userProfile['displayName']);
// $replyMessages['messages'][1] = getFormatTextMessage("Your IP is ".$_SERVER['HTTP_X_FORWARDED_FOR']);

$encodeJson = json_encode($replyMessages);

$LINEDatas['url'] = "https://api.line.me/v2/bot/message/reply";
$LINEDatas['token'] = CHANNEL_ACCESS_TOKEN;

$results = sentMessage($encodeJson,$LINEDatas);

function getFormatTextMessage($text) {
    
    $datas = [];
    $datas['type'] = 'text';
    $datas['text'] = $text;

    return $datas;
}

function getFormatLocationMessage($text) {
    
    $datas = [];
    $datas['type'] = 'text';
    $datas['text'] = $text;
    $quickReply = '{ 
        "items": [
            {
                "type": "action",
                "action": {
                  "type": "location",
                  "label": "Send location"
                }
              }
        ]
      }';
    $datas['quickReply'] = json_decode($quickReply);

    return $datas;
}

function sentMessage($encodeJson,$datas) {

    $datasReturn = [];
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $datas['url'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $encodeJson,
        CURLOPT_HTTPHEADER => array(
        "authorization: Bearer ".$datas['token'],
        "cache-control: no-cache",
        "content-type: application/json; charset=UTF-8",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        $datasReturn['result'] = 'E';
        $datasReturn['message'] = $err;
    } else {
        if($response == "{}"){
        $datasReturn['result'] = 'S';
        $datasReturn['message'] = 'Success';
        }else{
        $datasReturn['result'] = 'E';
        $datasReturn['message'] = $response;
        }
    }

    return $datasReturn;
}

function getLINEProfile($datas)
{
   $datasReturn = [];
   $curl = curl_init();
   curl_setopt_array($curl, array(
     CURLOPT_URL => $datas['url'],
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_ENCODING => "",
     CURLOPT_MAXREDIRS => 10,
     CURLOPT_TIMEOUT => 30,
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     CURLOPT_CUSTOMREQUEST => "GET",
     CURLOPT_HTTPHEADER => array(
       "Authorization: Bearer ".$datas['token'],
       "cache-control: no-cache"
     ),
   ));
   $response = curl_exec($curl);
   $err = curl_error($curl);
   curl_close($curl);
   if($err){
      $datasReturn['result'] = 'E';
      $datasReturn['message'] = $err;
   }else{
      if($response == "{}"){
          $datasReturn['result'] = 'S';
          $datasReturn['message'] = 'Success';
      }else{
          $datasReturn['result'] = 'E';
          $datasReturn['message'] = $response;
      }
   }
   return $datasReturn;
}

// function get_mobile_ip() {

// }
 
?>