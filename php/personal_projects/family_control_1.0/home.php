<?php
//SESSION START
session_start();


//INCLUDES
include_once "includes/header.php";
include_once "includes/footer.php";


//REQUIRE
require_once "php_action/db_connect_login.php";
require_once "php_action/db_connect_bills.php";


?>

<html>
    <head>
        <title>Panel</title>
    </head>
    <body class="grey lighten-2">


    



    <!--HOME-->
         <div class='row container center col s12 m6 l2'>
            <h1 class="light"><i class="material-icons small green-text">attach_money</i><span id="typed"></span></h1>
        </div>  
        <div class='row container center col s12 m6 l2'>
        <!--CARD JAN-->
            <div class="card col s12 m6 l2 white  light">
            <div id="div1" class="card-content">
              <span class="card-title activator"> <i class="material-icons right">arrow_drop_down</i></span>
              <p> <i class="material-icons medium white-text">date_range</i> </p>
              <h5  class="light"> <a href="january.php">Janeiro</a></h5>
            </div>
            <div class="card-reveal">
            <ul class="ligth">
              <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
              <p class='white-text'>Teste</p>
                      <p><i class="material-icons green-text">attach_money</i><?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?></p>
                  <p><i class="material-icons red-text">money_off</i> <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?></p>
            </div>
            </div>

          <!--CARD FEB-->
          <div class="card col s12 m6 l2 white light">
          <div id ="div2" class="card-content">
              <span class="card-title activator"> <i class="material-icons right">arrow_drop_down</i></span>
              <p> <i class="material-icons medium white-text">date_range</i> </p>
              <h5 class="light"><a href="february.php">Fevereiro</a></h5>
            </div>
            <div class="card-reveal">
            <ul class="ligth">
              <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
              <p class='white-text'>Teste</p>
              <p><i class="material-icons green-text">attach_money</i><?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsfeb");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?></p>
                  <p><i class="material-icons red-text">money_off</i> <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsfeb");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?></p>
            </div>
            </div>

                <!--CARD MAR-->
            <div class="card col s12 m6 l2 white  light">
            <div class="card-content">
              <span class="card-title activator"> <i class="material-icons right">arrow_drop_down</i></span>
              <p> <i class="material-icons medium white-text">date_range</i> </p>
              <h5 class="light"><a href="march.php">Março</a></h5>
            </div>
            <div class="card-reveal">
            <ul class="ligth">
              <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
              <p class='white-text'>Teste</p>
              <p><i class="material-icons green-text">attach_money</i><?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsmar");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?></p>
                  <p><i class="material-icons red-text">money_off</i> <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsmar");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?></p>
            </div>
            </div>
                <!--CARD APR-->
            <div class="card col s12 m6 l2  light">
            <div class="card-content">
              <span class="card-title activator"> <i class="material-icons right">arrow_drop_down</i></span>
              <p> <i class="material-icons medium white-text">date_range</i> </p>
              <h5 class="light"><a href="april.php">Abril</a></h5>
            </div>
            <div class="card-reveal">
            <ul class="ligth">
              <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
              <p class='white-text'>Teste</p>
              <p><i class="material-icons green-text">attach_money</i><?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsapr");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?></p>
                  <p><i class="material-icons red-text">money_off</i> <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsapr");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?></p>
            </div>
            </div>
      
    
        <!--CARD MAY-->
        <div class="card col s12 m6 l2  light">
        <div class="card-content">
              <span class="card-title activator"> <i class="material-icons right">arrow_drop_down</i></span>
              <p> <i class="material-icons medium white-text">date_range</i> </p>
              <h5 class="light"><a href="may.php">Maio</a></h5>
            </div>
            <div class="card-reveal">
            <ul class="ligth">
              <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
              <p class='white-text'>Teste</p>
              <p><i class="material-icons green-text">attach_money</i><?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsmay");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?></p>
                  <p><i class="material-icons red-text">money_off</i> <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsmay");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?></p>
            </div>
            </div>

          <!--CARD JUN-->
          <div class="card col s12 m6 l2 white  light">
          <div class="card-content">
              <span class="card-title activator"> <i class="material-icons right">arrow_drop_down</i></span>
              <p> <i class="material-icons medium white-text">date_range</i> </p>
              <h5 class="light"><a href="june.php">Junho</a></h5>
            </div>
            <div class="card-reveal">
            <ul class="ligth">
              <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
              <p class='white-text'>Teste</p>
              <p><i class="material-icons green-text">attach_money</i><?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsjun");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?></p>
                  <p><i class="material-icons red-text">money_off</i> <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsjun");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?></p>
            </div>
            </div>
           
          

                <!--CARD JUL-->
            <div class="card col s12 m6 l2 white  light">
            <div class="card-content">
              <span class="card-title activator"> <i class="material-icons right">arrow_drop_down</i></span>
              <p> <i class="material-icons medium white-text">date_range</i> </p>
              <h5 class="light"><a href="july.php">Julho</a></h5>
            </div>
            <div class="card-reveal">
            <ul class="ligth">
              <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
              <p class='white-text'>Teste</p>
              <p><i class="material-icons green-text">attach_money</i><?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsjul");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?></p>
                  <p><i class="material-icons red-text">money_off</i> <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsjul");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?></p>
            </div>
            </div>
            
                <!--CARD AGO-->
        <div class="card col s12 m6 l2 white  light">
        <div class="card-content">
          <span class="card-title activator"> <i class="material-icons right">arrow_drop_down</i></span>
          <p> <i class="material-icons medium white-text">date_range</i> </p>
          <h5 class="light"><a href="agost.php">Agosto</a></h5>
            </div>
            <div class="card-reveal">
            <ul class="ligth">
              <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
              <p class='white-text'>Teste</p>
              <p><i class="material-icons green-text">attach_money</i><?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsago");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?></p>
                  <p><i class="material-icons red-text">money_off</i> <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsago");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?></p>
            </div>
            </div>

       
        <!--CARD SEP-->
            <div class="card col s12 m6 l2 white light">
            <div class="card-content">
              <span class="card-title activator"> <i class="material-icons right">arrow_drop_down</i></span>
              <p> <i class="material-icons medium white-text">date_range</i> </p>
              <h5 class="light"><a href="september.php">Setembro</a></h5>
            </div>
            <div class="card-reveal">
            <ul class="ligth">
              <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
              <p class='white-text'>Teste</p>
              <p><i class="material-icons green-text">attach_money</i><?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitssep");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?></p>
                  <p><i class="material-icons red-text">money_off</i> <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billssep");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?></p>
            </div>
            </div>

          <!--CARD OCT-->
          <div class="card col s12 m6 l2 white light">
          <div class="card-content">
              <span class="card-title activator"> <i class="material-icons right">arrow_drop_down</i></span>
              <p> <i class="material-icons medium white-text">date_range</i> </p>
              <h5 class="light"><a href="octuber.php">Outubro</a></h5>
            </div>
            <div class="card-reveal">
            <ul class="ligth">
              <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
              <p class='white-text'>Teste</p>
              <p><i class="material-icons green-text">attach_money</i><?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsoct");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?></p>
                  <p><i class="material-icons red-text">money_off</i> <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsoct");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?></p>
            </div>
            </div>

                <!--CARD NOV-->
          <div class="card col s12 m6 l2 white light">
          <div class="card-content">
              <span class="card-title activator"> <i class="material-icons right">arrow_drop_down</i></span>
              <p> <i class="material-icons medium white-text">date_range</i> </p>
              <h5 class="light"><a href="november.php">Novembro</a></h5>
            </div>
            <div class="card-reveal">
            <ul class="ligth">
              <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
              <p class='white-text'>Teste</p>
              <p><i class="material-icons green-text">attach_money</i><?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsnov");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?></p>
                  <p><i class="material-icons red-text">money_off</i> <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsnov");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?></p>
            </div>
            </div>
                <!--CARD DEC-->
          <div class="card col s12 m6 l2 white light">
          <div class="card-content">
              <span class="card-title activator"> <i class="material-icons right">arrow_drop_down</i></span>
              <p> <i class="material-icons medium white-text">date_range</i> </p>
              <h5 class="light"><a href="december.php">Dezembro</a></h5>
            </div>
            <div class="card-reveal">
            <ul class="ligth">
              <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
              <p class='white-text'>Teste</p>
              <p><i class="material-icons green-text">attach_money</i><?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsdec");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?></p>
                  <p><i class="material-icons red-text">money_off</i> <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsdec");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?></p>
            </div>
            </div>
            
          </div>

          <footer id="footer" class="page-footer blue darken-3">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text"><i class="material-icons green-text">attach_money</i>Control Family</h5>
                <p class="grey-text text-lighten-4">Aplicação web de uso particular criada para fazer previsões orçamentárias e
                acompanhar o planejamento dos orçamentos. Esta aplicação se torna útil quando as previsões de saída e entrada de
                 proventos são acompanhadas diairiamente e os resultados são acompanhados juntamente com o saldo bancário.</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Selecione um mês:</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="january.php">Janeiro</a></li>
                  <li><a class="grey-text text-lighten-3" href="february.php">Fervereiro</a></li>
                  <li><a class="grey-text text-lighten-3" href="march.php">Março</a></li>
                  <li><a class="grey-text text-lighten-3" href="april.php">Abril</a></li>
                  <li><a class="grey-text text-lighten-3" href="may.php">Maio</a></li>
                  <li><a class="grey-text text-lighten-3" href="june.php">Junho</a></li>
                  <li><a class="grey-text text-lighten-3" href="july.php">Julho</a></li>
                  <li><a class="grey-text text-lighten-3" href="agost.php">Agosto</a></li>
                  <li><a class="grey-text text-lighten-3" href="september.php">Setembro</a></li>
                  <li><a class="grey-text text-lighten-3" href="octuber.php">Outubro</a></li>
                  <li><a class="grey-text text-lighten-3" href="november.php">Novembro</a></li>
                  <li><a class="grey-text text-lighten-3" href="december.php">Dezembro</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            2019 - Control Family - Iniciativa particular
            <a class="grey-text text-lighten-4 right" href="#!"></a>
            </div>
          </div>
        </footer>
          <style>

      #btn-scrollspy{
      opacity:0.25;
      position: relative; 
      right: 30px;
      }

      #footer{
          margin-top:80px;
      }

      #div1, #div2{
        margin-left: 20px;
      }


</style>
    </body>
  <script>
 $(document).ready(function(){
        var typed = new Typed("#typed",{
            strings:["Fazer orçamentos mensais", "Fazer previsões financeiras", "Control Family "],
	    backSpeed: 30,
            typeSpeed: 60,
            startDelay: 1000,
            backDelay: 200,
            smartBackspace: true,
            showCursor: true,
            cursorChar: '|'
        })
    })
</script>

</html>