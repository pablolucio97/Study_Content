<?php
    //CONNECTION
    include_once 'php_action/db_connect_pannel.php';
    //HEADER
    include_once 'includes/header.php';
    //SELECT
    if(isset($_GET['id'])):
        $id = mysqli_escape_string($connect, $_GET['id']);
        $sql = "SELECT * FROM aluns WHERE id = '$id'";
        $result = mysqli_query($connect, $sql);
        $data = mysqli_fetch_array($result);
    endif;
    
?>

    <div class="row">
        <div class='col s12 m6 push-m3 center'>
            <h3 class="light">Edit alun</h3>
            <form action="php_action/update.php" method="POST">
                <input type = "hidden" name="id" value ="<?php echo $data['id'];?>">
                <div class="input-field col s12">
                    <input type="text" name="name" id="name" value="<?php echo $data['name']; ?>">
                    <label for="name">Alun</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" name="age" id="age" value="<?php echo $data['age'];?>">
                    <label for="age">Age</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" name="phone" id="phone" value="<?php echo $data['phone'];?>">
                    <label for="phone">Phone</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" name="mother" id="mother" value="<?php echo $data['mother'];?>">
                    <label for="mother">Mother</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" name="father" id="father" value="<?php echo $data['father'];?>">
                    <label for="father">Father</label>
                </div>
                <button type="submit" name="btn-edit" class="btn">Save</button>
                <a href="pannel.php" class="btn green">Aluns list</a>
            </form>
  


        </div>
    </div>

<?php
    //FOOTER
    include_once 'includes/footer.php';
?>
