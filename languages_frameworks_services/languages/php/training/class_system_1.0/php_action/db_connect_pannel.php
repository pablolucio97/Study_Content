<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name="classsystem1.0";

$connect = mysqli_connect($servername, $username, $password, $db_name);

//CODETION FIX
mysqli_set_charset($connect, 'utf8');

if(mysqli_connect_error()):
    echo "Error to connect: ".mysqli_connect_error();
endif;
?>