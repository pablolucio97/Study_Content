<?php
//includes
include_once "includes/header.php";
//db connection
require_once "db_connect.php";
//staring session
session_start();

//=======================LOGIN=============================
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
            $SQLDelete = "DELETE * FROM users WHERE login = 'admin'";  

            if(mysqli_num_rows($result) == 1):
                $data = mysqli_fetch_array($result);
                $_SESSION['loged']= true;
                $_SESSION['id_user']= $data['id'];
                header("Location: home.php");
            else:
                $_SESSION['message'] = "Login or password incorrect";
            endif;
        else:
            $_SESSION['message'] = "User invalid";
         endif;
    endif;
endif;

?>

<?php

    if(!empty($errors)):
        foreach($errors as $error):
        endforeach;
    endif;

//=======================REGISTER=============================

//SQL CLEAR PROTECT
function clear($input){
    //SQL
    global $connect;
    $var = mysqli_escape_string($connect, $input);
    //XSS (CROSS SITE SCRIPTING)
    $var = htmlspecialchars($var);
    return $var;
}

if(isset($_POST['btn-register'])):
$name = clear($_POST["name"]);
$login = clear($_POST["login"]);
$email = clear($_POST["email"]);
$password = clear($_POST["password"]);
$password = md5($password);
$SQL = "INSERT INTO users (name, login, email, password) VALUES ('$name', '$login', 
'$email', '$password')";


if (mysqli_query($connect, $SQL)):
   $_SESSION["message"] = "Register sucessfully!";
    header('Location: index.php?sucess');
else:
   $_SESSION["message"] = "Error to register";
    header('Location: index.php?error');
endif;
    if(empty($name) or empty($login) or empty($email) or empty($password)):
        $_SESSION['message'] = "Error to register, please verify if has same field empty";
endif;
endif;
/*
//AVOID DUPLICATE EMAIL
$duplicateEmail = "SELECT email FROM users WHERE email = '$email'";

$duperaw = mysqli_query($connect, $duplicateEmail);

if(mysqli_num_rows($duperaw)>0):
    $_SESSION['message'] = "Error to register, email already exists";
endif;

//AVOID DUPLICATE LOGIN

$duplicateLogin = "SELECT login FROM users WHERE login = '$email'";

$duperaw = mysqli_query($connect, $duplicateLogin);
if(mysqli_num_rows($duperaw)>0):
    $_SESSION['message'] = "Error to register, login already exists";
endif;

//REMOVE ALL DUPLICATE DATA

$SQL = "DELETE * FROM users WHERE login = 'admin'";
*/
?>


<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial scale = 1.0">
    <meta name="desription" content="Client Register - Crud">
    <title></title>
    <link rel="icon" href="">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <!--MATERILIZE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!--FONT AWESOME-->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!--LOCAL CSS-->
    <link rel="stylesheet" href="">
    <!-- GOOGLE ICONS -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div class="row container col s12">
        <h3 class="light center"> Welcome to our Website</h3>
        <h5 class="light center">Please do a login or register to acess our content</h5>
        <div class="row container col s12 m6 l4">
       
        <h3 class="light">Register <i class="material-icons">edit</i></h3>
        <form class="input-field" action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
        Name: <input type="text" name="name" placeholder="Type your name"><br>
        Login: <input type="text" name="login" placeholder="Choice a login "><br>
        Email: <input type="email" name="email" placeholder="Type your email"><br>
        Password: <input type="password" name="password" placeholder="Define your password"><br>
        <button class="btn-small blue" name="btn-register">Register</button>
        </form>
        </div>
        <div class="row container col s12 m6 l2">
        </div>
        <div class="row container col s12 m6 l4">
        <h3 class="light">Login <i class="material-icons">send</i></h3>
        <form class="input-field" action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
        Login: <input type="text" name="login" placeholder="Your login"><br>
        Password: <input type="password" name="password" placeholder="Your password"><br>
        <button class="btn-small blue" 
        name="btn-login">Login</button>
        </form>
        </div>
    </div>

    
 <!--LOCAL JS-->
 <script src=""></script>
        <!--JQUERY-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <!-- MATERIALIZE JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <!--JAVASCRIPT-->
        <script type="text/javascript">
        //INICIALIZAÇÃO
        $(document).ready(function(){
        });
        M.toast({html:'<?php echo $_SESSION['message']; ?>'})
    </script>
        <!--MODAL-INIT-->
    <script>
     document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems);
  });
      </script>
</body>
</html>