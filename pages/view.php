<?php
session_start();
include '../includes/dbh.inc.php';
?>
<?php
if (isset($_SESSION['userId'])) {
?>
<!DOCTYPE HTML>
<html>
<?php
if(isset($_GET['user'])) {
?>
<?php
$id = $_GET['user'];
$sqlUser = "SELECT * FROM users WHERE idUsers=$id";
$resultUser = mysqli_query($conn, $sqlUser);
$rowUser = mysqli_fetch_assoc($resultUser);
$frname = $rowUser['fnameUsers'];
$lname = $rowUser['lnameUsers'];
?>
    <head>
        <meta charset="utf-8"> 
        <!--Title, browser bar -->
        <title>Dropchat | <?php echo $frname; ?> <?php echo $lname; ?></title>
        <!--Link css stylesheet-->
        <link href="../css/home.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/fontawesome/css/all.css">
        <!-- Add logo to Website tab bar -->
        <link rel="icon" href="http://example.com/favicon.png">
        <!-- Link Font -->
        <script src="https://kit.fontawesome.com/534022c91d.js" crossorigin="anonymous"></script>
        <!--Link Bootstrap     -  Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <!-- Getting js files from folder -->
        <script src="../js/caroufredsel.js" type="text/javascript"></script>
        <script src="../js/main.js"></script>
    </head>
    
    <header>
        <div id="headerLeft">
            <div id="logoRoundContainer">
                <a href="../home.php"><img id="logoRoundImage" src="../images/logo/RoundedLogo.png" alt="Dropchat"></a>
            </div>
            <div id="logoTextContainer">
                <a href="../home.php"  id="homeLogoText"><h1>Dropchat</h1></a>
            </div>
        </div>
        <div id="headerMid">
            <div id="searchFormContainer">
                <form onSubmit="searchSubmit()">
                    <input id="searchInput" type="text" name="friendname" placeholder="Search">
                </form>
            </div>
        </div>
        <div id="headerRight">
            <div id="navContainer">
                <ul>
                    <a href="../home.php" id="navPage"><li><i class="fas fa-home"></i></li></a>
                    <a href="friends.php" id="navPage"><li><i class="fas fa-user-friends"></i></li></a>
                    <a href="chat.php" id="navPage"><li><i class="fas fa-comment"></i></li></a>
                    <a href="discover.php" id="navPage"><li><i class="fas fa-compass"></i></li></a>
                    <a href="profile.php" id="navPage"><li><i class="fas fa-user"></i></li></a>
                </ul>
            </div>
        </div>
    </header>
    
    <script>
        function searchSubmit() {
            var value = $("#searchInput").val();
            if(value === "") {
                event.preventDefault();
            } else {
                $.post("search-friends.php",
                        {
                            'friendname' : value
                        },
                        function(data, status){
                            window.location.replace("search-friends.php?friendname="+value);
                        });
            }
        }
    </script>
    
    <body class="profileBody">
        <div id="profileBackground">
            <div id="profileContainer">
                <div id="profileCover">
                    <img src="../images/profile/backCover.jpg">
                </div>
                <div id="profileInformation">
                <?php
                        $id = $_GET['user'];
                        $sqlImg = "SELECT * FROM users WHERE idUsers='$id'";
                        $resultImg = mysqli_query($conn, $sqlImg);
                        if ($rowImg = mysqli_fetch_assoc($resultImg)) {
                            ?>
                            <div id="profileImage">
                            <div id="profileImageContainer">
                            <?php
                            if ($rowImg['imgStatus'] == 0) {
                                echo "<img src='../profile-uploads/profile".$id.".jpg?'".mt_rand().">";
                            } else if ($rowImg['imgStatus'] == 1) {
                                ?>
                                <img src='../profile-uploads/DropchatProfile.jpg'>
                                <?php
                            }
                            ?>
                            </div>
                            </div>
                            <?php
                        }
                ?>
                
                <?php
                $sqlUser = "SELECT * FROM users WHERE idUsers=$id";
                $resultUser = mysqli_query($conn, $sqlUser);
                $rowUser = mysqli_fetch_assoc($resultUser);
                $frname = $rowUser['fnameUsers'];
                $lname = $rowUser['lnameUsers'];
                if (isset($_SESSION['userId'])) {
                ?>
                <div id="viewprofileNameContainer">
                <div id="profileName">
                    <p><?php echo $frname; ?> <?php echo $lname; ?></p>
                </div>
                </div>
                <?php
                } 
                ?>
                <div id="profileButtonContainer">
                    <?php
                    $get_friends = "SELECT * FROM friends";
                    $gfresult = mysqli_query($conn, $get_friends);
                    require_once '../classes/friendclass.php';
                    
                    if ($rowAdd = mysqli_fetch_assoc($gfresult)) {
                        $one = $rowAdd['user_one'];
                        $two = $rowAdd['user_two'];
                        $id = $_GET['user'];
                        $nameResult = $_SESSION['userId'];
;                        $fr_official = $rowAdd['friendship_official'];
                        
                        ?>
                        <form id="searchButtonSection" action="../includes/viewfriends.inc.php" method="post">
                        <?php
                        if (Friends::renderFriendShip($_SESSION['userId'], $id, 'isThereRequestPending') == 1) {
                        ?>
                            <button id='viewPending' disabled><p>Request Pending</p></button>
                        <?php
                        } else if (Friends::renderFriendShip($_SESSION['userId'], $id, 'isItAccepted') == 1) {
                        ?>
                            <input type='hidden' name='user_one' value='<?php echo $nameResult;?>'/> 
                            <input type='hidden' name='user_two' value='<?php echo $id;?>'/> 
                            <button id='viewAccept' name='acceptFriend'><p><i class="fas fa-check"></i> Accept</p></button>
                            <button id='viewReject' name='rejectFriend'><i class="fas fa-times"></i> Reject</button>
                        <?php
                        } else if (Friends::renderFriendShip($_SESSION['userId'], $id, 'isThereFriendship') == 0) {
                        ?>
                            <input type='hidden' name='user_one' value='<?php echo $nameResult;?>'/> 
                            <input type='hidden' name='user_two' value='<?php echo $id;?>'/> 
                            <button id='viewAdd' value='' name='addfriend'><i class="fas fa-user-plus"></i> Add Friend</button>
                        <?php
                        } else {
                        ?>
                            <input type='hidden' name='user_one' value='<?php echo $nameResult;?>'/> 
                            <input type='hidden' name='user_two' value='<?php echo $id;?>'/> 
                            <button id='viewChat' name='chatFriendFL'><i class="fas fa-comments"></i> Chat</button>
                            <button id='viewRemove' name='unfriend'><i class="fas fa-user-minus"></i> Remove</button>
                        <?php
                        }
                        ?>
                        </form>
                    <?php
                    }
                    ?>
                </div>
                </div>
            </div>
            <div id="profileNavigationContainer">
                <div id="profileNavigation">
                    <ul>
                        <a href="" id="currentNavigation"><li>Posts</li></a>
                        <!--<a href=""><li>Photos</li></a>-->
                    </ul>
                </div>
            </div>
            <div id="profilePosts">
                <?php
                $viewingUser = $_GET['user'];
                $mine = $_SESSION['userId'];
                $sqlPrivacy = "SELECT users.privacyUsers FROM users INNER JOIN friends ON users.idUsers=$viewingUser AND users.privacyUsers='0' OR friends.user_one=$mine AND friends.user_two=$viewingUser AND friends.friendship_official='1' OR friends.user_one=$viewingUser AND friends.user_two=$mine AND friends.friendship_official='1'";
                $resultPrivacy = mysqli_query($conn, $sqlPrivacy);
                if ($rowPrivacy = mysqli_fetch_assoc($resultPrivacy)) {
                    $sqlUserPost = "SELECT * FROM post WHERE post_user=
                    $viewingUser ORDER BY post_id DESC";
                    $resultUserPost = mysqli_query($conn, $sqlUserPost);
                    $countUserPost = mysqli_num_rows($resultUserPost);
                    
                    function url($text) {
                        $text = html_entity_decode($text);
                        $text = " ".$text;
                        $text = preg_replace('/(https{0,1}:\/\/[\w\-\.\/#?&=]*)/','<a id="postLink" href="$1" target="_blank">$1</a>',$text);
                        return $text;
                    }
                    
                    if($countUserPost > 0) {
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
                        while ($rowUserPost = mysqli_fetch_assoc($resultUserPost)) {
                            $postText = $rowUserPost['post_text'];
                            $postid = $rowUserPost['post_id'];
                            $whenPosted = $rowUserPost['post_date'];
                            $mySession = $_SESSION['userId'];
                            ?>
                            <div id="viewingUserPostContainer">
                                <div id="viewingUserPostUserInfo">
                                    <div id="viewingUserPostUserInfo1">
                                        <div id="viewingUserPostUserInfoImage">
                                            <?php
                                            if ($rowImg['imgStatus'] == 0) {
                                                echo "<img src='../profile-uploads/profile".$id.".jpg?'".mt_rand().">";
                                            } else if ($rowImg['imgStatus'] == 1) {
                                            ?>
                                                <img src='../profile-uploads/DropchatProfile.jpg'>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div id="viewingUserPostUserInfo2">
                                        <p><?php echo $frname; ?> <?php echo $lname; ?></p>
                                    </div>
                                </div>
                                <div id="viewingUserPostActual">
                                    <?php $postText_final = url($postText); ?>
                                    <p><?php echo nl2br($postText_final); ?></p>
                                </div>
                                <div id="viewingUserPostUserInfoDate">
                                    <?php
                                    echo "<p>";
                                    echo timeago($whenPosted);
                                    echo "</p>";
                                    ?>
                                </div>
                                <div id="viewingUserPostLike">
                                <div id="viewingUserPostLikeButton">
                                <?php
                                $likescase1 = '1';
                                $likescase2 = '0';
                                $likeext1 = '1';
                                $likeext2 = '0';
                                $sqlLike = "SELECT * FROM likes WHERE post_id='$postid' && like_user='$mySession'";
                                $resultLike = mysqli_query($conn, $sqlLike);
                                if($rowLike = mysqli_fetch_assoc($resultLike)) {
                                    echo "<button onclick='likeaction($postid, $mySession, $likescase1, $likeext1)' id='homeLikeButton$postid' class='likingButton fas fa-heart'></button>";
                                } else {
                                    echo "<button onclick='likeaction($postid, $mySession, $likescase2, $likeext2)' id='homeLikeButton$postid' class='likingButton far fa-heart'></button>";
                                }
                                ?>
                                </div>
                                <div id="viewingUserPostLikeCount">
                                    <?php
                                    $sqlLikeCount = "SELECT * FROM likes WHERE post_id='$postid'";
                                    $resultLikeCount = mysqli_query($conn, $sqlLikeCount);
                                    $countLike = mysqli_num_rows($resultLikeCount);
                                    ?>
                                    <p><span id="likecounter<?php echo $postid; ?>"><?php echo $countLike; ?></span> Likes</p>
                                </div>
                               </div>
                               <div id="viewFriendCommentConatiner<?php echo $postid; ?>" class="viewFriendCommentConatiner">
                                        <?php
                                            $sqlViewComm = "SELECT * FROM comments WHERE comment_post=$postid ORDER BY comment_id DESC";
                                            $resultViewComm = mysqli_query($conn, $sqlViewComm);
                                            $countViewComm = mysqli_num_rows($resultViewComm);
                                            $sqlViewCommLimit = "SELECT * FROM comments WHERE comment_post=$postid ORDER BY comment_id DESC LIMIT 2";
                                            $resultViewCommLimit = mysqli_query($conn, $sqlViewCommLimit);
                                            $countViewCommLimit = mysqli_num_rows($resultViewCommLimit);
                                            $countComment = 0;
                                            if ($countViewCommLimit > 0) {
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
                                                if ($countViewComm > 2) {
                                                    $commentNewCount = 2;
                                                    echo "<p><a class='homeClickMore' id='homeClickMore$postid' onclick='window.parent.homeMoreCont($postid, $commentNewCount)'>Load more...</a></p>";
                                                    ?>
                                                    <script type="text/javascript">
                                                        function homeMoreCont(x, y) {
                                                            var postid = x;
                                                            var commentCount = y;
                                                            //$('#homeClickMore' + x).remove();
                                                            commentCount = commentCount + 2;
                                                            $("#viewFriendCommentConatiner" + x).load('../includes/load-more-in-pages.inc.php', {
                                                                commentNewCount: commentCount,
                                                                postid: postid
                                                            });
                                                        }
                                                    </script>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </div>
                                <div id="viewPostCommentContainer">
                                    <div id="viewPostCommentContainerLeft">
                                        <div id="viewPostCommentLeftBack">
                                            <?php
                                            $id = $_SESSION['userId'];
                                            $sqlImg = "SELECT * FROM users WHERE idUsers='$id'";
                                            $resultImg = mysqli_query($conn, $sqlImg);
                                            if ($rowImg = mysqli_fetch_assoc($resultImg)) {
                                                if ($rowImg['imgStatus'] == 0) {
                                                    echo "<img onContextMenu='return false;' src='../profile-uploads/profile".$id.".jpg?'".mt_rand().">";
                                                } else if ($rowImg['imgStatus'] == 1) {
                                                ?>
                                                    <img onContextMenu='return false;' src='../profile-uploads/DropchatProfile.jpg'>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div id="viewPostCommentContainerRight">
                                            <?php
                                            echo "<textarea type='text' id='commentValue$postid' onkeyup='insertComment($postid)' name='postComment' rows='1' placeholder='Comment...' autocomplete='off'></textarea>";
                                            ?>
                                    </div>
                                    <div id="viewPostCommentContButton">
                                            <?php
                                            echo "<button onclick='postComment($postid, $mySession)' id='homePostingComment$postid' class='nonpostable' disabled>Post</button>";
                                            ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <p id="privateAccount">This user has no posts yet</p>
                        <?php
                    }
                } else {
                    ?>
                    <p id="privateAccount">This user has a private account</p>
                    <?php
                }
                ?>
            </div>
        </div>
        <script type="text/javascript">
        
            var class1 = "fas fa-heart";
            var class2 = "far fa-heart";
            
            function likeaction(x, y, z, i) {
                var likecounter = $("#likecounter" + x).text();
                var myButton = document.getElementById('homeLikeButton' + x);
                if($("#homeLikeButton" + x).hasClass(class1)) {
                    let post_id = x;
                    let user = y;
                    let dislike = z;
                    i = 1
                    $("#homeLikeButton" + x).removeClass(class1);
                    if(i === 1) {
                        $.post("profile.php",
                        {
                            'dislike' : dislike,
                            'post_id' : post_id,
                            'user' : user
                        },
                        function(data, status){
                            likecounter--;
                            $("#homeLikeButton" + x).addClass(class2);
                            document.getElementById("likecounter" + x).innerHTML = likecounter;
                        });
                    }
                } else if ($("#homeLikeButton" + x).hasClass(class2)) {
                    let post_id = x;
                    let user = y;
                    let like = z;
                    i = 0
                    $("#homeLikeButton" + x).removeClass(class2);
                    if(i === 0) {
                        $.post("profile.php",
                        {
                            'like' : like,
                            'post_id' : post_id,
                            'user' : user
                        },
                        function(data, status){
                            likecounter++;
                            $("#homeLikeButton" + x).addClass(class1);
                            document.getElementById("likecounter" + x).innerHTML = likecounter;
                        });
                    }
                }
            }
            
            function insertComment(v) {
            if(document.getElementById("commentValue" + v).value==="") { 
                document.getElementById('homePostingComment' + v).disabled = true;
                $("#homePostingComment" + v).addClass('nonpostable');
                if ($("#homePostingComment" + v).hasClass('postable')) {
                    $("#homePostingComment" + v).removeClass('postable');
                }
            } else { 
                document.getElementById('homePostingComment' + v).disabled = false;
                $("#homePostingComment" + v).addClass('postable');
                if ($("#homePostingComment" + v).hasClass('nonpostable')) {
                    $("#homePostingComment" + v).removeClass('nonpostable');
                }
            }
         }
         
         function isEmptyOrSpaces(str){
            return str === null || str.match(/^ *$/) !== null;
        }
         
        function postComment(c, d) {
        var textValue = document.getElementById('commentValue' + c).value;
        let postid = c;
        let myself = d;
        if (isEmptyOrSpaces(textValue)) {
            document.getElementById('commentValue' + c).value="";
            document.getElementById('homePostingComment' + c).disabled = true;
            $("#homePostingComment" + c).addClass('nonpostable');
            if ($("#homePostingComment" + c).hasClass('postable')) {
                $("#homePostingComment" + c).removeClass('postable');
            }
            return;
        } else {
            $.post('../includes/postcomment-in-pages.inc.php',{postid: postid, user: myself, text: textValue}, function(data){
            $("#viewFriendCommentConatiner" + c).append(data);
            document.getElementById('commentValue' + c).value="";
            document.getElementById('homePostingComment' + c).disabled = true;
            $("#homePostingComment" + c).addClass('nonpostable');
            if ($("#homePostingComment" + c).hasClass('postable')) {
                $("#homePostingComment" + c).removeClass('postable');
            }
        });
        }
        }
        </script>
    </body>
<?php
}
?>
<?php
} else {
    header ("Location: ../index.php");
}
?>
</html>