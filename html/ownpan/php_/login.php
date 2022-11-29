<?php

    session_start(); // Starting Session

    include('conf_/basic.php'); // Includes Config
    $error=''; // Variable To Store Error Message

    if (isset($_POST['submit'])) {

        if (empty($_POST['username']) || empty($_POST['password'])) {

            $error = "Username or Password is invalid";
        
        } else {
            
            // Define $username and $password
            $username=$_POST['username'];
            $password=$_POST['password'];

            if (($username == $localusr) && ($password == $localpwd)) {

                $_SESSION['login_user']=$username; // Initializing Session
                header("location: php_/profile.php"); // Redirecting To Other Page
            
            } else {

                $error = "Username or Password is invalid";
            
            }
        }
    }
