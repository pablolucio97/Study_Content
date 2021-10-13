<?php
    //HEADER
    include_once 'includes/header.php';
?>

    <div class="row">
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

<?php
    //FOOTER
    include_once 'includes/footer.php';
?>

