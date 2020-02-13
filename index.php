<?php
require_once __DIR__.'/valid_check.php' ;
require_once __DIR__.'/config.php' ;

// $client_id = 'dnNwsJX0nomz6ciKUVdUsn' ;
// $redirect_url = 'https://linebotclient.azurewebsites.net/notify/hs/request.php' ;
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

        <div style="width:95%;margin-left:10px;margin-rightL10px;">
            <strong>
                <button type="button" class="btn btn-primary" onclick="Auth();">連結到 LineNotify</button>
            </strong>
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>名稱</th>
                        <th>型態</th>
                        <th>建立日期</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
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
    //show table
    $('#myTable').DataTable({
        "ajax": 'get_data.php',
        "order": [[2, "desc"]],
        "searching": false,
        "info": false,
        "responsive": true,
        "lengthChange": false
    }) ;

}) ;

function Auth() {
    var URL = 'https://notify-bot.line.me/oauth/authorize?' ;
    URL += 'response_type=code' ;
    URL += '&client_id=<?=$client_id?>' ;
    URL += '&redirect_uri=<?=$redirect_url?>' ;
    URL += '&scope=notify' ;
    URL += '&state=abcde' ;
    window.location.href = URL ;
}

function revoke(id) {
    if (confirm('確認要撤銷嗎?') == true) {
        var url = 'revoke.php' ;
        $.post(url, {'sn': id}, function(txt) {
            if (txt == 'OK') {
                alert('已撤銷') ;
                location.reload() ;
            }
            else alert('Opps...') ;
        }) ;
    }
}
</script>
