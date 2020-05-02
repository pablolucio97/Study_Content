<?php
//CONNECTION
require_once 'db_connect_bills.php';


//SESSION
session_start();


//SQL CLEAR PROTECT
function clear($input){
    //SQL
    global $connect;
    $var = mysqli_escape_string($connect, $input);
    //XSS (CROSS SITE SCRIPTING)
    $var = htmlspecialchars($var);
    return $var;
}


//ADD VALUE TO ACCOUNT SAVINGS

if(isset($_POST['btn-sum'])):
    $valueSavings = clear($_POST["value_savings"]);
    
    
    $sql = "INSERT INTO savings (value_savings, month, year) VALUES ($valueSavings, $month,
    $year)";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../savings.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../savings.php?error');
    endif;
endif;  

//REMOVE VALUE OF ACCOUNT SAVINGS

if(isset($_POST['btn-wit'])):
    $valueSavings = clear($_POST["value_savings"]);
    
    
    $sql = "INSERT INTO savings (value_savings, month, year) VALUES ($valueSavings, $month,
    $year)";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../savings.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../savings.php?error');
    endif;
endif;  


//MONTHS INSERT INTO

//JAN
//ADD BILLS
if(isset($_POST['btn-addjan'])):
    $item = clear($_POST["item"]);
    $previous_cost = clear($_POST["previous_cost"]);
    $realized_cost = clear($_POST["realized_cost"]);
    $sql = "INSERT INTO billsjan (item, previous_cost, realized_cost) VALUES ('$item', $previous_cost, $realized_cost)";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../january.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../january.php?error');
    endif;
endif; 

//ADD EXTRA PROFIT
if(isset($_POST['btn-addjan1'])):
    $profit = clear($_POST["name_profit"]);
    $realized_profit = clear($_POST["realized_profit"]);
    $previous_profit = clear($_POST["previous_profit"]);
    $sql = "INSERT INTO profitsjan (name_profit, previous_profit, realized_profit) VALUES ('$profit', '$previous_profit', 
    '$realized_profit')";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../january.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../january.php?error');
    endif;
endif; 

//FEB
if(isset($_POST['btn-addfeb'])):
    $item = clear($_POST["item"]);
    $previous_cost = clear($_POST["previous_cost"]);
    $realized_cost = clear($_POST["realized_cost"]);
    $sql = "INSERT INTO billsfeb (item, previous_cost, realized_cost) VALUES ('$item', $previous_cost, $realized_cost)";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../february.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../february.php?error');
    endif;
endif; 

//ADD EXTRA PROFIT
if(isset($_POST['btn-addfeb1'])):
    $profit = clear($_POST["name_profit"]);
    $realized_profit = clear($_POST["realized_profit"]);
    $previous_profit = clear($_POST["previous_profit"]);
    $sql = "INSERT INTO profitsfeb (name_profit, previous_profit, realized_profit) VALUES ('$profit', '$previous_profit', 
    '$realized_profit')";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../february.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../february.php?error');
    endif;
endif; 

//MAR
if(isset($_POST['btn-addmar'])):
    $item = clear($_POST["item"]);
    $previous_cost = clear($_POST["previous_cost"]);
    $realized_cost = clear($_POST["realized_cost"]);
    $sql = "INSERT INTO billsmar(item, previous_cost, realized_cost, month, year) VALUES ('$item', $previous_cost, $realized_cost)";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../march.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../march.php?error');
    endif;
endif; 

//ADD EXTRA PROFIT
if(isset($_POST['btn-addmar1'])):
    $profit = clear($_POST["name_profit"]);
    $realized_profit = clear($_POST["realized_profit"]);
    $previous_profit = clear($_POST["previous_profit"]);
    $sql = "INSERT INTO profitsmar (name_profit, previous_profit, realized_profit) VALUES ('$profit', '$previous_profit', 
    '$realized_profit')";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../march.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../march.php?error');
    endif;
endif; 

//APR
if(isset($_POST['btn-addapr'])):
    $item = clear($_POST["item"]);
    $previous_cost = clear($_POST["previous_cost"]);
    $realized_cost = clear($_POST["realized_cost"]);
    $sql = "INSERT INTO billsapr (item, previous_cost, realized_cost) VALUES ('$item', $previous_cost, $realized_cost)";
        if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../april.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../april.php?error');
    endif;
endif; 

//ADD EXTRA PROFIT
if(isset($_POST['btn-addapr1'])):
    $profit = clear($_POST["name_profit"]);
    $realized_profit = clear($_POST["realized_profit"]);
    $previous_profit = clear($_POST["previous_profit"]);
    $sql = "INSERT INTO profitsapr (name_profit, previous_profit, realized_profit) VALUES ('$profit', '$previous_profit', 
    '$realized_profit')";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../april.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../april.php?error');
    endif;
endif; 

//MAY
if(isset($_POST['btn-addmay'])):
    $item = clear($_POST["item"]);
    $previous_cost = clear($_POST["previous_cost"]);
    $realized_cost = clear($_POST["realized_cost"]);
    $sql = "INSERT INTO billsmay (item, previous_cost, realized_cost) VALUES ('$item', $previous_cost, $realized_cost)";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../may.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../may.php?error');
    endif;
endif; 

//ADD EXTRA PROFIT
if(isset($_POST['btn-addmay1'])):
    $profit = clear($_POST["name_profit"]);
    $realized_profit = clear($_POST["realized_profit"]);
    $previous_profit = clear($_POST["previous_profit"]);
    $sql = "INSERT INTO profitsmay (name_profit, previous_profit, realized_profit) VALUES ('$profit', '$previous_profit', 
    '$realized_profit')";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../may.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../may.php?error');
    endif;
endif; 

//JUN
if(isset($_POST['btn-addjun'])):
    $item = clear($_POST["item"]);
    $previous_cost = clear($_POST["previous_cost"]);
    $realized_cost = clear($_POST["realized_cost"]);
    $sql = "INSERT INTO billsjun (item, previous_cost, realized_cost) VALUES ('$item', $previous_cost, $realized_cost)";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../june.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../june.php?error');
    endif;
endif; 

//ADD EXTRA PROFIT
if(isset($_POST['btn-addjun1'])):
    $profit = clear($_POST["name_profit"]);
    $realized_profit = clear($_POST["realized_profit"]);
    $previous_profit = clear($_POST["previous_profit"]);
    $sql = "INSERT INTO profitsjun (name_profit, previous_profit, realized_profit) VALUES ('$profit', '$previous_profit', 
    '$realized_profit')";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../june.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../june.php?error');
    endif;
endif; 

//JUL
if(isset($_POST['btn-addjul'])):
    $item = clear($_POST["item"]);
    $previous_cost = clear($_POST["previous_cost"]);
    $realized_cost = clear($_POST["realized_cost"]);    
    $sql = "INSERT INTO billsjul (item, previous_cost, realized_cost) VALUES ('$item', $previous_cost, $realized_cost)";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../july.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../july.php?error');
    endif;
endif; 

//ADD EXTRA PROFIT
if(isset($_POST['btn-addjul1'])):
    $profit = clear($_POST["name_profit"]);
    $realized_profit = clear($_POST["realized_profit"]);
    $previous_profit = clear($_POST["previous_profit"]);
    $sql = "INSERT INTO profitsjul (name_profit, previous_profit, realized_profit) VALUES ('$profit', '$previous_profit', 
    '$realized_profit')";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../july.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../july.php?error');
    endif;
endif; 

//AGO
if(isset($_POST['btn-addago'])):
    $item = clear($_POST["item"]);
    $previous_cost = clear($_POST["previous_cost"]);
    $realized_cost = clear($_POST["realized_cost"]);
    
    
    $sql = "INSERT INTO billsago (item, previous_cost, realized_cost) VALUES ('$item', $previous_cost, $realized_cost)";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../agost.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../agost.php?error');
    endif;
endif; 

//ADD EXTRA PROFIT
if(isset($_POST['btn-addago1'])):
    $profit = clear($_POST["name_profit"]);
    $realized_profit = clear($_POST["realized_profit"]);
    $previous_profit = clear($_POST["previous_profit"]);
    $sql = "INSERT INTO profitsago (name_profit, previous_profit, realized_profit) VALUES ('$profit', '$previous_profit', 
    '$realized_profit')";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../agost.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../agost.php?error');
    endif;
endif; 

//SEP
if(isset($_POST['btn-addsep'])):
    $item = clear($_POST["item"]);
    $previous_cost = clear($_POST["previous_cost"]);
    $realized_cost = clear($_POST["realized_cost"]);
    $sql = "INSERT INTO billssep (item, previous_cost, realized_cost) VALUES ('$item', $previous_cost, $realized_cost)";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../september.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../september.php?error');
    endif;
endif; 

//ADD EXTRA PROFIT
if(isset($_POST['btn-addsep1'])):
    $profit = clear($_POST["name_profit"]);
    $realized_profit = clear($_POST["realized_profit"]);
    $previous_profit = clear($_POST["previous_profit"]);
    $sql = "INSERT INTO profitssep (name_profit, previous_profit, realized_profit) VALUES ('$profit', '$previous_profit', 
    '$realized_profit')";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../september.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../september.php?error');
    endif;
endif; 

//OCT
if(isset($_POST['btn-addoct'])):
    $item = clear($_POST["item"]);
    $previous_cost = clear($_POST["previous_cost"]);
    $realized_cost = clear($_POST["realized_cost"]);
    $sql = "INSERT INTO billsoct (item, previous_cost, realized_cost) VALUES ('$item', $previous_cost, $realized_cost)";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../octuber.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../octuber.php?error');
    endif;
endif; 

//ADD EXTRA PROFIT
if(isset($_POST['btn-addoct1'])):
    $profit = clear($_POST["name_profit"]);
    $realized_profit = clear($_POST["realized_profit"]);
    $previous_profit = clear($_POST["previous_profit"]);
    $sql = "INSERT INTO profitsoct (name_profit, previous_profit, realized_profit) VALUES ('$profit', '$previous_profit', 
    '$realized_profit')";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../octuber.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../octuber.php?error');
    endif;
endif; 

//NOV
if(isset($_POST['btn-addnov'])):
    $item = clear($_POST["item"]);
    $previous_cost = clear($_POST["previous_cost"]);
    $realized_cost = clear($_POST["realized_cost"]);
    $sql = "INSERT INTO billsnov (item, previous_cost, realized_cost) VALUES ('$item', $previous_cost, $realized_cost)";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../november.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../november.php?error');
    endif;
endif; 

//ADD EXTRA PROFIT
if(isset($_POST['btn-addnov1'])):
    $profit = clear($_POST["name_profit"]);
    $realized_profit = clear($_POST["realized_profit"]);
    $previous_profit = clear($_POST["previous_profit"]);
    $sql = "INSERT INTO profitsnov (name_profit, previous_profit, realized_profit) VALUES ('$profit', '$previous_profit', 
    '$realized_profit')";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../november.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../november.php?error');
    endif;
endif; 

//DEC
if(isset($_POST['btn-adddec'])):
    $item = clear($_POST["item"]);
    $previous_cost = clear($_POST["previous_cost"]);
    $realized_cost = clear($_POST["realized_cost"]);
   $sql = "INSERT INTO billsdec (item, previous_cost, realized_cost) VALUES ('$item', $previous_cost, $realized_cost)";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../december.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../december.php?error');
    endif;
endif; 

//ADD EXTRA PROFIT
if(isset($_POST['btn-adddec1'])):
    $profit = clear($_POST["name_profit"]);
    $realized_profit = clear($_POST["realized_profit"]);
    $previous_profit = clear($_POST["previous_profit"]);
    $sql = "INSERT INTO profitsdec (name_profit, previous_profit, realized_profit) VALUES ('$profit', '$previous_profit', 
    '$realized_profit')";
    if (mysqli_query($connect, $sql)):
        $_SESSION["message"] = "Item adcionado com sucesso!";
        header('Location: ../december.php?sucess');
    else:
        $_SESSION["message"] = "Erro ao adcionar item. Verifique se os dados estão corretos.";
        header('Location: ../december.php?error');
    endif;
endif; 
