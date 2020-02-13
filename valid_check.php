<?php
@session_start() ;

$tmp =  file_get_contents(__DIR__.'/.pwd') ;
$arr = explode(',', $tmp) ;
$valid_acc = $arr[0] ;
if (empty($valid_acc)) unset($_SESSION['acc']) ;
unset($tmp, $arr) ;

if (empty($_SESSION['acc']) || ($_SESSION['acc'] != $valid_acc)) {
    echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
    exit ;
}
?>