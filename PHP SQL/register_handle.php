<?php
    include("connect.php");
    
    session_start();
    
    $db_error  = '';
    $error     = '';
    $message   = '';

    if (array_key_exists("signUpCheck",$_POST)) 
    {
        $email    = $_POST['email'];
        $name     = $_POST['name'];
        $password = $_POST['pass'];
        $dob      = $_POST['dob'];
        $cont     = $_POST['cont'];
        $prof     = $_POST['prof'];
        $nat      = $_POST['nat'];

        if ($email === '' || $password === '') 
        {
          $_POST["error"] = "An email address and password are required";
        }
        else 
        {
          $_POST["dberror"]= $conn ? '' : '<strong>Error connecting to database</strong>: ' . mysqli_connect_errno() . ', ' . mysqli_connect_error();
    
          if ($conn) 
          {
    
            $query  = "SELECT `id` FROM `users` WHERE `email`='$email'";
            $result = mysqli_query($conn, $query);
    
            if (mysqli_num_rows($result) > 0) 
            {
                $_POST["error"] = 'This Email ID Already Exists. Register with another email!';
            }
            else 
            {
              $query="INSERT INTO `users` (`Name`, `Email`, `DOB`, `Contact`, `Password`, `Profession`, `Nationality`) VALUES ('$name', '$email', '$dob', '$cont', '$password', '$prof', '$nat')";
              if (mysqli_query($conn, $query)) 
              {
                $message = "You have been signed up successfully";
                $query  = "SELECT * FROM `users` WHERE `Email`='$email'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $_SESSION['regName'] = $row;
                $_POST["signUpCheck"]="allowSignUp";
                //header('Location: profile.php');
              }
              else 
              {
                $_POST["error"] = "There was a problem signing you up: " . mysqli_connect_errno() . ', ' . mysqli_connect_error();
              }
            }
    
            mysqli_close($conn);
          }
        }
        
        print_r(json_encode($_POST));
    }
?>