<?php
require_once __DIR__.'/pdodb.php' ;
require_once __DIR__.'/config.php' ;

// exit ;

$msg = urldecode($_GET['msg']) ;

if (empty($msg)) exit ;

// $token = 'mK2Zln8xqeF1NZtMuIMVvOoEVMpIyWw4Q8SULaCtJ3V' ;

//取得待發送的對象
$conn = new AqbotDB ;
$sql = 'SELECT * FROM line_notify_set WHERE client_id = :cid AND client_secret = :cse AND notify_status = "Y" ORDER BY create_at ASC;' ;
$rs = $conn->all($sql, ['cid' => $client_id, 'cse' => $client_secret]) ;
##

if ($rs) {
    foreach ($rs as $k => $v) {
        sendMsg($v['access_token'], $msg) ;
    }
}

Function sendMsg($token, $msg) {
    $dir = __DIR__.'/log/line_notify' ;
    if (!is_dir($dir)) mkdir($dir, 0777, true) ;
    $log = $dir.'/notify_'.date("Ymd").'.log' ;

    $url = 'https://notify-api.line.me/api/notify' ;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "message=".$msg,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".$token,
            "content-type: application/x-www-form-urlencoded"
        ),
    )) ;

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl) ;

    $line = date("Y-m-d H:i:s")."\n============\n".'Message：'.$msg."\n".'Response：'.$response."\n".'Error Code：'.$err."\n============\n\n" ;
    file_put_contents($log, $line, FILE_APPEND) ;

    if ($err) echo "cURL Error #:" . $err ;
    else echo $response ;
}
?>