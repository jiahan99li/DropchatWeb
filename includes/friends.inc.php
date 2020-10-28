<?php
    include "dbh.inc.php";


    //ADD FRIEND BUTTON
    if (isset($_POST['addfriend'])) {
        
        $frname = $_POST['search_name'];
        $user_one = $_POST['user_one'];
        $user_two = $_POST['user_two'];
        $fr_official = 0;
        $now = date("Y-m-d h:i:s");
        
        
        $insert = "INSERT INTO friends (user_one, user_two, friendship_official, date_made) VALUES (?, ?, ?, ?)";
        $stmtI = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmtI, $insert)) {
                    
        }
        else {
                mysqli_stmt_bind_param($stmtI, "ssss", $user_one, $user_two, $fr_official, $now);
                mysqli_stmt_execute($stmtI);
            }
        
        header('Location: ../pages/search-friends.php?friendname='.$frname);
        exit();
    }


    //UNFRIEND BUTTON
    if (isset($_POST['unfriend'])) { 
        
        $frname = $_POST['search_name'];
        $user_one = $_POST['user_one'];
        $user_two = $_POST['user_two'];
        
        $delete = "DELETE FROM friends WHERE user_one=$user_one AND user_two=$user_two OR user_one=$user_two AND user_two=$user_one";
        $stmtD = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmtD, $delete)) {
                    
        }
        else {
                mysqli_stmt_execute($stmtD);
            }
        
        header('Location: ../pages/search-friends.php?friendname='.$frname);
        exit();
    }


    //ACCEPT FRIEND REQUEST
    if (isset($_POST['acceptFriend'])) {
        
        $frname = $_POST['search_name'];
        $user_one = $_POST['user_one'];
        $user_two = $_POST['user_two'];
        $now = date("Y-m-d h:i:s");
        
        $update = "UPDATE friends SET friendship_official='1' WHERE user_one=$user_two AND user_two=$user_one";
        $stmtU = mysqli_stmt_init($conn);
        
         if (!mysqli_stmt_prepare($stmtU, $update)) {
                    
        }
        else {
                mysqli_stmt_execute($stmtU);
            }
        header('Location: ../pages/search-friends.php?friendname='.$frname);
        exit();
    }


    //REJECT FRIEND 
    if (isset($_POST['rejectFriend'])) { 
        
        $frname = $_POST['search_name'];
        $user_one = $_POST['user_one'];
        $user_two = $_POST['user_two'];
        
        $delete = "DELETE FROM friends WHERE user_one=$user_one AND user_two=$user_two OR user_one=$user_two AND user_two=$user_one";
        $stmtD = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmtD, $delete)) {
                    
        }
        else {
                mysqli_stmt_execute($stmtD);
            }
        
        header('Location: ../pages/search-friends.php?friendname='.$frname);
        exit();
    }


    //CHAT WITH FRIEND
    if (isset($_POST['chatFriendFL'])) {
        
        $user_two = $_POST['user_two'];
        
        header('Location: ../pages/chat.php?chat_id='.$user_two);
        exit();
    }



    ?>