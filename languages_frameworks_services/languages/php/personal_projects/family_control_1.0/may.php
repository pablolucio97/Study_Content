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
    <head>
        <title>Family Control 1.0</title>
    </head>
    <body class="grey lighten-3">
    <nav>
    <div class="nav-wrapper blue darken-3">
      <ul class="right">
        <li id="title-nav">Maio</li>
      </ul>
    </div>
  </nav>
      <!--BODY-->
   
       <!--SIDENAV-->
  
         
       <section id="topside">
    <ul id="slide-out" class="sidenav">
        <li><div id="topside" class="user-view">
          <div class="background blue darken-3">
          </div>
          <a href="#name"><span class="white-text light"><i class="material-icons green-text">attach_money</i>Control Family</span></a>
        </div></li>
        <li><div class="divider"></div></li>
         <li><a class="waves-effect"href="january.php">Janeiro<i class="material-icons low">date_range</i></a></li>
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
        <li><a class="waves-effect" target="_blank" href="https://internetbanking.caixa.gov.br/sinbc/#!nb/login">Informações bancárias<i class="material-icons low">account_balance</i></a></li>
        <li><div class="divider"></div></li>
        <li><a class="waves-effect" href="home.php">Home<i class="material-icons low">house</i></a></li>
        <li><div class="divider"></div></li>
        

        <li><a class="light"  href="index.php">Logout<i class="material-icons low">directions_run</i></a></li>
       </ul>
        
       </section>
     

       
      <a id="menu" href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons low">menu</i></a>
  

      <!--HOME-->

        <!--INCOMES-->
        <div class="row container center col s12">
            <h3><i class="material-icons small green-text">attach_money</i>Proventos:</h3>
        </div>
        <div class="row container col s12 m6 l4">
        <table class="striped centered white">
                <thead>
                    <tr>
                        <th>Provento</th>
                        <th>Provento estimado</th>
                        <th>Provento realizado</th>
                        <th>Editar provento</th> 
                        <th>Eliminar provento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM profitsmay ORDER BY name_profit";
                    $result = mysqli_query($connect, $sql);
                    if (mysqli_num_rows($result) > 0):

                    while($datas = mysqli_fetch_array($result)):
                        
                    ?>
                    <tr>
                        <td><?php echo $datas['name_profit'];?></td>
                            <td><?php
                            $datas2 = $datas['previous_profit'];
                            $datas3 = str_replace(".",",", $datas2);
                            echo "R$ ".$datas3;?></td>
                        <td id="cost_realize"><?php
                            $datas2 = $datas['realized_profit'];
                            $datas3 = str_replace(".",",", $datas2);
                            echo "R$ ".$datas3;?></td>
                            <td> <a class="modal-trigger" href="#modal_edit2<?php echo $datas['id']; ?>" >
                        <i class="material-icons blue-text-text">edit</i></a> </td>
                        <td> <a class="modal-trigger" href="#modal_delete2<?php echo $datas['id']; ?>" >
                        <i class="material-icons blue-text">delete</i></a> </td>
                     </tr>
                      <!-- Modal Edit -->
                        <div id="modal_edit2<?php echo $datas['id'];?>" class="modal">
                    <div class="modal-content col s12 m6 push-m3 center">
                    <h3 class="light">Editar provento</h3>
                    <label for="name" class="left">Valor</label>  
                    <form action="php_action/update.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $datas['id'];?>">
                        <input type="number" step="0.01" name="realized_profit" value="<?php echo $datas['realized_profit'];?>">
                        <button type="submit" name="btn-edit2may" class="btn">Confirmar</button>
                        <br>
                    </form>
                    </div>
                  </div>
                        <!-- Modal Delete Profits-->
                        <div id="modal_delete2<?php echo $datas['id'];?>" class="modal">
                      <div class="modal-content">
                      <h4>Atenção!</h4>
                      <p>Você está certo em deletar este provento?</p>
                      <form action="php_action/delete.php" method="POST">
                          <input type="hidden" name="id" value="<?php echo $datas['id'];?>">
                          <button type="submit" name="btn-deletemaypro" class="btn red">Confirmar</button>
                          <a href="#!" 
                      class="modal-action modal-close waves-effect waves-green btn-flat green white-text">Cancelar</a>
                      </form>
                     </div>
                  </div>
                      </div>
                      
                     <?php
                    endwhile;
                endif;
                    ?>
                    </tbody>
            </table>
            <!--MODAL ADD PROVENTOS EXTRAS-->
        <div id="modal_add5<?php echo $datas['id'];?>" class="modal">
            <div class="modal-content">
            <div class="row">
                <div class='col s12 m6 push-m3 center'>
                    <h4 class="light">Adcionar um provento</h4>
                    <form action="php_action/create.php" method="POST">
                        <div class="input-field col s12">
                            <input type="text"  name="name_profit" id="name_profit">
                            <label for="name">Provento</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="number" step="0.01" name="previous_profit" id="previous_profit">
                            <label for="previous_profit">Valor estimado</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="number" step="0.01" name="realized_profit" id="realized_profit">
                            <label for="realized_profit">Valor real</label>
                        </div>
                        <button type="submit" name="btn-addmay1" class="btn">Adcionar</button>
                    </form>
                </div>
            </div>
            </div>
        </div>      
        </div>
        <div class="row container">
         <a id="btn2" class="btn white-text blue darken-3 modal-trigger" href="#modal_add5" >Adcionar um provento</a>

                    </div>
    </div> 
    </div>
    <div class="row contaienr">
      <h5 class="row container">Proventos:</h5>
      <h5 class="light row container" id="totalprofits">
      <?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsmay");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$ ". $lines2['sum(realized_profit)'].'<br/>';
                }
      ?>
      </h5>
    </div>      

      <!--EXPENSES-->
        <div class="row container center col s12">
            <h3 class=><i class="material-icons small orange-text">money_off</i>Despesas:</h3>
        </div>

        <div class="row container col s12 m6 l4">
        <table id="table-Bill" class="striped centered white">
        <thead>
            <tr>
                <th>Item</th>
                <th>Custo estimado</th>
                <th>Custo realizado</th>
                <th>Editar custo</th>
                <th>Eliminar custo</th>

        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM billsmay ORDER BY item";
            $result = mysqli_query($connect, $sql);
            if (mysqli_num_rows($result) > 0):

            while($datas = mysqli_fetch_array($result)):
            ?>
          <tr>
              <td><?php echo $datas['item'];?></td>
              <td><?php
              $datas2 = $datas['previous_cost'];
              $datas3 = str_replace(".",",", $datas2);
              echo "R$ ".$datas3;?></td>
              <td id="cost_realize"><?php
              $datas2 = $datas['realized_cost'];
              $datas3 = str_replace(".",",", $datas2);
              echo "R$ ".$datas3;?></td>

              <td> <a class="modal-trigger" href="#modal_edit<?php echo $datas['id']; ?>" >
              <i class="material-icons blue-text-text">edit</i></a> </td>
              <td><a href="#modal_delete<?php echo $datas['id'];?>" class="modal-trigger">
              <i class="material-icons blue-text">delete</i></a></td>
            </tr>
         
    
                  <!-- Modal Delete Bills-->
                  <div id="modal_delete<?php echo $datas['id'];?>" class="modal">
                      <div class="modal-content">
                      <h4>Atenção!</h4>
                      <p>Você está certo em deletar este item?</p>
                      <form action="php_action/delete.php" method="POST">
                          <input type="hidden" name="id" value="<?php echo $datas['id'];?>">
                          <button type="submit" name="btn-deletemay" class="btn red">Confirmar</button>
                          <a href="#!" 
                      class="modal-action modal-close waves-effect waves-green btn-flat green white-text">Cancelar</a>
                      </form>
            </div>
                  </div>

             
                            
              <!--MODAL EDIT-->
              <div id="modal_edit<?php echo $datas['id'];?>" class="modal">
                  <div class="modal-content">
                  <div class="row">
                      <div class='col s12 m6 push-m3 center'>
                          <h3 class="light">Editar custo</h3>
                          <form action="php_action/update.php" method="POST">
                              <div class="input-field col s12">
                              <input type="hidden" name="id" value="<?php echo $datas['id'];?>">
                                  <input type="text" readonly="true" name="item" id="item" value="<?php echo $datas['item']; ?>">
                                  <label for="name">Item</label>
                              </div>
                                <div class="input-field col s12">
                                  <input type="number" step="0.01" name="realized_cost" id="realized_cost" value="<?php echo $datas['realized_cost'];?>">
                                  <label for="realized_cost">Custo total</label>
                              </div>
                              <button type="submit" name="btn-edit1may" class="btn">Confirmar</button>
                          </form>
                      </div>
                  </div>
                  </div>
              </div>
                  
       
        <?php
              endwhile;
          endif;
              ?>
              </tbody>
      </table>
      </div>
      <div class="row container"><a id="btn1" href="#modal_add<?php echo $datas['id'];?>" class="btn white-text blue darken-3 modal-trigger light">
     Adcionar uma despesa</a>
        </div>
            
         <!--MODAL ADD-->
        <div id="modal_add<?php echo $datas['id'];?>" class="modal">
            <div class="modal-content">
            <div class="row">
                <div class='col s12 m6 push-m3 center'>
                    <h4 class="light">Adcionar despesa</h4>
                    <form action="php_action/create.php" method="POST">
                        <div class="input-field col s12">
                            <input type="text"  name="item" id="item">
                            <label for="name">Item</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="number" step="0.01" name="previous_cost" id="previous_cost">
                            <label for="previous_cost">Custo estimado</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="number" step="0.01"  name="realized_cost" id="realized_cost">
                            <label for="realized_cost">Custo total</label>
                        </div>
                        <button type="submit" name="btn-addmay" class="btn">Adcionar</button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
 
        <div class="row container">
              <h5 class="row ">Despesas totais:</h5>
              <h5 class="row light" id="totalexpenses">
              <?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsmay");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
              }
              ?>
            </h5>
           </div>

       
    <!--MONTH BALANCE-->
    <h3 class="center"><i class="material-icons small cyan-text">monetization_on</i> Balanço mensal:</h3>
    <br>
    <div id="div-balance" class="row container center col s12 white">
    <div class="row container center col s12 m4 l4">
    <h6 class="light"> <i class="material-icons low green-text light">attach_money</i>Proventos:</h6>
    <h5 class="light">
    <?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_profit) FROM profitsmay");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                echo "R$ ". $lines2['sum(realized_profit)'].'<br/>';
                }
      ?>
    </h5>
    </div>
    <div class="row container center col s12 m4 l4">
    <h6 class=" light"><i class="material-icons low amber-text">money_off</i>Despesas:</h6>
    <h5 class="light">
    <?php
              $resultSum = mysqli_query($connect, "SELECT sum(realized_cost) FROM billsmay");
              $lines = mysqli_num_rows($resultSum);
              while($lines = mysqli_fetch_array($resultSum)){
                $lines2 = str_replace(".", ",", $lines);
                    echo "R$". $lines2['sum(realized_cost)'].'<br/>';
                    
              }
      ?>
    </h5>
    </div>
    <div class="row   center col s12 m4 l4">
    <h6 class="light"><i class="material-icons low cyan-text">monetization_on</i>Saldo restante:</h6>
    <h5 class="light">
    

    <?php
    //SUMING VALUES OF TWO DIFERENTS TABLES
             $resultSum = mysqli_query($connect, "SELECT (SUM(realized_profit) - (SELECT SUM(realized_cost) FROM billsmay))  FROM profitsmay");
             $lines = mysqli_num_rows($resultSum);
             while($lines = mysqli_fetch_array($resultSum)){
              $str = implode('', $lines);
              $str2 = substr($str, 0,7);
              $str3 = str_replace(".", ",", $str2);
              echo "R$". $str3.'<br/>';
               }
         ?>
    </h5>
    </div>
    </div>
    <div class="row right">
      <a href="#topside" id="btn-scrollspy" class="left btn-floating white"><i class="material-icons cyan-text">arrow_upward</i></a>        
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
    <!--CHARTS-->
    <script src="js/jquery.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/line-db-jan.js"></script>

    <!--STYLE-->
    <style>

        #menu{
            position: absolute;
            top: 10px;
            margin: 10px;
            color: white;
            
        }

        #title-nav{
            letter-spacing: 5px;
            font-size: 2.5em;
            font-weight: 300;
            position: absolute;
            right: 3%;
        }

        #title{
            margin:30px;
        }

        h1{
            letter-spacing: 8px;
            
        }

        #div-balance{
            border-radius: 7px;
        }

         table{
             border-radius: 7px;
         }
        
            #btn-scrollspy{
             opacity:0.25;
             position: relative; 
             right: 30px;
         }

         #footer{
             margin-top:80px;
         }

      
    </style>
    </body>
  
</html>