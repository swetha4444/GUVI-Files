<?php
    session_start();
    $userData = $_SESSION['regName'];
    print_r(json_encode($userData)) ; 
?>