<?php
include 'dbh.inc.php';
    $postid = $_POST['postid'];
    $commentNewCount = $_POST['commentNewCount'];
    $sqlViewComm = "SELECT * FROM comments WHERE comment_post=$postid ORDER BY comment_id DESC";
    $resultViewComm = mysqli_query($conn, $sqlViewComm);
    $countViewComm = mysqli_num_rows($resultViewComm);
    $sqlViewCommLimit = "SELECT * FROM comments WHERE comment_post=$postid ORDER BY comment_id DESC LIMIT $commentNewCount";
    $resultViewCommLimit = mysqli_query($conn, $sqlViewCommLimit);
    $countViewCommLimit = mysqli_num_rows($resultViewCommLimit);
    $countComment = 0;
    if ($countViewCommLimit > 0) {
        function timeago($time, $tense='ago') {
            // declaring periods as static function var for future use
            static $periods = array('year', 'month', 'day', 'hour', 'minute', 'second');
        
            // checking time format
            if(!(strtotime($time)>0)) {
                return trigger_error("Wrong time format: '$time'", E_USER_ERROR);
            }
        
            // getting diff between now and time
            $now  = new DateTime('now');
            $time = new DateTime($time);
            $diff = $now->diff($time)->format('%y %m %d %h %i %s');
            // combining diff with periods
            $diff = explode(' ', $diff);
            $diff = array_combine($periods, $diff);
            // filtering zero periods from diff
            $diff = array_filter($diff);
            // getting first period and value
            $period = key($diff);
            $value  = current($diff);
        
            // if input time was equal now, value will be 0, so checking it
            if(!$value) {
                $period = 'seconds';
                $value  = 0;
            } else {
                // converting days to weeks
                if($period=='day' && $value>=7) {
                    $period = 'week';
                    $value  = floor($value/7);
                }
                // adding 's' to period for human readability
                if($value>1) {
                    $period .= 's';
                }
            }
        
            // returning timeago
            return "$value $period $tense";
        }
        while ($rowViewCommLimit = mysqli_fetch_assoc($resultViewCommLimit)) {
            $commentText = $rowViewCommLimit['comment_text'];
            $commentUser = $rowViewCommLimit['comment_user'];
            $commentedOn = $rowViewCommLimit['comment_date'];
            $sqlViewCommUser = "SELECT * FROM users WHERE idUsers=$commentUser";
            $resultViewCommUser = mysqli_query($conn, $sqlViewCommUser);
            $rowViewCommUser = mysqli_fetch_assoc($resultViewCommUser);
            $commentFname = $rowViewCommUser['fnameUsers'];
            $commentLname = $rowViewCommUser['lnameUsers'];
            ?>
            <div class="viewUserCommentContainer" id="viewUserCommentContainer">
                <div id="viewUserCommentImgContainer">
                    <div id="viewUserCommentImgBack">
                        <?php
                        if ($rowViewCommUser['imgStatus'] == 0) {
                            echo "<img onContextMenu='return false;' src='../profile-uploads/profile".$commentUser.".jpg?'".mt_rand().">";
                        } else if ($rowViewCommUser['imgStatus'] == 1) {
                            echo "<img onContextMenu='return false;' src='../profile-uploads/DropchatProfile.jpg'>";
                        }
                        ?>
                    </div>
                </div>
                <div id="viewUserCommentRight">
                    <div id="viewUserCommentRightTop">
                        <?php
                        if($commentUser == $mySession) {
                        ?>
                        <p id="postUsername"><a href="profile.php"><?php echo $commentFname; ?> <?php echo $commentLname; ?></a></p>
                        <?php
                        } else {
                        ?>
                        <p id="postUsername"><a href="view.php?user=<?php echo $commentUser; ?>"><?php echo $commentFname; ?> <?php echo $commentLname; ?></a></p>
                        <?php
                        }
                        ?>
                    </div>
                    <div id="viewUserCommentRightDate">
                        <?php
                        echo "<p>";
                        echo timeago($commentedOn);
                        echo "</p>";
                        ?>
                    </div>
                    <div id="viewUserCommentRightBottom">
                    <p><?php echo $commentText; ?></p>
                    </div>
                </div>
            </div>
            <?php
        }
        if ($countViewComm > $commentNewCount) {
            echo "<p><a class='homeClickMore' id='homeClickMore$postid' onclick='window.parent.homeMoreCont($postid, $commentNewCount)'>Load more...</a></p>";
        }
    }
?>

<script type="text/javascript">
    function homeMoreCont(x, y) {
        var commentCount = y;
        var postid = x;
        $('#homeClickMore' + x).remove();
        commentCount = commentCount + 2;
        $("#viewFriendCommentConatiner" + x).load('../includes/load-more-in-pages.inc.php', {
            commentNewCount: commentCount,
            postid: postid
        });
    }
</script>