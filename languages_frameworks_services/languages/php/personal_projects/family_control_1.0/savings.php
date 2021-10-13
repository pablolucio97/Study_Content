<?php

//INCLUDES
include_once "includes/header.php";
include_once "includes/footer.php";

//REQUIRE
require_once "php_action/db_connect_login.php";
require_once "php_action/db_connect_bills.php";

   //SESSION MESSAGE
   session_start();
   if(isset($_SESSION['message'])):?>
       
   <script>
   window.onload = function(){
       M.toast({html: '<?php echo $_SESSION['message']; ?>'});
   };
   </script>
   <?php
   endif;
   session_unset();
?>

<html>
<title>
</title>
<body class="grey lighten-2">
    
       <!--SIDENAV-->
       <ul id="slide-out" class="sidenav">
        <li><div id="topside" class="user-view">
          <div class="background blue darken-3">
          </div>
          <a href="#name"><span class="white-text light">Control Family</span></a>
        </div></li>
        <li><div class="divider"></div></li>
         <li><a class="waves-effect" href="january.php">Janeiro<i class="material-icons low">date_range</i></a></li>
        <li><a class="waves-effect" href="february.php">Fevereiro<i class="material-icons low">date_range</i></a></li>
        <li><a class="waves-effect" href="March.php">Março<i class="material-icons low">date_range</i></a></li>
        <li><a class="waves-effect" href="april.php">Abril<i class="material-icons low">date_range</i></a></li>
        <li><a class="waves-effect" href="may.php">Maio<i class="material-icons low">date_range</i></a></li>
        <li><a class="waves-effect" href="june.php">Junho<i class="material-icons low">date_range</i></a></li>
        <li><a class="waves-effect" href="july.php">Julho<i class="material-icons low">date_range</i></a></li>
        <li><a class="waves-effect" href="agost.php">Agosto<i class="material-icons low">date_range</i></a></li>
        <li><a class="waves-effect" href="september.php">Setembro<i class="material-icons low">date_range</i></a></li>
        <li><a class="waves-effect" href="octuber.php">Outubro<i class="material-icons low">date_range</i></a></li>
        <li><a class="waves-effect" href="november.php">Novembro<i class="material-icons low">date_range</i></a></li>
        <li><a class="waves-effect" href="december.php">Dezembro<i class="material-icons low">date_range</i></a></li>
        <li><div class="divider"></div></li>
        <li><a class="waves-effect" href="savings.php">Poupança<i class="material-icons low">account_balance</i></a></li>
        <li><div class="divider"></div></li>
        <li><a class="waves-effect" href="projections.php">Projeções e consumo<i class="material-icons low">monetization_on</i></a></li>
        <li><div class="divider"></div></li>
        <li><a class="waves-effect" href="applications.php">Aplicações<i class="material-icons low">show_chart</i></a></li>
        <li><div class="divider"></div></li>
        <li><a class="waves-effect" href="home.php">Home<i class="material-icons low">house</i></a></li>
        <li><div class="divider"></div></li>
        

        <li><a class="light"  href="index.php">Logout<i class="material-icons low">directions_run</i></a></li>
       </ul>
      <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons low">menu</i></a>
    
    <div class="row container col s12 m6 l3 center ligth">
        <h3 class="ligth"><i class="material-icons amber-text medium">account_balance</i>Poupança</h3>
    </div>
    <div class="row container center col s12 m4 l3">
    <h6 class="light"><i class="material-icons green-text small">attach_money</i>Total de lançamentos:</h6>
    <h5 class="light">



    <?php
              $resultSum = mysqli_query($connect, "SELECT sum(value_savings) FROM savings ORDER BY month");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(value_savings)'].'<br/>';
                    
              }
      ?>
    </h5>
    </div>
    <h3 class="row container center light">Histórico de lançamentos</h3>
    </div>

   
  
        <div class="row container col s12 m6 l4 white">
        <table class="striped centered">
        <thead>
            <tr>
                <th>Valor</th>
                <th>Mês</th>
                <th>Ano</th>
        </thead>
        <tbody>
              
        <?php    
        //RELEASES HISTORY                  

            $sql = "SELECT * FROM savings ORDER BY month";
            $result = mysqli_query($connect, $sql);
            if (mysqli_num_rows($result) > 0):

            while($datas = mysqli_fetch_array($result)):
            ?>

            <tr>
              <td><?php
              $datas2 = $datas['value_savings'];
              $datas3 = str_replace(".",",", $datas2);
              echo "R$ ".$datas3;?></td>
              <td><?php echo $datas['month']; ?> </td>
              <td><?php echo $datas['year']; ?></td>
            </tr>
            <?php
              endwhile;
          endif;
              ?>
              </tbody>
              </table>
              </div>
              <div class="row container"><a href="#modal_add4" class=" btn transparent white-text modal-trigger"><i class="material-icons amber-text">add</i> Realizar depósito</a>
        </div>
                
              
              </div>

          <!--DEPOSITS-->
        <div id="modal_add4<?php echo $datas['id'];?>" class="modal">
                    <div class="modal-content">
                    <div class="row container col s12 m6 l3 center">
                        <h4 class="light">Adcionar valor à poupança</h4>
                            <form action="php_action/create.php" method="POST">
                                <div class="input-field col s12">
                                    <input type="number" step="0.01" name="value_savings" id="value_savings">
                                    <label>Valor</label>
                                </div>
                                <div class="input-field col s12">
                                    <input type="number"  name="month" id="month">
                                    <label for="month">Mês</label>
                                </div>
                                <div class="input-field col s12">
                                    <input type="number" name="year" id="year">
                                    <label for="year">Ano</label>
                                </div>
                              <button type="submit" name="btn-sum" class="btn">Confirmar</button>
                            </form>
                        </div>
                    </div>
                    </div>

      <style>
            body{
              background-image: linear-gradient(to right, rgb(105, 105, 190), rgb(0, 132, 255));
      }
      h1, h2, h3,  h5, h6{
          color:white;
      }
      
      </style>
           
         </body>
</html>