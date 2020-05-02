<?php
//db connect
require_once "db_connect.php";

//includes
include_once "includes/header.php";

//session start
session_start();

//Veryfing if the user are loged
if(!isset($_SESSION['loged'])):
    header("Location: index.php");
endif;

//Datas
$id = $_SESSION['id_user'];
$SQL = "SELECT * FROM users WHERE id = '$id'";
$result = mysqli_query($connect, $SQL);
$datas = mysqli_fetch_array($result);

?>
<html>
    <head>
        <title>Restrited Page</title>
    </head>
    <body>
    <div class="light row container center">
        <h5 class="light">Hello <?php echo $datas['name'];?>! Welcome to Restrit Page</h5>
        <a href="index.php">Exit</a>
    </div>
    </body>
</html>