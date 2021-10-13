<?php

//GETTERS AND SETTERS
//VERIFYING IF ($goLogin) THE LOGIN AND PASSWORD ARE EQUALS TO ATTRIBUTES DECLARED AT THE OBJECT Login

class Login {
    private $email;
    private $password;

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($e){
        $email = filter_var($e, FILTER_SANITIZE_EMAIL);
      $this->email = $email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($p){
        $this->password = $p;
    }

    public function logger(){
        if($this->email=="test@test.com" and $this->password=="123456"):
            echo "Login sucessfully!";
        else:
            echo "Error to login. Please, try again.";
        endif;
    }
}

//USING GETTERS AND SETTERS
//SET IS USED TO SETUP A METHOD (IS POSSIBLE APPLY FILTER IN THE VARIABLES) INSIDE AN OBJECT (IS NEEDED TO PASS A PARAMTER TO SETTER)
//GET IS USED TO GET AND USE A METHOD VALUE INSIDE AN OBJECT

$goLogin = new Login();
$goLogin->setEmail("test@test.com");
$goLogin->setPassword("123456");
$goLogin->logger();
echo "<hr>";
echo $goLogin->getEmail();


