<?php

include_once "includes/header.php";
include_once "includes/footer.php";


//REQUIRE
require_once "php_action/db_connect_login.php";
require_once "php_action/db_connect_bills.php";
?>

<body class="grey lighten-2">
<div class="row center">
<h1 class="light">Control Family</h1>
</div>

<!--JANEIRO-->
<div class="row container">
 <div id="div1"class="row col s12 m6 l3 blue darken-3 white-text">
    <h3 class="light center tooltipped" data-tooltip="Proventos: <?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?> Despesas: <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?>"">Janeiro</h3>
 </div>
 <!--FERVEREIRO-->
 <div id="div2"class="row col s12 m6 l3 blue darken-3 white-text">
    <h3 class="light center tooltipped" data-tooltip="Proventos: <?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?> Despesas: <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsfeb");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?>"">Fervereiro</h3>
 </div>
 <!--MARÇO-->
 <div id="div3"class="row col s12 m6 l3 blue darken-3 white-text">
    <h3 class="light center tooltipped" data-tooltip="Proventos: <?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?> Despesas: <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsmar");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?>"">Março</h3>
 </div>
 <!--ABRIL-->
 <div id="div3"class="row col s12 m6 l3 blue darken-3 white-text">
    <h3 class="light center tooltipped" data-tooltip="Proventos: <?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?> Despesas: <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsapr");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?>"">Abril</h3>
 </div>
</div>

<!--JANEIRO-->
<div class="row container">
 <div id="div1"class="row col s12 m6 l3 blue darken-3 white-text">
    <h3 class="light center tooltipped" data-tooltip="Proventos: <?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?> Despesas: <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?>"">Janeiro</h3>
 </div>
 <!--FERVEREIRO-->
 <div id="div2"class="row col s12 m6 l3 blue darken-3 white-text">
    <h3 class="light center tooltipped" data-tooltip="Proventos: <?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?> Despesas: <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsfeb");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?>"">Fervereiro</h3>
 </div>
 <!--MARÇO-->
 <div id="div3"class="row col s12 m6 l3 blue darken-3 white-text">
    <h3 class="light center tooltipped" data-tooltip="Proventos: <?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?> Despesas: <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsmar");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?>"">Março</h3>
 </div>
 <!--ABRIL-->
 <div id="div3"class="row col s12 m6 l3 blue darken-3 white-text">
    <h3 class="light center tooltipped" data-tooltip="Proventos: <?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?> Despesas: <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsapr");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?>"">Abril</h3>
 </div>
</div>

<!--JANEIRO-->
<div class="row container">
 <div id="div1"class="row col s12 m6 l3 blue darken-3 white-text">
    <h3 class="light center tooltipped" data-tooltip="Proventos: <?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?> Despesas: <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?>"">Janeiro</h3>
 </div>
 <!--FERVEREIRO-->
 <div id="div2"class="row col s12 m6 l3 blue darken-3 white-text">
    <h3 class="light center tooltipped" data-tooltip="Proventos: <?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?> Despesas: <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsfeb");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?>"">Fervereiro</h3>
 </div>
 <!--MARÇO-->
 <div id="div3"class="row col s12 m6 l3 blue darken-3 white-text">
    <h3 class="light center tooltipped" data-tooltip="Proventos: <?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?> Despesas: <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsmar");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?>"">Março</h3>
 </div>
 <!--ABRIL-->
 <div id="div3"class="row col s12 m6 l3 blue darken-3 white-text">
    <h3 class="light center tooltipped" data-tooltip="Proventos: <?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsjan");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$". $lines2['sum(realized_profit)'].'<br/>';
                }  ?> Despesas: <?php   $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsapr");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }   ?>"">Abril</h3>
 </div>
</div>

<!--FOOTER-->
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
</body>

<style>

 #div1, #div2, #div3{
    border-radius: 5px;
    margin-left:4%;
    width:21%;
    
}

</style>