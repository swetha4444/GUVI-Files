<?php
    ob_start();
    include("connect.php");
    
    session_start();
    $userData = $_SESSION['regName'];
    print_r(json_encode($userData)) ;
    
    
    $iden = $userData['id'];
    
    if (array_key_exists("updateSave", $_POST))
    {
        if ($conn) 
        {
            
            $query = "UPDATE `users` SET `Name`='" . mysqli_real_escape_string($conn, $_POST['p_name']) . "' ,`Email`='" . mysqli_real_escape_string($conn, $_POST['p_email']) . "'  ,`Password`='" . mysqli_real_escape_string($conn, $_POST['p_pass']) . "' ,`DOB`='" . mysqli_real_escape_string($conn, $_POST['p_dob']) . "' ,`Profession`='" . mysqli_real_escape_string($conn, $_POST['p_prof']) . "' ,`Nationality`='" . mysqli_real_escape_string($conn, $_POST['p_nat']) . "' ,`Contact`='" . mysqli_real_escape_string($conn, $_POST['p_cont']) . "' WHERE `id`=" .$iden;
            echo $query;
            mysqli_query($conn, $query);
            
            //after update
            $query = "SELECT * FROM `users` WHERE `id`=" .$iden;
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $_SESSION['regName'] = $row;
            $userData = $_SESSION['regName'];
            //print_r($userData) ;
            mysqli_close($conn);
            //header("Location: profile.php");
        }
    }

    
    
?>