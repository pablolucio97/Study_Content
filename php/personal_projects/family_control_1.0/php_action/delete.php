<?php
//CONNECTION
require_once 'db_connect_bills.php';

//SESSION
session_start();

//JAN

if(isset($_POST['btn-deletejan'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM billsjan WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../january.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../january.php?error');
    endif;
endif; 


if(isset($_POST['btn-deletejanpro'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM profitsjan WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../january.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../january.php?error');
    endif;
endif; 

//FEB

if(isset($_POST['btn-deletefeb'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM billsfeb WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../february.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../february.php?error');
    endif;
endif;

if(isset($_POST['btn-deletefebpro'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM profitsfeb WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../february.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../february.php?error');
    endif;
endif;

//MAR

if(isset($_POST['btn-deletemar'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM billsmar WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../march.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../march.php?error');
    endif;
endif; 

if(isset($_POST['btn-deletemarpro'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM profitsmar WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../march.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../march.php?error');
    endif;
endif;

//APR

if(isset($_POST['btn-deleteapr'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM billsapr WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../april.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../april.php?error');
    endif;
endif;    

if(isset($_POST['btn-deleteaprpro'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM profitsapr WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../april.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../april.php?error');
    endif;
endif;

//MAY

if(isset($_POST['btn-deletemay'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM billsmay WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../may.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../may.php?error');
    endif;
endif;    

if(isset($_POST['btn-deletemaypro'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM profitsmay WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../may.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../may.php?error');
    endif;
endif;

//JUN

if(isset($_POST['btn-deletejun'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM billsjun WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../june.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../june.php?error');
    endif;
endif;   

if(isset($_POST['btn-deletejunpro'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM profitsjun WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../june.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../june.php?error');
    endif;
endif;

//JUL

if(isset($_POST['btn-deletejul'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM billsjul WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../july.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../july.php?error');
    endif;
endif;    

if(isset($_POST['btn-deletejulpro'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM profitsjul WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../july.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../july.php?error');
    endif;
endif;

//AGO

if(isset($_POST['btn-deleteago'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM billsago WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../agost.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../agost.php?error');
    endif;
endif;   

if(isset($_POST['btn-deleteagopro'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM profitsago WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../agost.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../agost.php?error');
    endif;
endif;

//SEP

if(isset($_POST['btn-deletesep'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM billssep WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../september.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../september.php?error');
    endif;
endif;    

if(isset($_POST['btn-deleteseppro'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM profitssep WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../september.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../september.php?error');
    endif;
endif;

//OCT

if(isset($_POST['btn-deleteoct'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM billsoct WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../octuber.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../octuber.php?error');
    endif;
endif;   

if(isset($_POST['btn-deleteoctpro'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM profitsoct WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../octuber.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../octuber.php?error');
    endif;
endif;

//NOV

if(isset($_POST['btn-deletenov'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM billsnov WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../november.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../november.php?error');
    endif;
endif; 

if(isset($_POST['btn-deletenovpro'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM profitsnov WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../november.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../november.php?error');
    endif;
endif;

//DEC

if(isset($_POST['btn-deletedec'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM billsdec WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../december.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../december.php?error');
    endif;
endif;    

if(isset($_POST['btn-deletedecpro'])):
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "DELETE FROM profitsdec WHERE id='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item eliminado com sucesso!";
        header('Location: ../december.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao eliminar item";
        header('Location: ../december.php?error');
    endif;
endif;

