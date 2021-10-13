<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name="control_family_bills";

$connect = mysqli_connect($servername, $username, $password, $db_name);

//CODETION FIX
mysqli_set_charset($connect, 'utf8');

if(mysqli_connect_error()):
    echo "Error to connect: ".mysqli_connect_error();
endif;
?>