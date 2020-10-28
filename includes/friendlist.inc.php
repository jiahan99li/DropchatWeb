<?php
    include "../includes/dbh.inc.php";


    //ACCEPT FRIEND
    if (isset($_POST['acceptFriendFL'])) {
        
        $user_one = $_POST['user_one'];
        $user_two = $_POST['user_two'];
        
        $update = "UPDATE friends SET friendship_official='1' WHERE user_one=$user_two AND user_two=$user_one";
        $stmtU = mysqli_stmt_init($conn);
        
         if (!mysqli_stmt_prepare($stmtU, $update)) {
                    
        }
        else {
                mysqli_stmt_execute($stmtU);
            }
        header('Location: ../pages/friends.php');
        exit();
    }



    //REJECT FRIEND
    if (isset($_POST['rejectFriendFL'])) { 
        
        $user_one = $_POST['user_one'];
        $user_two = $_POST['user_two'];
        
        $reject = "DELETE FROM friends WHERE user_one=$user_one AND user_two=$user_two OR user_one=$user_two AND user_two=$user_one";
        $stmtR = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmtR, $reject)) {
                    
        }
        else {
                mysqli_stmt_execute($stmtR);
            }
        
        header('Location: ../pages/friends.php');
    } 



    //CHAT FRIEND
    if (isset($_POST['chatFriendFL'])) {
        
        $user_two = $_POST['user_two'];
        
        header('Location: ../pages/chat.php?chat_id='.$user_two);
        exit();
    }


    //UNFRIEND BUTTON
    if (isset($_POST['removeFriendFL'])) { 
        
        $user_one = $_POST['user_one'];
        $user_two = $_POST['user_two'];
        
        $delete = "DELETE FROM friends WHERE user_one=$user_one AND user_two=$user_two OR user_one=$user_two AND user_two=$user_one";
        $stmtD = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmtD, $delete)) {
                    
        }
        else {
                mysqli_stmt_execute($stmtD);
            }
        
        header('Location: ../pages/friends.php');
        exit();
    }

?>