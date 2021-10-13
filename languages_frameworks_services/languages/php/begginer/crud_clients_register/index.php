<?php
    //CONNECTION
    include_once 'php_action/db_connect.php';
    //HEADER
    include_once 'includes/header.php';
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

    <!--FORM-->
    <div class="row">
        <div class='col s12 m6 push-m3 center'>
            <h3 class="light">Client Register 1.0</h3>
            <table class="striped">
                <thead>
                    <tr>
                        <th>Name:</th>
                        <th>Overname:</th>
                        <th>Email:</th>
                        <th>Age:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM clients";
                    $result = mysqli_query($connect, $sql);
                    if (mysqli_num_rows($result) > 0):

                    while($datas = mysqli_fetch_array($result)):
                    ?>
                    <tr>
                        <td><?php echo $datas['name'];?></td>
                        <td><?php echo $datas['overname'];?></td>
                        <td><?php echo $datas['email'];?></td>
                        <td><?php echo $datas['age'];?></td>
                        <td> <a href="#modal_edit<?php echo $datas['id']; ?>" 
                        class="btn-floating orange modal-trigger"><i class="material-icons">edit</i></a> </td>
                        <td><a href="#modal_delete<?php echo $datas['id'];?>" class="btn-floating red modal-trigger">
                        <i class="material-icons">delete</i></a></td>
                     </tr>
                       <!-- Modal Delete -->
                            <div id="modal_delete<?php echo $datas['id'];?>" class="modal">
                                <div class="modal-content">
                                <h4>Atention!</h4>
                                <p>You are sure to delete the info?</p>
                                </div>
                                <div class="modal-footer">
                              
                                <form action="php_action/delete.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $datas['id'];?>">
                                    <button type="submit" name="btn-delete" class="btn red">Yes, I'm sure.</button>
                                    <a href="#!" 
                                class="modal-action modal-close waves-effect waves-green btn-flat green">Cancel</a>
                                </form>
                                </div>
                            </div>
                            <!-- Modal Edit -->
                            <div id="modal_edit<?php echo $datas['id'];?>" class="modal">
                                <div class="modal-content">
                                
                                <div class="row">
                                    <div class='col s12 m6 push-m3 center'>
                                        <h3 class="light">Edit client</h3>
                                        <form action="php_action/update.php" method="POST">
                                            <input type = "hidden" name="id" value ="<?php echo $datas['id'];?>">
                                            <div class="input-field col s12">
                                                <input type="text" name="name" id="name" value="<?php echo $datas['name']; ?>">
                                                <label for="name">Name</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <input type="text" name="overname" id="overname" value="<?php echo $datas['overname'];?>">
                                                <label for="overname">Overname</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <input type="email" name="email" id="email" value="<?php echo $datas['email'];?>">
                                                <label for="email">E-mail</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <input type="text" name="age" id="age" value="<?php echo $datas['age'];?>">
                                                <label for="age">Age</label>
                                            </div>
                                            <button type="submit" name="btn-edit" class="btn">Edit</button>
                                            <a href="index.php" class="btn green">Client list</a>
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
            <br>
            <a href="#modal_add" class="btn modal-trigger">Add client</a>
  


        </div>

 <!--MODAL ADD-->
 <div id="modal_add<?php echo $datas['id'];?>" class="modal">
 <div class='col s12 m6 push-m3 center'>
            <h3 class="light">New Client</h3>
            <form action="php_action/create.php" method="POST">
                <div class="input-field col s12">
                    <input type="text" name="name" id="name">
                    <label for="name">Name</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" name="overname" id="overname">
                    <label for="overname">Overname</label>
                </div>
                <div class="input-field col s12">
                    <input type="email" name="email" id="email">
                    <label for="email">E-mail</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" name="age" id="age">
                    <label for="age">Age</label>
                </div>
                <button type="submit" name="btn-register" class="btn">Register</button>
                <a href="index.php" class="btn green">Client list</a>
            </form>
                </div>
            </div>
            </div>
        </div>
    </div>

<?php
    //FOOTER
    include_once 'includes/footer.php';
?>
