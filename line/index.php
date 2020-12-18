<?php 

require 'environment.php';

 /*Return HTTP Request 200*/
//  http_response_code(200);

$datas = file_get_contents('php://input');
$deCode = json_decode($datas,true);
file_put_contents('log.txt', $datas . PHP_EOL, FILE_APPEND);

$replyToken = $deCode['events'][0]['replyToken'];
$userId = $deCode['events'][0]['source']['userId'];
$text = $deCode['events'][0]['message']['text'];

$replyMessages = [];
$replyMessages['replyToken'] = $replyToken;
$replyMessages['messages'][0] = getFormatTextMessage("เอ้ย ถามอะไรก็ตอบได้");

$encodeJson = json_encode($replyMessages);

$LINEDatas['url'] = "https://api.line.me/v2/bot/message/reply";
$LINEDatas['token'] = CHANNEL_ACCESS_TOKEN;

$results = sentMessage($encodeJson,$LINEDatas);
file_put_contents('log.txt', json_encode($results) . PHP_EOL, FILE_APPEND);

function getFormatTextMessage($text) {
    
    $datas = [];
    $datas['type'] = 'text';
    $datas['text'] = $text;

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
// require '../config/database.php';
//  $db = new Database();
 
?>