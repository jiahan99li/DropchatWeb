<?php
/*session_set_cookie_params(360*72,"/");*/
session_set_cookie_params(360/360,"/");
session_start();
include 'includes/dbh.inc.php';
?>
<?php
if (isset($_SESSION['userId'])) {
?>
<!DOCTYPE HTML>
<html>
<?php
if(isset($_POST['like'])) {
    $post = $_POST['post_id'];
    $user = $_POST['user'];
    $like = $_POST['like'];
    $sql = "INSERT INTO likes (post_id, like_user, like_confirm) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "sss", $post, $user, $like);
        mysqli_stmt_execute($stmt);
    }
}

if(isset($_POST['dislike'])) {
    $post = $_POST['post_id'];
    $user = $_POST['user'];
    $sql = "DELETE FROM likes WHERE post_id=? && like_user=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $post, $user);
        mysqli_stmt_execute($stmt);
    }
}
?>
    <head>
        <meta charset="utf-8">
        <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
        <!--Title, browser bar -->
        <title>Dropchat</title>
        <!--Link css stylesheet-->
        <link href="css/home.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="css/fontawesome/css/all.css">
        <link href="css/emoji/lib/css/emoji.css" rel="stylesheet">
        <!-- Add logo to Website tab bar -->
        <link rel="icon" href="http://example.com/favicon.png">
        <!-- Link Font -->
        <script src="https://kit.fontawesome.com/534022c91d.js" crossorigin="anonymous"></script>
        <!--Link Bootstrap     -  Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <!--<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">-->
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <!-- Getting js files from folder -->
        <script src="js/caroufredsel.js" type="text/javascript"></script>
        <script src="js/main.js"></script>
    </head>
    
    <header>
        <div id="headerLeft">
            <div id="logoRoundContainer">
                <a href="home.php"><img id="logoRoundImage" src="images/logo/RoundedLogo.png" alt="Dropchat" onContextMenu="return false;"></a>
            </div>
            <div id="logoTextContainer">
                <a href="home.php"  id="homeLogoText"><h1>Dropchat</h1></a>
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
                    <a href="home.php" id="currentPage"><li><i class="fas fa-home"></i></li></a>
                    <a href="pages/friends.php" id="navPage"><li><i class="fas fa-user-friends"></i></li></a>
                    <a href="pages/chat.php" id="navPage"><li><i class="fas fa-comment"></i></li></a>
                    <a href="pages/discover.php" id="navPage"><li><i class="fas fa-compass"></i></li></a>
                    <a href="pages/profile.php" id="navPage"><li><i class="fas fa-user"></i></li></a>
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
                $.post("pages/search-friends.php",
                        {
                            'friendname' : value
                        },
                        function(data, status){
                            window.location.replace("pages/search-friends.php?friendname="+value);
                        });
            }
        }
    </script>
    
    <body class="homeBody">
        <div id="homePostingPopup" onclick="document.getElementById('homePostingPopup').style.display='none';document.getElementById('homePostingPoppedup').style.display='none'"></div>
        <div id="LikeDisplayBackgroundPop" onclcik="removePop()"></div>
        <div id="homePostingPoppedup">
            <div id="homePostingPoppedupTitle">
                <h2>Share Post</h2>
            </div>
            <div id="homePostingPoppedupTop">
                <div id="homePostingPoppedupTop1">
                    <div id="homePoppedImage">
                        <?php
                        $myId = $_SESSION['userId'];
                        $sqlImg = "SELECT * FROM users WHERE idUsers='$myId'";
                        $resultImg = mysqli_query($conn, $sqlImg);
                        if ($rowImg = mysqli_fetch_assoc($resultImg)) {
                            if ($rowImg['imgStatus'] == 0) {
                                echo "<img onContextMenu='return false;' src='profile-uploads/profile".$myId.".jpg?'".mt_rand().">";
                            } else if ($rowImg['imgStatus'] == 1) {
                                echo "<img onContextMenu='return false;' src='profile-uploads/DropchatProfile.jpg'>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <div id="homePostingPoppedupTop2">
                    <?php
                    $frname = $_SESSION['fnameId'];
                    $lname = $_SESSION['lnameId'];
                    $current_user = $_SESSION['userId'];
                    ?>
                    <p><?php echo $frname; ?> <?php echo $lname; ?></p>
                </div>
            </div>
            <div id="homePostingPoppedupMid">
                <form action="includes/post.inc.php" method="post">
                    <input type="hidden" name="current_user" value="<?php echo $current_user; ?>"</input>
                    <textarea id="postTextarea" autofocus class="postText" type="text" name="postText" rows="8" placeholder="What's on your mind today?" autocomplete="off" onkeyup='insertPostText()'></textarea>
            </div>
            <div id="homePostingPoppedupBot">
                    <button type="submit" name="post_submit" class="post_submit" id="post_submit" disabled>Post</button>
                </form>
            </div>
        </div>
        
        <div id="homeImagePopup" onclick="document.getElementById('homeImagePopup').style.display='none';document.getElementById('homeImagePoppedup').style.display='none'"></div>
        <div id="homeImagePoppedup">
            <div id="homeImagePoppedupTitle">
                <h2>Share Image</h2>
            </div>
            <div id="homeImagePoppedupTop">
                <div id="homeImagePoppedupTop1">
                    <div id="homeImageImage">
                        <?php
                        $myId = $_SESSION['userId'];
                        $sqlImg = "SELECT * FROM users WHERE idUsers='$myId'";
                        $resultImg = mysqli_query($conn, $sqlImg);
                        if ($rowImg = mysqli_fetch_assoc($resultImg)) {
                            if ($rowImg['imgStatus'] == 0) {
                                echo "<img onContextMenu='return false;' src='profile-uploads/profile".$myId.".jpg?'".mt_rand().">";
                            } else if ($rowImg['imgStatus'] == 1) {
                                echo "<img onContextMenu='return false;' src='profile-uploads/DropchatProfile.jpg'>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <div id="homeImagePoppedupTop2">
                    <?php
                    $frname = $_SESSION['fnameId'];
                    $lname = $_SESSION['lnameId'];
                    $current_user = $_SESSION['userId'];
                    ?>
                    <p><?php echo $frname; ?> <?php echo $lname; ?></p>
                </div>
            </div>
            <div id="homeImagePoppedupMid">
                <form id="postImageForm" action="includes/post.inc.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="current_user" value="<?php echo $current_user; ?>"</input>
                    <button id="uploadImagebtn" onclick="document.getElementById('tmpImageinput').click(); return false;"><i class="fas fa-image"></i><span>Add</span></button>
                    <input id="tmpImageinput" type="file" name="file[]" multiple="multiple">
                    <div class="postImageShow"></div>
                    <textarea id="postTextarea" autofocus class="postText" type="text" name="postText" rows="2" placeholder="Add a caption..." autocomplete="off"></textarea>
            </div>
            <div id="homeImagePoppedupBot">
                    <button id="postImage" type="submit" name="postimage_submit">Post</button>
                </form>
            </div>
        </div>
        
        <div id="chatButtonContainer">
                <a onclick="document.getElementById('homeFriendList').style.display='block'"><i class="fas fa-comment-medical"></i></a>
                <div id="homeFriendList">
                    <?php
                    $me = $_SESSION['userId'];
                    $sqlFriend = "SELECT * FROM friends WHERE user_one=$me AND friendship_official='1' OR user_two=$me AND friendship_official='1'";
                    $resultFriend = mysqli_query($conn, $sqlFriend);
                    $countFriend = mysqli_num_rows($resultFriend);
                    if($countFriend > 0) {
                        while($rowFriend = mysqli_fetch_assoc($resultFriend)) {
                        if ($rowFriend['user_two'] == $_SESSION['userId']) {
                            $user_sending = $rowFriend['user_one'];
                            $query_users = "SELECT * FROM users WHERE idUsers=$user_sending";
                            $result_sending = mysqli_query($conn, $query_users);
                            $row_users = mysqli_fetch_assoc($result_sending);
                            $me = $_SESSION['userId'];
                        } else if ($rowFriend['user_one'] == $_SESSION['userId']) {
                            $user_sending = $rowFriend['user_two'];
                            $query_users = "SELECT * FROM users WHERE idUsers=$user_sending";
                            $result_sending = mysqli_query($conn, $query_users);
                            $row_users = mysqli_fetch_assoc($result_sending);
                            $me = $_SESSION['userId'];
                        }
                        $first_name = $row_users['fnameUsers'];
                        $last_name = $row_users['lnameUsers'];
                    ?>
                    <form action="pages/chat.php">
                        <button name="chat_id" value="<?php echo $user_sending; ?>">
                            <div id="friendSelectButton1">
                                <div id="friendSelectButton1Img">
                                    <?php
                                        $sqlImg = "SELECT * FROM users WHERE idUsers='$user_sending'";
                                        $resultImg = mysqli_query($conn, $sqlImg);
                                        $rowImg = mysqli_fetch_assoc($resultImg);

                                        echo "<div id='profileFriend'>";
                                        if ($rowImg['imgStatus'] == 0) { 
                                            echo "<img onContextMenu='return false;' src='profile-uploads/profile".$user_sending.".jpg?'".mt_rand().">";
                                        } else if ($rowImg['imgStatus'] == 1) {
                                            echo "<img onContextMenu='return false;' src='profile-uploads/DropchatProfile.jpg'>";
                                        }
                                        echo "</div>";
                                    ?>
                                </div>
                            </div>
                            <div id="friendSelectButton2">
                                <p><?php echo $first_name; ?> <?php echo $last_name; ?></p>
                            </div>
                        </button>
                    </form>
                    <?php
                        }
                    } else {
                        ?>
                        <p>You have no friends yet</p>
                        <?php
                    }
                    ?>
                </div>
            </div>
        <div id="homeBackground" onclick="document.getElementById('homeFriendList').style.display='none'">
            <div id="homeContentContainer">
                <div id="homeStoriesContainer">
                    <div id="homeStories">
                        <p>Share your stories using the app</p>
                    </div>
                </div>
                <div id="homeMidContent">
                   <div id="homePostingContainer">
                       <div id="homePostingContainerTop">
                           <div id="homePostingContainerTop1">
                               <div id="homePostingContainerImage">
                                <?php
                                $myId = $_SESSION['userId'];
                                $sqlImg = "SELECT * FROM users WHERE idUsers='$myId'";
                                $resultImg = mysqli_query($conn, $sqlImg);
                                if ($rowImg = mysqli_fetch_assoc($resultImg)) {
                                    if ($rowImg['imgStatus'] == 0) {
                                        echo "<img onContextMenu='return false;' src='profile-uploads/profile".$myId.".jpg?'".mt_rand().">";
                                    } else if ($rowImg['imgStatus'] == 1) {
                                        echo "<img onContextMenu='return false;' src='profile-uploads/DropchatProfile.jpg'>";
                                    }
                                }
                                ?>
                                </div>
                           </div>
                           <div id="homePostingContainerTop2" onclick="document.getElementById('homePostingPopup').style.display='block';document.getElementById('homePostingPoppedup').style.display='block'">
                               <button>Share your greatest memories</button>
                           </div>
                       </div>
                       <div id="homePostingContainerBottom">
                            <div id="homePostingImage">
                                <button onclick="document.getElementById('homeImagePopup').style.display='block';document.getElementById('homeImagePoppedup').style.display='block'"><i class="fas fa-image"></i> Photo</button>
                            </div>
                       </div>
                   </div>
                       <?php
                        $mySession = $_SESSION['userId'];
                        $postquer = "SELECT post.post_id, post.post_user, post.post_date, friends.user_two, friends.user_one, friends.friendship_official, post.post_text FROM post INNER JOIN friends ON post.post_user=friends.user_one AND friends.user_two=$mySession AND friends.friendship_official='1' OR post.post_user=friends.user_two AND friends.user_one=$mySession AND friends.friendship_official='1' OR post.post_user=$mySession AND friends.user_one='0' AND friends.user_two='0' ORDER BY post.post_id DESC;";
                        $resultpost = mysqli_query($conn, $postquer);
                        $countpost = mysqli_num_rows($resultpost);
                        
                        function url($text) {
                            $text = html_entity_decode($text);
                            $text = " ".$text;
                            $text = preg_replace('/(https{0,1}:\/\/[\w\-\.\/#?&=]*)/','<a id="postLink" href="$1" target="_blank">$1</a>',$text);
                            return $text;
                        }

                        if($countpost > 0) {
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
                            foreach ($resultpost as $rowPost) {
                            /*while ($rowPost = mysqli_fetch_assoc($resultpost)) {*/
                                $postView = $rowPost['post_user'];
                                $postid = $rowPost['post_id'];
                                $whenPosted = $rowPost['post_date'];
                                $viewingUserQuery = "SELECT * FROM users WHERE idUsers=$postView";
                                $resultViewUser = mysqli_query($conn, $viewingUserQuery);
                                $rowViewUser = mysqli_fetch_assoc($resultViewUser);
                                $VUserFname = $rowViewUser['fnameUsers'];
                                $VUserLname = $rowViewUser['lnameUsers'];
                                $postText = $rowPost['post_text'];
                                $likescase1 = '1';
                                $likescase2 = '0';
                                $likeext1 = '1';
                                $likeext2 = '0';
                               ?>
                    
                                <div id="viewPostContainer">
                                    <div id="viewPostUser">
                                        <div id="viewPostUserImg">
                                            <div id="viewPostUserImgBack">
                                            <?php
                                            if ($rowViewUser['imgStatus'] == 0) {
                                                echo "<img onContextMenu='return false;' src='profile-uploads/profile".$postView.".jpg?'".mt_rand().">";
                                            } else if ($rowViewUser['imgStatus'] == 1) {
                                                echo "<img onContextMenu='return false;' src='profile-uploads/DropchatProfile.jpg'>";
                                            }
                                            ?>
                                            </div>
                                        </div>
                                        <div id="viewPostUserName">
                                            <?php
                                            if($postView == $mySession) {
                                            ?>
                                            <p id="postUsername"><a href="pages/profile.php"><?php echo $VUserFname; ?> <?php echo $VUserLname; ?></a></p>
                                            <?php
                                            } else {
                                            ?>
                                            <p id="postUsername"><a href="pages/view.php?user=<?php echo $postView; ?>"><?php echo $VUserFname; ?> <?php echo $VUserLname; ?></a></p>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    
                                    <div id="viewPostContent">
                                        <?php $postText_final = url($postText); ?>
                                        <p id="viewPostText"><?php echo nl2br($postText_final); ?></p>
                                    </div>
                                    <div id="viewPostUserDate">
                                        <?php
                                        //$timezone = date_default_timezone_get();
                                        echo "<p>";
                                        echo timeago($whenPosted);
                                        echo "</p>";
                                        ?>
                                    </div>
                                    <div id="viewPostLikeContainer">
                                        <!--<form action="#" onSubmit="return false;" id="likeForm">-->
                                        <div id="postLikeContainer">
                                            <?php
                                            $sqlLike = "SELECT * FROM likes WHERE post_id='$postid' && like_user='$mySession'";
                                            $resultLike = mysqli_query($conn, $sqlLike);
                                            if($rowLike = mysqli_fetch_assoc($resultLike)) {
                                                echo "<button onclick='likeaction($postid, $mySession, $likescase1, $likeext1)' id='homeLikeButton$postid' class='likingButton fas fa-heart'></button>";
                                            } else {
                                                echo "<button onclick='likeaction($postid, $mySession, $likescase2, $likeext2)' id='homeLikeButton$postid' class='likingButton far fa-heart'></button>";
                                            }
                                            ?>
                                         </div>
                                        <!--</form>-->
                                        <div id="postLikeCount">
                                            <?php
                                            $sqlLikeCount = "SELECT * FROM likes WHERE post_id='$postid'";
                                            $resultLikeCount = mysqli_query($conn, $sqlLikeCount);
                                            $countLike = mysqli_num_rows($resultLikeCount);
                                            ?>
                                            <p><span id="likecounter<?php echo $postid; ?>"><?php echo $countLike; ?></span> Likes</p>
                                        </div>
                                        <div id="postLikeDisplay">
                                            <?php
                                            $sqlLikeDisplayWhole = "SELECT users.idUsers, users.fnameUsers, users.lnameUsers, users.imgStatus, likes.post_id, likes.like_user, likes.like_confirm FROM users INNER JOIN likes ON likes.post_id=$postid AND users.idUsers=likes.like_user";
                                            $resultLikeDisplayWhole = mysqli_query($conn, $sqlLikeDisplayWhole);
                                            $countLikeDisplayWhole = mysqli_num_rows($resultLikeDisplayWhole);
                                            $sqlLikeDisplay = "SELECT users.idUsers, users.fnameUsers, users.lnameUsers, friends.user_one, friends.user_two, friends.friendship_official, likes.post_id, likes.like_user, likes.like_confirm FROM users INNER JOIN friends ON friends.user_one='".$_SESSION['userId']."' AND users.idUsers=friends.user_two AND friends.friendship_official='1' OR friends.user_two='".$_SESSION['userId']."' AND users.idUsers=friends.user_one AND friends.friendship_official='1' INNER JOIN likes ON likes.post_id=$postid AND likes.like_user!='2' AND likes.like_user=users.idUsers LIMIT 2";
                                            $resultLikeDisplay = mysqli_query($conn, $sqlLikeDisplay);
                                            $countLikeDisplay = mysqli_num_rows($resultLikeDisplay);
                                            $counterDisplay = 1;
                                            if ($countLikeDisplay > 0) {
                                                while ($rowLikeDisplay = mysqli_fetch_assoc($resultLikeDisplay)) {
                                                    $DisplayFname = $rowLikeDisplay['fnameUsers'];
                                                    $DisplayLname = $rowLikeDisplay['lnameUsers'];
                                                    $theUser = $rowLikeDisplay['like_user'];
                                                    $me = $_SESSION['userId'];
                                                    if ($countLikeDisplay > 1 && $counterDisplay === 1) {
                                                        ?>
                                                        <a href="pages/view.php?user=<?php echo $theUser; ?>"><?php echo $DisplayFname; ?> <?php echo $DisplayLname; ?>, </a>
                                                        <?php
                                                    } else if ($countLikeDisplayWhole > $countLikeDisplay && $counterDisplay === 1) {
                                                        ?>
                                                        <a href="pages/view.php?user=<?php echo $theUser; ?>"><?php echo $DisplayFname; ?> <?php echo $DisplayLname; ?>  <a class="homeClickMore" id='homeClickMore<?php echo $postid; ?>' onclick='moreLikeDisplay(event, <?php echo $postid; ?>)'>
                                                            (more)
                                                            <div id="DisplayLikePop<?php echo $postid; ?>" class="DisplayLikePop">
                                                            <?php
                                                            while ($rowLikeDisplayWhole = mysqli_fetch_assoc($resultLikeDisplayWhole)) {
                                                            $DisplayWholeFname = $rowLikeDisplayWhole['fnameUsers'];
                                                            $DisplayWholeLname = $rowLikeDisplayWhole['lnameUsers'];
                                                            $user = $rowLikeDisplayWhole['idUsers'];
                                                            echo "<div class='DisplayLikeName'>";
                                                            echo "<div class='DisplayLikeUserImage'>";
                                                            echo "<div class='DisplayLikeUserImageWhite'>";
                                                            if ($rowLikeDisplayWhole['imgStatus'] == 0) {
                                                                echo "<img onContextMenu='return false;' src='profile-uploads/profile".$user.".jpg?'".mt_rand().">";
                                                            } else if ($rowLikeDisplayWhole['imgStatus'] == 1) {
                                                                echo "<img onContextMenu='return false;' src='profile-uploads/DropchatProfile.jpg'>";
                                                            }
                                                            echo "</div>";
                                                            echo "</div>";
                                                            echo "<div class='DisplayLikeNames'>";
                                                            if ($user == $_SESSION['userId']) {
                                                                echo "<a href='pages/profile.php'>";
                                                                echo $DisplayWholeFname. " " .$DisplayWholeLname;
                                                                echo "</a>";
                                                            } else {
                                                                echo "<a href='pages/view.php?user=$user'>";
                                                                echo $DisplayWholeFname. " " .$DisplayWholeLname;
                                                                echo "</a>";
                                                            }
                                                            echo "</div>";
                                                            echo "</div>";
                                                            }
                                                            ?>
                                                            </div>
                                                            </a></a>
                                                        <?php
                                                    } else if ($countLikeDisplay < 2 && $counterDisplay === 1) {
                                                        ?>
                                                        <a href="pages/view.php?user=<?php echo $theUser; ?>"><?php echo $DisplayFname; ?> <?php echo $DisplayLname; ?></a>
                                                        <?php
                                                    } else if ($countLikeDisplayWhole === 2 && $counterDisplay === 2) {
                                                        ?>
                                                        <a href="pages/view.php?user=<?php echo $theUser; ?>"><?php echo $DisplayFname; ?> <?php echo $DisplayLname; ?></a>
                                                        <?php
                                                    } else if ($countLikeDisplayWhole > 2 && $counterDisplay === 2) {
                                                        ?>
                                                        <a href="pages/view.php?user=<?php echo $theUser; ?>"><?php echo $DisplayFname; ?> <?php echo $DisplayLname; ?>  <a class="homeClickMore" id='homeClickMore<?php echo $postid; ?>' onclick='moreLikeDisplay(event, <?php echo $postid; ?>)'>
                                                            (more)
                                                            <div id="DisplayLikePop<?php echo $postid; ?>" class="DisplayLikePop">
                                                            <?php
                                                            while ($rowLikeDisplayWhole = mysqli_fetch_assoc($resultLikeDisplayWhole)) {
                                                            $DisplayWholeFname = $rowLikeDisplayWhole['fnameUsers'];
                                                            $DisplayWholeLname = $rowLikeDisplayWhole['lnameUsers'];
                                                            $user = $rowLikeDisplayWhole['idUsers'];
                                                            echo "<div class='DisplayLikeName'>";
                                                            echo "<div class='DisplayLikeUserImage'>";
                                                            echo "<div class='DisplayLikeUserImageWhite'>";
                                                            if ($rowLikeDisplayWhole['imgStatus'] == 0) {
                                                                echo "<img onContextMenu='return false;' src='profile-uploads/profile".$user.".jpg?'".mt_rand().">";
                                                            } else if ($rowLikeDisplayWhole['imgStatus'] == 1) {
                                                                echo "<img onContextMenu='return false;' src='profile-uploads/DropchatProfile.jpg'>";
                                                            }
                                                            echo "</div>";
                                                            echo "</div>";
                                                            echo "<div class='DisplayLikeNames'>";
                                                            if ($user == $_SESSION['userId']) {
                                                                echo "<a href='pages/profile.php'>";
                                                                echo $DisplayWholeFname. " " .$DisplayWholeLname;
                                                                echo "</a>";
                                                            } else {
                                                                echo "<a href='pages/view.php?user=$user'>";
                                                                echo $DisplayWholeFname. " " .$DisplayWholeLname;
                                                                echo "</a>";
                                                            }
                                                            echo "</div>";
                                                            echo "</div>";
                                                            }
                                                            ?>
                                                            </div>
                                                            </a></a>
                                                        <?php
                                                    }
                                                    $counterDisplay++;
                                                    ?>
                                                    <script type="text/javascript">
                                                        function moreLikeDisplay(e, x) {
                                                            if(document.getElementById("homeClickMore" + x).contains(e.target)) {
                                                                var popup = document.getElementById("DisplayLikePop" + x);
                                                                $("#DisplayLikePop" + x).addClass('show');
                                                                document.getElementById('LikeDisplayBackgroundPop').style.visibility='visible';
                                                            }
                                                            $("#LikeDisplayBackgroundPop").click(function () {
                                                                document.getElementById('LikeDisplayBackgroundPop').style.visibility='hidden';
                                                                if ($("#DisplayLikePop" + x).hasClass('show')) {
                                                                    $("#DisplayLikePop" + x).removeClass('show');
                                                                }
                                                            })
                                                        }
                                                    </script>
                                                    <?php
                                                }
                                            }
                                            ?>
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
                                                                    echo "<img onContextMenu='return false;' src='profile-uploads/profile".$commentUser.".jpg?'".mt_rand().">";
                                                                } else if ($rowViewCommUser['imgStatus'] == 1) {
                                                                    echo "<img onContextMenu='return false;' src='profile-uploads/DropchatProfile.jpg'>";
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div id="viewUserCommentRight">
                                                            <div id="viewUserCommentRightTop">
                                                                <?php
                                                                if($commentUser == $mySession) {
                                                                ?>
                                                                <p id="postUsername"><a href="pages/profile.php"><?php echo $commentFname; ?> <?php echo $commentLname; ?></a></p>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                <p id="postUsername"><a href="pages/view.php?user=<?php echo $commentUser; ?>"><?php echo $commentFname; ?> <?php echo $commentLname; ?></a></p>
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
                                                            $("#viewFriendCommentConatiner" + x).load('includes/load-more.inc.php', {
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
                                                        echo "<img onContextMenu='return false;' src='profile-uploads/profile".$id.".jpg?'".mt_rand().">";
                                                    } else if ($rowImg['imgStatus'] == 1) {
                                                    ?>
                                                        <img onContextMenu='return false;' src='profile-uploads/DropchatProfile.jpg'>
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
                       }
                       ?>
                </div>
            </div>
        </div>
        <?php
        
        ?>
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
                    i = 0
                    $("#homeLikeButton" + x).removeClass(class1);
                    if(i === 0) {
                        $.post("home.php",
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
                    let like = 1;
                    //like
                    i = 1
                    $("#homeLikeButton" + x).removeClass(class2);
                    if(i === 1) {
                        $.post("home.php",
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

        </script>
        <script type="text/javascript">
        
        function insertPostText() {
            if(document.getElementById("postTextarea").value==="") { 
                document.getElementById('post_submit').disabled = true;
                $("#post_submit").addClass('post_submit');
                if ($("#post_submit").hasClass('post_submitV')) {
                    $("#post_submit").removeClass('post_submitV');
                }
            } else { 
                document.getElementById('post_submit').disabled = false;
                $("#post_submit").addClass('post_submitV');
                if ($("#post_submit").hasClass('post_submit')) {
                    $("#post_submit").removeClass('post_submit');
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
            $.post('includes/postcomment.inc.php',{postid: postid, user: myself, text: textValue}, function(data){
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
        <script type="text/javascript">
            function humanTiming ($time) {
            
                $time = time() - $time; // to get the time since that moment
                $time = ($time<1)? 1 : $time;
                $tokens = array (
                    31536000 => 'year',
                    2592000 => 'month',
                    604800 => 'week',
                    86400 => 'day',
                    3600 => 'hour',
                    60 => 'minute',
                    1 => 'second'
                );
            
                foreach ($tokens as $unit => $text) {
                    if ($time < $unit) continue;
                    $numberOfUnits = floor($time / $unit);
                    return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
                }
            
            }
        </script>
    </body>
<?php
} else {
    header ("Location: index.php");
}
?>
</html>