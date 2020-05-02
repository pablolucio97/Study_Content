<?php
//includes
include_once "includes/header.php";
//db connection
require_once "db_connect.php";
//staring session
session_start();

if(isset($_POST['btn-login'])):
    $errors = [];
    // Filtering the inputs
    $login = mysqli_escape_string($connect, $_POST['login']);
    $password = mysqli_escape_string($connect, $_POST['password']);

    //Verifying if the fields are empty
    if(empty($login) or empty($password)):
        $errors [] = "<li>The field login or password are empty. Please, try again!</li>";
    else:
        //SQL CONNECTION
        $SQL = "SELECT login FROM users WHERE login = '$login'";
        $result = mysqli_query($connect, $SQL);

        //Verifyin if has register on the database
        if(mysqli_num_rows($result) > 0):
            $password = md5($password);
            $SQL = "SELECT * FROM users WHERE login ='$login' AND password = '$password'";
            $result = mysqli_query($connect, $SQL);

            if(mysqli_num_rows($result) == 1):
                $data = mysqli_fetch_array($result);
                $_SESSION['loged']= true;
                $_SESSION['id_user']= $data['id'];
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
    <title>Login System</title>
    <meta charset="UTF-8">
</head>

<body>

    <div class="row container light">
        <h4 class="light">Login</h4>
        <form  action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
            Login:<br>
            <input type="text" name="login" placeholder="Your login">
            Password:<br>
            <input type="password" name="password" placeholder="Your password">
            <button class="btn-small light blue" name="btn-login">Login</button>
    </div>
    </body>
</html>


