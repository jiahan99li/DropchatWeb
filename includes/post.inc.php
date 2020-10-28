<?php
require "dbh.inc.php";

if (isset($_POST['post_submit'])) {
    if(empty($_POST['postText'])) {
        
    } else {
    $postText = $_POST['postText'];
    $currentUser = $_POST['current_user'];
    $now = date("Y-m-d h:i:s");
    $like = 0;
    
    $sql = "INSERT INTO post (post_user, post_text, post_date) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "help";
    }
    else {
        mysqli_stmt_bind_param($stmt, "sss", $currentUser, $postText, $now);
        mysqli_stmt_execute($stmt);
        header("Location: ../home.php?post=success");
        }
    }
}



if (isset($_POST['postimage_submit'])) {
    $numberOfFiles = count(array_filter($_FILES['file']['name']));
    if($numberOfFiles == 0 && empty($_POST['postText'])) {
        header("Location: ../home.php?post=empty");
    } else if ($numberOfFiles === 0) {
        header("Location: ../home.php?post=noImage");
    } else if (empty($_POST['postText'])) {
        $total = count($_FILES['file']['name']);
        $testingN = 2;
        $number =1;
        echo $numberOfFiles;
        for($i=0 ; $i < $total ; $i++) {
            $file = $_FILES['file'];
            $fileName = $_FILES['file']['name'][$i];
            $fileTmpName = $_FILES['file']['tmp_name'][$i];
            $fileSize = $_FILES['file']['size'][$i];
            $fileError = $_FILES['file']['error'][$i];
            $fileType = $_FILES['file']['type'][$i];
            $testingN++;
            $output = "post_img".$number;
            print_r($output);
            $number++;
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt)); 
            $new_extension = 'jpg';
            
            $allowed = array('jpg', 'jpeg', 'png');
            $fileNameNew = "Vinny".$testingN.".".$new_extension;
            print_r($fileNameNew);
        }
        /*header("Location: ../home.php?post=$numberOfFiles");*/
    } else if ($_FILES['file']['name']!=0 && !empty($_POST['postText'])) {
        $caption = $_POST['postText'];
        echo $caption;
        echo $numberOfFiles;
        $total = count($_FILES['file']['name']);
        for( $i=0 ; $i < $total ; $i++ ) {
            $file = $_FILES['file'];
            print_r($file);
        }
        echo "last";
    }
}
?>