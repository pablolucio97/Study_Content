<?php
session_start();

$_SESSION["color"] = "green";
$_SESSION["car"] = "mustang";

echo $_SESSION["color"]."<br>".$_SESSION["car"]."<br>".session_id();

//to clean a session use the function session_unset
//to  destroy a session use the function session_destroy


