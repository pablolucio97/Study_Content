<?php
    //CONNECTION
    include_once 'php_action/db_connect_bills.php';
    //HEADER
    include_once 'includes/header.php';
    //SELECT
    if(isset($_GET['id'])):
        $id = mysqli_escape_string($connect, $_GET['id']);
        $sql = "SELECT * FROM bills WHERE id = '$id'";
        $result = mysqli_query($connect, $sql);
        $datas = mysqli_fetch_array($result);
    endif;
    
?>
