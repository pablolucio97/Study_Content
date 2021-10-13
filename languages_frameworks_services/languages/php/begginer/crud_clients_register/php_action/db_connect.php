<?php
//CONNECTION DB
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "crud";

$connect = mysqli_connect($servername, $username, $password, $db_name);

//CODETION FIX
mysqli_set_charset($connect, "utf8");
    
?>