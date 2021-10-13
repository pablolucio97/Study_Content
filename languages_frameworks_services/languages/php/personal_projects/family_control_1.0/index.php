<?php
//includes
include_once "includes/header.php";
//db connection
require_once "php_action/db_connect_login.php";
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
    <link rel="stylesheet" href="css/style.css">
    <!-- GOOGLE ICONS -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<!--TITLE-->
<body class="light grey lighten-5">
    <div class="row container col s12 m6 l3">
        <h3 class="light center"> Bem vindo ao Control Family</h2>
        <h6 class="light center">Faça login para ter acesso à aplicação</h3>
    </div>

    <!--LOGIN-->
        <div  class="row container">
        <div class="row container">
        <h4 class="light">Login <i class="material-icons">navigate_next</i></h4>
        <form class="input-field" action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
        Login: <input type="text" name="login" placeholder="Seu login"><br>
        Senha: <input type="password" name="password" placeholder="Sua senha"><br>
        <button class="btn-small blue" 
        name="btn-login">Entrar</button>
        </form>
        </div>
        </div>
        </div>
  

    <!--FOOTER-->
        <div id="footer" class="col s12 center light">
        <footer>
            <ul>
            <li> <a href="https://github.com/pablolucio97" class="white-text">Perfil GitHub<a></li>
            </ul>
             <div class="row container center col s12 white-text">
            <div class="row container col s12 center">
            <p id="pfooter">Esta aplicação é de uso particular, caso seja reproduzido o código ou parte dele, o crédito deve ser atribuído ao autor.</p>
            <p id="pfooter" class="grey-text text-lighten-2">Versão 1.0 - Testes</p>
            </div>
          </div>
        </div>
        </footer>

    <!--STYLE-->
    <style>
         #footer{
            background-image: linear-gradient(to right, rgb(105, 105, 190), rgb(0, 132, 255));
             height:199px;
             position: relative; bottom: -30px;
             text-align: center;
         }  

         #pfooter{
            text-align: center;
            position: relative; left: 215px;
         }
        
         a{
             position: relative; top:30px;
         }
       
    </style>
    
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

        //MODAL INIT
        document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems);
    });
    
    // SIDENAV INIT
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems, options);
    });

    //SCROLSPY
    document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.scrollspy');
    var instances = M.ScrollSpy.init(elems);
  });
    </script>
</body>
</html>