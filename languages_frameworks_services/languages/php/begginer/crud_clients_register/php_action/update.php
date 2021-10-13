<?php
//CONNECTION
require_once 'db_connect.php';

//SESSION
session_start();


if(isset($_POST['btn-edit'])):
    $name = mysqli_escape_string($connect, $_POST["name"]);
    $overname = mysqli_escape_string($connect, $_POST["overname"]);
    $email = mysqli_escape_string($connect, $_POST["email"]);
    $age = mysqli_escape_string($connect, $_POST["age"]);
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE clients SET name = '$name', overname = '$overname', email = '$email', age = '$age' WHERE id = '$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Update sucessfully!";
        header('Location: ../index.php?sucess');
    else:
        $_SESSION["message"] = "Error to update";
        header('Location: ../index.php?error');
    endif;
endif;    