<?php
//CONNECTION
require_once 'db_connect_pannel.php';

//SESSION
session_start();


if(isset($_POST['btn-delete'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM aluns WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Delete sucessfully!";
        header('Location: ../pannel.php?sucess');
    else:
        $_SESSION["message"] = "Error to delete";
        header('Location: ../pannel.php?error');
    endif;
endif;    