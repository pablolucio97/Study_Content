<?php
    //CONNECTION
    include_once 'php_action/db_connect_login.php';
    include_once 'php_action/db_connect_pannel.php';
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
            <h3 class="light">System Class 1.0</h3>
            <table class="striped">
                <thead>
                    <tr>
                        <th>Alun:</th>
                        <th>Age:</th>
                        <th>Phone:</th>
                        <th>Mother:</th>
                        <th>Father:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM aluns";
                    $result = mysqli_query($connect, $sql);
                    if (mysqli_num_rows($result) > 0):

                    while($data = mysqli_fetch_array($result)):
                    ?>
                    <tr>
                        <td><?php echo $data['name'];?></td>
                        <td><?php echo $data['age'];?></td>
                        <td><?php echo $data['phone'];?></td>
                        <td><?php echo $data['mother'];?></td>
                        <td><?php echo $data['father'];?></td>
                        <td> <a href="edit.php?id=<?php echo $data['id']; ?>" 
                        class="btn-floating orange"><i class="material-icons">edit</i></a> </td>
                        <td><a href="#modal<?php echo $data['id'];?>" class="btn-floating red modal-trigger">
                        <i class="material-icons">delete</i></a></td>
                     </tr>
                       <!-- Modal Structure -->
                            <div id="modal<?php echo $data['id'];?>" class="modal">
                                <div class="modal-content">
                                <h4>Atention!</h4>
                                <p>You are sure to delete the info?</p>
                                </div>
                                <div class="modal-footer">
                              
                                <form action="php_action/delete.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                                    <button type="submit" name="btn-delete" class="btn red">Yes, I'm sure.</button>
                                    <a href="#!" 
                                class="modal-action modal-close waves-effect waves-green btn-flat green">Cancel</a>
                                </form>
                                </div>
                            </div>
    
                     <?php
                    endwhile;
                endif;
                    ?>
                    </tbody>
            </table>
            <br>
            <a href="add.php" class="btn">Add alun</a>
  


        </div>
    </div>

    <div class="row container">
         <a href="home.php" class="btn">Exit</a>
     </div>

<?php
    //FOOTER
    include_once 'includes/footer.php';
?>