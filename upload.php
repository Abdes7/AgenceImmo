
<?php
$target_dir = "img/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
?>
<?php

header('location:dashboard.php');

?>


<?php

if (isset($_POST['add_record']))
{
	$name = $_FILES["image"]["tmp_name"];
	$size = $_FILES["image"]["name"];
	$type = $_FILES["image"]["type"];
	$filepath = "img/".filename;

	move_uploaded_file($filetmp, $filepath);

}
?>
