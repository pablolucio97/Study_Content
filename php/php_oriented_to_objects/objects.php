<?php
//CREATING A OBJECT
class People {
    public $name;
    public $age;

    public function Talk(){
        echo "Talked";
    }
}

$pablo = new People();
var_dump($pablo);
