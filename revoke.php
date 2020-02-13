<?php
require_once __DIR__.'/valid_check.php' ;
require_once __DIR__.'/pdodb.php' ;
require_once __DIR__.'/config.php' ;

//revoke notify
Function revokeNotify($tk) {
    $log = __DIR__.'/log/line_notify' ;
    if (!is_dir($log)) mkdir($log, 0777, true) ;
    $log .= '/notify_revoke_'.date("Ymd").'.log' ;
    
    $opts = [
        "http" => [
            "method" => "POST",
            "header" => "Authorization: Bearer ".$tk."\r\n".
                        "Content-Type: application/x-www-form-urlencoded\r\n",
        ]
    ] ;

    $context = stream_context_create($opts) ;
    $json = file_get_contents('https://notify-api.line.me/api/revoke', false, $context) ;
    
    file_put_contents($log, date("Y-m-d H:i:s").' tk = '.$tk.', json = '.$json."\n", FILE_APPEND) ;
    
    return json_decode($json, true) ;
}
##

$sn = $_POST['sn'] ;
if (!preg_match("/^\d+$/", $sn)) exit('NG1') ;

//
$conn = new AqbotDB ;
$sql = 'SELECT * FROM line_notify_set WHERE client_id = :cid AND client_secret = :cse AND notify_status = "Y" AND `id` = :sn;' ;
$rs = $conn->one($sql, ['cid' => $client_id, 'cse' => $client_secret, 'sn' => $sn]) ;
##

$data = array() ;
if ($rs) {
    $res = revokeNotify($rs['access_token']) ;
    if ($res['status'] == 200) {
        $sql = 'UPDATE line_notify_set SET notify_status = "N" WHERE `id` = :id;' ;
        if ($conn->exeSql($sql, ['id'=>$rs['id']])) exit('OK') ;
        else exit('NG2') ;
    }
    else exit('NG3') ;
}
else exit('NG4') ;
?>