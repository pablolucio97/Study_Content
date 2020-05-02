<?php
//CONNECTION
require_once 'db_connect_pannel.php';

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
    $age = clear($_POST["age"]);
    $phone = clear($_POST["phone"]);
    $mother = clear($_POST["mother"]);
    $father = clear($_POST["father"]);
    $sql = "INSERT INTO aluns (name, age, phone, mother, father) VALUES ('$name', '$age', 
    '$phone', '$mother', '$father')";  

    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Register sucessfully!";
        header('Location: ../index.php?sucess');
    else:
        $_SESSION["message"] = "Error to Register";
        header('Location: ../index.php?error');
    endif;
endif;    