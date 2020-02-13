<?php
require_once __DIR__.'/valid_check.php' ;
require_once __DIR__.'/pdodb.php' ;
require_once __DIR__.'/config.php' ;

//notify token status
Function getNotifyStatus($tk) {
    $log = __DIR__.'/log/line_notify' ;
    if (!is_dir($log)) mkdir($log, 0777, true) ;
    $log .= '/notify_status_'.date("Ymd").'.log' ;
    
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "Authorization: Bearer ".$tk."\r\n",
        ]
    ] ;

    $context = stream_context_create($opts) ;
    $json = file_get_contents('https://notify-api.line.me/api/status', false, $context) ;
    
    file_put_contents($log, date("Y-m-d H:i:s").' tk = '.$tk.', json = '.$json."\n", FILE_APPEND) ;
    
    return json_decode($json, true) ;
}
##

//
$conn = new AqbotDB ;
$sql = 'SELECT * FROM line_notify_set WHERE client_id = :cid AND client_secret = :cse AND notify_status = "Y";' ;
$rs = $conn->all($sql, ['cid' => $client_id, 'cse' => $client_secret]) ;
##

$data = array() ;
if ($rs) {
    foreach ($rs as $k => $v) {
        $gp = getNotifyStatus($v['access_token']) ;
        if ($gp['status'] == 200) {
            $data[] = array(
                $gp['target'],
                $gp['targetType'],
                $v['create_at'],
                '<button type="button" class="btn btn-danger" onclick="revoke('.$v['id'].')">解除</button>'
            ) ;
        }
    }
}

exit(json_encode(array('data' => $data))) ;
?>