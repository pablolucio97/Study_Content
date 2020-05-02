<?php   

session_start();

echo $_SESSION["color"]."<br>".$_SESSION["car"]."<br>".session_id();
