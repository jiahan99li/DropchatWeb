<?php
session_start();
include 'dbh.inc.php';

$query = "SELECT * FROM chat";
$resultquery = mysqli_query($conn, $query);
$rowquery = mysqli_fetch_assoc($resultquery);

while ($rowquery = mysqli_fetch_assoc($resultquery))
{
    $sender = $rowquery['sender_id'];
    $message = $rowquery['msg_content'];
    $my_id = $_SESSION['userId'];
    $sendingto_id = $_SESSION['receiver'];
    
    
    if($rowquery['sender_id'] == $my_id && $rowquery['receiver_id'] == $sendingto_id){
        ?>
        <ul id="chatContentMidContainer">
        <li class='cm'><p id="msgText_right"><?php echo $message; ?></p></li>
        </ul>
        <?php
    } else if ($rowquery['sender_id'] == $sendingto_id && $rowquery['receiver_id'] == $my_id){
        ?>
        <ul id="chatContentMidContainer">
        <li class='cm'><p id="msgText_left"><?php echo $message; ?></p></li>
        </ul>
        <?php
    }
}
?>