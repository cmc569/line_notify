<?php
@session_start() ;
// require_once __DIR__.'/valid_check.php' ;
require_once __DIR__.'/config.php' ;

$fh = __DIR__.'/.pwd' ;
if (is_file($fh)) $arr = explode(',', file_get_contents($fh)) ;
else exit('Account settings missed.') ;

// if (($_POST['acc'] == 'hengstyle') && ($_POST['pwd'] == 'hengstyle123')) {
if (($_POST['acc'] == $arr[0]) && ($_POST['pwd'] == $arr[1])) {
    $_SESSION['acc'] = $_POST['acc'] ;
    unset($_POST) ;
    header('Location: '.$main_url) ;
    exit ;
}
else unset($_SESSION['acc'], $_SESSION['pwd']) ;

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

        <div style="border: 1px solid #CCC; max-width:800px;text-align: left; padding: 20px 20px 20px 20px;">
            <form method="POST">
                <div class="form-group">
                    <label for="usr"><strong>帳號：<strong></label>
                    <input type="text" class="form-control" id="acc" name="acc">
                </div>
                <div class="form-group">
                    <label for="pwd"><strong>密碼：<strong></label>
                    <input type="password" class="form-control" id="pwd" name="pwd">
                </div>
                <div>
                    <button type="submit" class="btn btn-success">登入</button>
                </div>
            </form>
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

}) ;

</script>
