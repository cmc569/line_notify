<?php
require_once __DIR__.'/pdodb.php' ;
require_once __DIR__.'/config.php' ;

// https://linebotclient.azurewebsites.net/notify/hs/index.php
// $client_id = 'dnNwsJX0nomz6ciKUVdUsn' ;
// $client_secret = 'cxxAZErgJFKPnUcV5weQS3eC18U4n1adEGhmPrjpch3' ;
// $redirect_url = 'https://linebotclient.azurewebsites.net/notify/hs/request.php' ;


// print_r($_REQUEST) ; exit ;
$code = $_GET['code'] ;
$state = $_GET['state'] ;

$response = '' ;
$alert = '' ;
if (!empty($code) && !empty($state)) {
    //取得 accesss token
    $url = 'https://notify-bot.line.me/oauth/token' ;
    $postdata = http_build_query(
        array(
             "grant_type" => "authorization_code",
             "code" => $code,
             "redirect_uri" => $redirect_url,
             "client_id" => $client_id,
             "client_secret" => $client_secret,
        )
    ) ;

    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => "Content-Type: application/x-www-form-urlencoded",
            'content' => $postdata
        )
    ) ;
    
    $context = stream_context_create($opts) ;
    $json = file_get_contents($url, false, $context) ;
    ##
    
    //紀錄 access token 資訊
    $arr = json_decode($json, true) ;
    if (($arr['status'] == 200) && !empty($arr['access_token'])) {
        $conn = new AqbotDB ;
        $sql = 'INSERT INTO line_notify_set SET notifyer = :name, client_id = :cid, client_secret = :cse, access_token = :tk, create_at = :dt, modify_at = :dt;' ;
        if ($conn->exeSql($sql, ['name'=>'hengstyle', 'cid'=>$client_id, 'cse'=>$client_secret, 'tk'=>$arr['access_token'], 'dt'=>date("Y-m-d H:i:s")])) {
            $response = '註冊綁定成功' ;
        }
        else {
            $response = '註冊綁定失敗' ;
            $alert = 'alert("'.$response.'") ;'."\n".'window.location = "/notify/hs/index.php" ;'."\n" ;
        }
    }
    else {
        $response = 'Line 授權失敗' ;
        $alert = 'alert("'.$response.'") ;'."\n".'window.location = "/notify/hs/index.php" ;'."\n" ;
    }
    ##
    
}
else {
    $response = '請重新註冊操作' ;
    $alert = 'alert("'.$response.'") ;'."\n".'window.location = "/notify/hs/index.php" ;'."\n" ;
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>AccuHit Line Notify 註冊</title>
	<meta charset="utf-8">
	<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="css/responsive.bootstrap.min.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
</head>

<body>
    <center>
        <div style="height: 50px;">
        
        </div>
        
        <h2><?=$response?></h2>
        
        <div>
            <button class="btn btn-primary" onclick="go_back()">返回</button>
        </div>
    </center>
</body>
</html>


<script src="js/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.dataTables.min.js"></script> 
<script src="js/dataTables.bootstrap.min.js"></script> 
<script src="js/dataTables.responsive.min.js"></script> 
<script src="js/responsive.bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    <?=$alert?>
}) ;

function go_back() {
    window.location = '<?=$main_url?>' ;
}
</script>
