<?php

//CONNECTING AT THE DATABASE

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "loginsystem";

$connect = mysqli_connect($servername, $username, $password, $db_name);

if(mysqli_connect_error()):
    echo "Fail to connect: ".mysqli_connect_error();
endif;

