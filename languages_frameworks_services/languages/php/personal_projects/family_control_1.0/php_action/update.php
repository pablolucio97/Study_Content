<?php
//CONNECTION
require_once 'db_connect_bills.php';

//SESSION
session_start();

//Jan
//EDIT COST
if(isset($_POST['btn-edit1jan'])):
    $realized_cost = mysqli_escape_string($connect, $_POST["realized_cost"]);
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE billsjan SET realized_cost = '$realized_cost' WHERE id = '$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../january.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../january.php?error');
    endif;
endif;  

//EDIT PROFIT
if(isset($_POST['btn-edit2jan'])):
   $realized_profit = mysqli_escape_string($connect, $_POST["realized_profit"]); 
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE profitsjan SET realized_profit = '$realized_profit' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../january.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../january.php?error');
    endif;
endif;   

//Feb

if(isset($_POST['btn-edit1feb'])):
    $realized_cost = mysqli_escape_string($connect, $_POST["realized_cost"]);
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE billsfeb SET realized_cost = '$realized_cost' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../february.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../february.php?error');
    endif;
endif;  

if(isset($_POST['btn-edit2feb'])):
   $realized_profit = mysqli_escape_string($connect, $_POST["realized_profit"]); 
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE profitsfeb SET realized_profit = '$realized_profit' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../february.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../february.php?error');
    endif;
endif;   

//Mar

if(isset($_POST['btn-edit1mar'])):
    $realized_cost = mysqli_escape_string($connect, $_POST["realized_cost"]);
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE billsmar SET realized_cost = '$realized_cost' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../march.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../march.php?error');
    endif;
endif;  

if(isset($_POST['btn-edit2mar'])):
   $realized_profit = mysqli_escape_string($connect, $_POST["realized_profit"]); 
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE profitsmar SET realized_profit = '$realized_profit' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../march.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../march.php?error');
    endif;
endif;   

//Apr

if(isset($_POST['btn-edit1apr'])):
    $realized_cost = mysqli_escape_string($connect, $_POST["realized_cost"]);
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE billsapr SET realized_cost = '$realized_cost' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../april.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../april.php?error');
    endif;
endif;  

if(isset($_POST['btn-edit2apr'])):
   $realized_profit = mysqli_escape_string($connect, $_POST["realized_profit"]); 
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE profitsapr SET realized_profit = '$realized_profit' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../april.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../april.php?error');
    endif;
endif;   

//May

if(isset($_POST['btn-edit1may'])):
    $realized_cost = mysqli_escape_string($connect, $_POST["realized_cost"]);
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE billsmay SET realized_cost = '$realized_cost' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../may.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../may.php?error');
    endif;
endif;  

if(isset($_POST['btn-edit2may'])):
   $realized_profit = mysqli_escape_string($connect, $_POST["realized_profit"]); 
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE profitsmay SET realized_profit = '$realized_profit' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../may.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../may.php?error');
    endif;
endif;   



//Jun

if(isset($_POST['btn-edit1jun'])):
    $realized_cost = mysqli_escape_string($connect, $_POST["realized_cost"]);
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE billsjun SET realized_cost = '$realized_cost' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../june.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../june.php?error');
    endif;
endif;  

if(isset($_POST['btn-edit2jun'])):
   $realized_profit = mysqli_escape_string($connect, $_POST["realized_profit"]); 
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE profitsjun SET realized_profit = '$realized_profit' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../june.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../june.php?error');
    endif;
endif;   

//July

if(isset($_POST['btn-edit1jul'])):
    $realized_cost = mysqli_escape_string($connect, $_POST["realized_cost"]);
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE billsjul SET realized_cost = '$realized_cost' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../july.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../july.php?error');
    endif;
endif;  

if(isset($_POST['btn-edit2jul'])):
   $realized_profit = mysqli_escape_string($connect, $_POST["realized_profit"]); 
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE profitsjul SET realized_profit = '$realized_profit' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../july.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../july.php?error');
    endif;
endif;   


//Ago

if(isset($_POST['btn-edit1ago'])):
    $realized_cost = mysqli_escape_string($connect, $_POST["realized_cost"]);
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE billsago SET realized_cost = '$realized_cost' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../agost.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../agost.php?error');
    endif;
endif;  

if(isset($_POST['btn-edit2ago'])):
   $realized_profit = mysqli_escape_string($connect, $_POST["realized_profit"]); 
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE profitsago SET realized_profit = '$realized_profit' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../agost.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../agost.php?error');
    endif;
endif;   


//Sep

if(isset($_POST['btn-edit1sep'])):
    $realized_cost = mysqli_escape_string($connect, $_POST["realized_cost"]);
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE billssep SET realized_cost = '$realized_cost' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../september.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../september.php?error');
    endif;
endif;  

if(isset($_POST['btn-edit2sep'])):
   $realized_profit = mysqli_escape_string($connect, $_POST["realized_profit"]); 
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE profitssep SET realized_profit = '$realized_profit' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../september.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../september.php?error');
    endif;
endif;   


//Oct

if(isset($_POST['btn-edit1oct'])):
    $realized_cost = mysqli_escape_string($connect, $_POST["realized_cost"]);
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE billsoct SET realized_cost = '$realized_cost' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../octuber.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../octuber.php?error');
    endif;
endif;  

if(isset($_POST['btn-edit2oct'])):
   $realized_profit = mysqli_escape_string($connect, $_POST["realized_profit"]); 
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE profitsoct SET realized_profit = '$realized_profit' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../octuber.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../octuber.php?error');
    endif;
endif;   


//Nov

if(isset($_POST['btn-edit1nov'])):
    $realized_cost = mysqli_escape_string($connect, $_POST["realized_cost"]);
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE billsnov SET realized_cost = '$realized_cost' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../november.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../november.php?error');
    endif;
endif;  

if(isset($_POST['btn-edit2nov'])):
   $realized_profit = mysqli_escape_string($connect, $_POST["realized_profit"]); 
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE profitsnov SET realized_profit = '$realized_profit' WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../november.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../november.php?error');
    endif;
endif;   


//Dec

if(isset($_POST['btn-edit1dec'])):
    $realized_cost = mysqli_escape_string($connect, $_POST["realized_cost"]);
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE billsdec SET realized_cost = $realized_cost WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../december.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../december.php?error');
    endif;
endif;  

if(isset($_POST['btn-edit2dec'])):
   $realized_profit = mysqli_escape_string($connect, $_POST["realized_profit"]); 
    $id = mysqli_escape_string($connect, $_POST["id"]);
    $sql = "UPDATE profitsdec SET realized_profit = $realized_profit WHERE id ='$id'";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Atualização realizada com sucesso!";
        header('Location: ../december.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao atualizar item.";
        header('Location: ../december.php?error');
    endif;
endif;   

