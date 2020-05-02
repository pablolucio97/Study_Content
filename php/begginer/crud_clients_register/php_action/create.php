<?php
//CONNECTION
require_once 'db_connect.php';

//SESSION
session_start();

//SQL CLEAR PROTECT
    function clear($input){
        //SQL
        global $connect;
        $var = mysqli_escape_string($connect, $input);
        //XSS (CROSS SITE SCRIPTING)
        $var = htmlspecialchars($var);
        return $var;
    }

if(isset($_POST['btn-register'])):
    $name = clear($_POST["name"]);
    $overname = clear($_POST["overname"]);
    $email = clear($_POST["email"]);
    $age = clear($_POST["age"]);
    $sql = "INSERT INTO clients (name, overname, email, age) VALUES ('$name', '$overname', '$email', '$age')";  

    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Register sucessfully!";
        header('Location: ../index.php?sucess');
    else:
        $_SESSION["message"] = "Error to Register";
        header('Location: ../index.php?error');
    endif;
endif;    