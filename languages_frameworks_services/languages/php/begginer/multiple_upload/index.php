<html>
<body>

<?php 

//MULTI UPLOAD CODE

if(isset($_POST["sentform"])):
    $allowedformats = ["png","jpg","jpeg","gif"];
    $batchArchives = count($_FILES["archive"]["name"]);
    $count = 0;

    while($count < $batchArchives):

    $extension = pathinfo($_FILES["archive"]["name"][$count], PATHINFO_EXTENSION);
        if(in_array($extension, $allowedformats)):
            $folder = "archives";
            $temp = $_FILES["archive"]["tmp_name"]["$count"];
            $newName = uniqid().".$extension";

            if(move_uploaded_file($temp, $folder.$newName)):
            echo "Uploaded the file $newName to folder $folder.<br>";
            else:
                echo "Error to try sent the file $temp.";
            endif;
        else:
            echo "Extension not avaliable.";
        endif;
    $count ++ ;        
    endwhile;

endif;
?>

<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST" enctype="multipart/form-data">
    <input type="file" name="archive[]" multiple>
    <button name="sentform" >Sent archive</button>
</form>
</body>
</html>
