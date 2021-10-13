<?php
//DB CONNECTION
$servername = "localhost";
$username ="root";
$password = "";
$db_name ="loginsystem1.0";

$connect = mysqli_connect($servername, $username, $password, $db_name);

//CODETION FIX
mysqli_set_charset($connect, 'utf8');

//VERIFYING IF HAS ERROR
if(mysqli_connect_error()):
    echo "Fail to connect: ".mysqly_connect_error();
endif;
?>