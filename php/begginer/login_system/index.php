    
<?php
//CONNECTING TO DATABASE

require_once"db_connect.php";

//STARTING SESSION

session_start();

//AT CREATE INPUTS, ALWAYS USES SECURITY FILTER LIKE msqli_escape_string

if(isset($_POST["btn-enter"])):
    $errors = [];
    $login = mysqli_escape_string($connect, $_POST["login"]);
    $password = mysqli_escape_string($connect, $_POST["password"]);

    if(empty($login) or empty($password)):
        $errors [] =  "<li> The field login or password need be filled. Please, try again. </li>";
    else:
    //SQL COMMAND
        $sql = "SELECT login FROM users WHERE login = '$login'";
        $result = mysqli_query($connect, $sql);

        if (mysqli_num_rows($result) > 0):
            $password = md5($password);
            $sql = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";
            $result = mysqli_query($connect, $sql);

            if(mysqli_num_rows($result) == 1):
                $datas = mysqli_fetch_array($result);
                $_SESSION["loged"] = true;
                $_SESSION["id_user"] = $datas["id"];
                header("Location: home.php");
            else:
                $errors[] = "<li> User or password incorrect </li>";
            endif;
        else:
            $errors[] = "<li> Unexist user </li>";
        endif;
    
    endif;

endif;

?>

<html>
<head>
    <title>Login System</title>
    <meta charset="UTF-8">
</head>

<body>
<h1>Login</h1>

<?php

    if(!empty($errors)):
        foreach($errors as $error):
            echo $error;
        endforeach;
    endif;

  echo "<hr>";
    
?>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
    Name: <input type="text" name="login"><br>
    Password: <input type="password" name="password"><br>
    <button name="btn-enter" type="submit">Enter</button>

</body>
</html>
