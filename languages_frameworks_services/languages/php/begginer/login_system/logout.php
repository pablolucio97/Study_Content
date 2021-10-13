<?php

//ENDING SESSION

session_start();
session_unset();
session_destroy();

//REDIRECTIONING THE USER
header('Location: index.php');
