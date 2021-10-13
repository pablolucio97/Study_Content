    <?php
//CONNECTING TO DATABASE
require_once "db_connect.php";

//STARTING SESSION
session_start();

//VERIFICATING IF THE USER ARE LOGED
if(!isset($_SESSION["loged"])):
    header("Location: index.php");
endif;

//DATAS
$id = $_SESSION["id_user"];
$sql = "SELECT * FROM users WHERE id = '$id'";
$result = mysqli_query($connect, $sql);
$datas = mysqli_fetch_array($result);

?>

<html>
<head>
    <title>Restrit page</title>
</head>
<body>
    <h1>Hello <?php echo $datas["name"]; ?>. Welcome to your first web page!</h1><br>
    <a href="logout.php">Exit</a>
</body>
</html>