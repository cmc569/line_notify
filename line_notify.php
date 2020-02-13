<?php
// https://linebotclient.azurewebsites.net/notify/hs/line_notify.php?msg=%E4%B8%AD%E6%96%87%E6%B8%AC%E8%A9%A6

require_once __DIR__.'/pdodb.php' ;
require_once __DIR__.'/config.php' ;

header('Content-Type: application/json; charset=utf-8') ;

$log = __DIR__.'/log/line_notify' ;
if (!is_dir($log)) mkdir($log, 0777, true) ;
$log .= '/line_notify_'.date("Ymd").'.log' ;

//取得參數
$msg = urldecode($_GET['msg']) ;
if (empty($msg)) exit(json_encode(array('status' => 400, 'message' => '未指定訊息內容'))) ;
##

//取得發送群組 Access Token
$conn = new AqbotDB ;
$sql = 'SELECT * FROM line_notify_set WHERE client_id = :cid AND client_secret = :cse AND notify_status = "Y" ORDER BY create_at ASC;' ;
$rs = $conn->all($sql, ['cid' => $client_id, 'cse' => $client_secret]) ;
if (empty($rs)) exit(json_encode(array('status' => 400, 'message' => '查無發送對象'))) ;
##

//開始發送
foreach ($rs as $k => $v) {
    $url = 'https://notify-api.line.me/api/notify' ;
    $postdata = http_build_query(
        array(
             "message" => $msg
        )
    ) ;

    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n".
                         "Authorization: Bearer ".$v['access_token']."\r\n",
            'content' => $postdata
        )
    ) ;

    $context = stream_context_create($opts) ;
    $json = file_get_contents($url, false, $context) ;
    
    file_put_contents($log, date("Y-m-d H:i:s").' Request = '.$postdata."\n".'Response = '.$json."\n\n", FILE_APPEND) ;
}

exit(json_encode(array('status' => 200, 'message' => '發送完成'))) ;
##
?>