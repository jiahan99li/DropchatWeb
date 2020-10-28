<?php
require '../includes/dbh.inc.php';

$image = $_POST['image'];
$name = $_POST['name'];
$id = $_POST['user'];

$realImage = base64_decode($image);
    
$fileExt = explode('.', $name);
$fileActualExt = strtolower(end($fileExt)); 
$new_extension = 'jpg';
    
$allowed = array('jpg', 'jpeg', 'png');
    
/*if (in_array($fileActualExt, $allowed)) {*/
    $fileNameNew = "profile".$id.".".$new_extension;
    $fileDestination = 'dropchat.chiahan.com/profile-uploads/'.$fileNameNew;
    $url = 'https://www.dropchat.chiahan.com/profile-uploads/'.$fileNameNew;
    file_put_contents($fileNameNew, $realImage);
    $sql = "UPDATE users SET imgStatus='$url' WHERE idUsers='$id';";
    $result = mysqli_query($conn, $sql);
/*} else {
       
}*/
?>