<?php
//CONNECTION DB
require_once 'db_connect_pannel.php';

//SESSION
session_start();


if(isset($_POST['btn-edit'])):
    $name = mysqli_escape_string($connect, $_POST["name"]);
    $age = mysqli_escape_string($connect, $_POST["age"]);
    $phone = mysqli_escape_string($connect, $_POST["phone"]);
    $mother = mysqli_escape_string($connect, $_POST["mother"]);
    $father = mysqli_escape_string($connect, $_POST['father']);
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE aluns SET name = '$name', age = '$age', phone = '$phone', mother = '$mother',
    father = '$father' WHERE id = '$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Update sucessfully!";
        header('Location: ../pannel.php?sucess');
    else:
        $_SESSION["message"] = "Error to update";
        header('Location: ../pannel.php?error');
    endif;
endif;    