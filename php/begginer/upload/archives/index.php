<html>
<body>

<?php 

//UPLOAD CODE

if(isset($_POST["sentform"])):
    $allowedformats = ["png","jpg","jpeg","gif"];
    $extension = pathinfo($_FILES["archive"]["name"], PATHINFO_EXTENSION);

    if(in_array($extension, $allowedformats)):
        $folder = "archives";
        $temp = $_FILES["archive"]["tmp_name"];
        $newName = uniqid().".$extension";

        if(move_uploaded_file($temp, $folder.$newName)):
           $message = "Upload sucessfull!";
        else:
            $message = "Error. Upload no done.";
        endif;
    else:
        $message = "Invalid format.";
    endif;

    echo $message;

endif;
?>

<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST" enctype="multipart/form-data">
    <input type="file" name="archive">
    <button name="sentform" >Sent archive</button>
</form>
</body>
</html>
