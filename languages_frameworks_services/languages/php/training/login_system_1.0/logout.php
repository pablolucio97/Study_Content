<?php
//ENDING SESSION
session_start();
session_unset();
session_destroy():

//REDIRECTING THE USER 
header("Location: index.php");
?>