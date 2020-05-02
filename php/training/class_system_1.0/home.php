
<?php
//CONNECTING TO DATABASE
require_once "php_action/db_connect_login.php";

//includes
include_once "includes/header.php";

//SESSION START
session_start();

////VERIFICATING IF THE USER ARE LOGED
if(!isset($_SESSION['loged'])):
    header('Location: index.php');
endif;

//DATA
$id = $_SESSION['id_user'];
$SQL = "SELECT * FROM users WHERE id ='$id'";
$result = mysqli_query($connect, $SQL);
$data = mysqli_fetch_array($result);

?>

<html>
    <head>
        <title>Restrited Page</title>
    </head>
    <body>
    <div class="light row container center">
        <h5 class="light"> Welcome to System Class 1.0</h5><br>
        <ul>
        <li><a href="pannel.php">Go to Administrative Pannel</a></li><br>
        <li><a href="index.php">Exit</a></li>
        </ul
        
    </div>
    </body>
</html>