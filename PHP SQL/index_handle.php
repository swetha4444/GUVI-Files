<?php
    ob_start();
    session_start();
      
    include("connect.php");
      
      
      
      $db_error  = '';
      $error     = '';
      $message   = '';

    if (array_key_exists("signInCheck",$_POST)) 
    {
        $email    = $_POST['email'];
        $password = $_POST['pass'];
        
            if ($email === '' || $password === '') 
            {
                //echo "Allowed! signInCheck ";
                $_POST["error"] = "You must enter your email address and password";
            }
            else 
            {
                //echo "Allowed! signInCheck ";
              $_POST["dberror"]  = $conn ? '' : '<strong>Error connecting to database</strong>: ' . mysqli_connect_errno() . ', ' . mysqli_connect_error();
        
              if ($conn) 
              {
                    $email    = mysqli_real_escape_string($conn, $email);
            
                    $query  = "SELECT * FROM `users` WHERE `Email`='$email'";
                    $result = mysqli_query($conn, $query);
            
                    if (mysqli_num_rows($result) === 1) 
                    {
                          $row = mysqli_fetch_assoc($result);
            
                          if ($password == $row['Password'])
                          {

                              $_SESSION['regName'] = $row;
                              $_POST["signInCheck"]="allowSignIn";
                          }
                          else
                          {
                              $_POST["error"] = "Password not recognised";
                          }
                    }
                    else 
                    {
                         $_POST["error"] = "That email address or password has not been recognised";
                    }
                    mysqli_close($conn);
              }
           }
           
          print_r(json_encode($_POST));
           
           /*
           
        if(!empty($_POST["remember-me"])) 
        {
        	setcookie ("username",$_POST["email"],time()+ 3600);
        	setcookie ("password",$_POST["pass"],time()+ 3600);
        	echo "Cookies Set Successfuly";
        } 
        else 
        {
        	setcookie("username","");
        	setcookie("password","");
        	echo "Cookies Not Set";
        }
        
        */
    }
?>