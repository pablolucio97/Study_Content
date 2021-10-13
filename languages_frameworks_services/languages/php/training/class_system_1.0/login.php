<?php
//SESSION START
session_start();

//INCLUDE
include_once "includes/header.php";

//DB CONNECTION
require_once "php_action/db_connect_login.php";

//BTN-LOGIN CLICK
if(isset($_POST["btn-login"])):
    $errors = [];

    // FILTERING INPUTS
    $login = mysqli_escape_string($connect, $_POST["login"]);
    $password = mysqli_escape_string($connect, $_POST["password"]);

    //VERIFYING IF HAS EMPTY FIELDS
    if(empty($login) or empty($password)):
        $errors[] = "<li>Please, fill the field correctly.</li>";
    else:
        //SQL CONNECT
        $SQL = "SELECT login FROM users WHERE login = '$login'";
        $result = mysqli_query($connect, $SQL);

        //VERIFYING IF HAS REGISTER ON THE DATABASE
        if(mysqli_num_rows($result) > 0):
            $password = md5($password);
            $SQL = "SELECT * FROM users WHERE login ='$login' AND password = '$password'";
            $result = mysqli_query($connect, $SQL);
            
            if(mysqli_num_rows($result) == 1):
                $datas = mysqli_fetch_array($result);
                $_SESSION['loged'] = true;
                $_SESSION['id_user'] = $datas['id'];
                header("Location: home.php");
            else:
                $errors[] = "<li>Login or password incorrect</li>";
            endif;
        else:
            $errors[] = "<li>User invalid</li>";
        endif;
    endif;
endif;

?>

<?php

    if(!empty($errors)):
        foreach($errors as $error):
            echo $error;
        endforeach;
    endif;
    
?>
<html>
<head>
    <title>System Class 1.0</title>
    <meta charset="UTF-8">
</head>

<body>

    <div class="row container light">
        <h5 class="light">Login</h5>
        <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method ="POST">
            Login:<br>
            <input type="text" name="login" placeholder="Your login">
            Password:<br>
            <input type="password" name="password" placeholder="Your password">
            <button class="btn-small light blue" name="btn-login">Login</button>
    </div>
    </body>
</html>
