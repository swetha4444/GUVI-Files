<?php
    //Error report on
    ini_set('display_errors',1);
    error_reporting(E_ALL);
    
    //Connection
    $url='sdb-b.hosting.stackcp.net';
    $username='details-3136398e9c';
    $password='happy_4444';
    $dbs='details-3136398e9c';
    $conn=mysqli_connect($url,$username,$password,$dbs);
?>