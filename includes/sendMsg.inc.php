<?php
include 'dbh.inc.php';

    if (isset($_POST['text']))
    {
        $text = strip_tags(stripslashes($_POST['text']));
        $sender = ($_POST['sending']);
        $receiver = ($_POST['receiving']);
        $now = ($_POST['time']);
        $read = ($_POST['read']);
        
        if(!empty($text))
        {
            
                $sql = "INSERT INTO chat (sender_id, receiver_id, msg_content, msg_date, msg_read) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
            }
                else {
                    mysqli_stmt_bind_param($stmt, "sssss", $sender, $receiver, $text, $now, $read);
                    mysqli_stmt_execute($stmt);
                }
    
            //echo "<li class='cm'><b>".$text."</li>"; //ADD THE SAME TEXT AS IN GET MESSAGE PHP IN ORDER TO DISPLAY SENT MESSAGE INSTANTLY
        }
    }
?>