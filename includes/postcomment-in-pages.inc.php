<?php
include 'dbh.inc.php';
$postid = $_POST['postid'];
$comment = $_POST['text'];
$user = $_POST['user'];

$sql = "INSERT INTO comments (comment_user, comment_post, comment_text) VALUES (?, ?, ?)";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "sss", $user, $postid, $comment);
    mysqli_stmt_execute($stmt);
}
?>
<div class="viewUserCommentContainer" id="viewUserCommentContainer">
    <div id="viewUserCommentImgContainer">
        <div id="viewUserCommentImgBack">
            <?php
            $sqlViewCommUser = "SELECT * FROM users WHERE idUsers=$user";
            $resultViewCommUser = mysqli_query($conn, $sqlViewCommUser);
            $rowViewCommUser = mysqli_fetch_assoc($resultViewCommUser);
            $commentFname = $rowViewCommUser['fnameUsers'];
            $commentLname = $rowViewCommUser['lnameUsers'];
            if ($rowViewCommUser['imgStatus'] == 0) {
                echo "<img onContextMenu='return false;' src='../profile-uploads/profile".$user.".jpg?'".mt_rand().">";
            } else if ($rowViewCommUser['imgStatus'] == 1) {
                echo "<img onContextMenu='return false;' src='../profile-uploads/DropchatProfile.jpg'>";
            }
            ?>
        </div>
    </div>
    <div id="viewUserCommentRight">
        <div id="viewUserCommentRightTop">
            <?php
            if($user == $mySession) {
            ?>
            <p id="postUsername"><a href="profile.php"><?php echo $commentFname; ?> <?php echo $commentLname; ?></a></p>
            <?php
            } else {
            ?>
            <p id="postUsername"><a href="view.php?user=<?php echo $user; ?>"><?php echo $commentFname; ?> <?php echo $commentLname; ?></a></p>
            <?php
            }
            ?>
        </div>
        <div id="viewUserCommentRightDate">
            <?php
            echo "<p>";
            echo "Just now";
            echo "</p>";
            ?>
        </div>
        <div id="viewUserCommentRightBottom">
        <p><?php echo $comment; ?></p>
        </div>
    </div>
</div>