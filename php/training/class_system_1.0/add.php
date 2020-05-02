<?php
    //HEADER
    include_once 'includes/header.php';
?>

    <div class="row">
        <div class='col s12 m6 push-m3 center'>
            <h3 class="light">New Alun</h3>
            <form action="php_action/create.php" method="POST">
                <div class="input-field col s12">
                    <input type="text" name="name" id="name">
                    <label for="name">Alun</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" name="age" id="age">
                    <label for="age">Age</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" name="phone" id="phone">
                    <label for="phone">Phone</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" name="mother" id="mother">
                    <label for="mother">Mother</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" name="father" id="father">
                    <label for="father">Father</label>
                </div>
                <button type="submit" name="btn-register" class="btn">Register alun</button>
                <a href="pannel.php" class="btn green">Alun list</a>
            </form>
      
  


        </div>
    </div>

<?php
    //FOOTER
    include_once 'includes/footer.php';
?>

