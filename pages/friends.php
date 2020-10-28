<?php
session_start();
include '../includes/dbh.inc.php';
if (isset($_SESSION['userId'])) {
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8"> 
        <!--Title, browser bar -->
        <title>Dropchat | Friends</title>
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
                <a href="../home.php"><img onContextMenu='return false;' id="logoRoundImage" src="../images/logo/RoundedLogo.png" alt="Dropchat"></a>
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
                    <a href="friends.php" id="currentPage"><li><i class="fas fa-user-friends"></i></li></a>
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
                            window.location.href = "search-friends.php?friendname="+value;
                        });
            }
        }
    </script>
    
    <body class="friendsBody">
        <div id="friendsBackground">
            <?php
            $query = "SELECT * FROM friends WHERE user_two='".$_SESSION['userId']."' AND friendship_official='0'";
            $result = mysqli_query($conn, $query);
            $count = mysqli_num_rows($result);
            $me = $_SESSION['userId'];
    
            if($count > 0) {
                ?>
                <div id="friendsRequestContainer">
                    <div id="friendsRequest">
                        <div id="friendsRequestTitle">
                            <p>Friends Requests</p>
                        </div>
                        <div id="ListingFriendsContainer">
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['user_one'];
                            ?>
                            <form id="friendsRequestForm" action="view.php" method="get"></form>
                            <button id='friendRequestButton' form="friendsRequestForm" name="user" value="<?php echo $id; ?>">
                                <div id="friendRequestButtonLeft">
                                    <div id="friendRequestImage">
                                        <?php
                                        $sqlImg = "SELECT * FROM users WHERE idUsers='$id'";
                                        $resultImg = mysqli_query($conn, $sqlImg);
                                        if ($rowImg = mysqli_fetch_assoc($resultImg)) {
                                            if ($rowImg['imgStatus'] == 0) {
                                                echo "<img onContextMenu='return false;' src='../profile-uploads/profile".$id.".jpg?'".mt_rand().">";
                                            } else if ($rowImg['imgStatus'] == 1) {
                                                echo "<img onContextMenu='return false;' src='../profile-uploads/DropchatProfile.jpg'>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div id="friendRequestButtonMid">
                                    <?php
                                    $sqlTheUser = "SELECT * FROM users WHERE idUsers='$id'";
                                    $resultTheUser = mysqli_query($conn, $sqlTheUser);
                                    $rowTheUser = mysqli_fetch_assoc($resultTheUser);
                                    $fname = $rowTheUser['fnameUsers'];
                                    $lname = $rowTheUser['lnameUsers'];
                                    $me = $_SESSION['userId'];
                                    ?>
                                    <p><?php echo $fname;?> <?php echo $lname; ?></p>
                                    <div id="nameButtonSeparator"></div>
                                </div>
                                <!--<div id="friendRequestButtonRight"></div>-->
                            </button>
                            <form action="../includes/friendlist.inc.php" method="post">
                                <div id="friendRequestButtonRight">
                                <button id='friendRequestButtonRight1' name='acceptFriendFL'><i class="fas fa-check"></i> Accept</button>
                                <button id='friendRequestButtonRight2' name='rejectFriendFL'><i class="fas fa-times"></i> Reject</button>
                                <input type='hidden' name='user_one' value='<?php echo "$me";?>'/> 
                                <input type='hidden' name='user_two' value='<?php echo "$id";?>'/> 
                                </div>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            }
            ?>
            <div id="friendsListContainer">
                <div id="friendsList">
                    <div id="friendsListTitle">
                        <p>Friends</p>
                    </div>
                    <?php
                    $query = "SELECT users.idUsers, users.fnameUsers, users.lnameUsers, users.imgStatus, friends.user_one, friends.user_two, friends.friendship_official FROM users INNER JOIN friends ON friends.user_two='".$_SESSION['userId']."' AND friends.friendship_official='1' AND users.idUsers=friends.user_one OR friends.user_one='".$_SESSION['userId']."' AND friends.friendship_official='1' AND users.idUsers=friends.user_two ORDER BY users.fnameUsers ASC";
                    $result = mysqli_query($conn, $query);
                    $count = mysqli_num_rows($result);
           
                    if($count > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $user_sending = $row['idUsers'];
                            $me = $_SESSION['userId'];
                        ?>
                        <form id="friendsListForm" action="view.php" method="get"></form>
                        <div class="ListOfFriends">
                        <button id='friendListButton' form="friendsListForm" name="user" value="<?php echo $user_sending; ?>">
                            <div id="friendListButtonLeft">
                                <div id="friendListImage">
                                    <?php
                                    if ($row['imgStatus'] == 0) {
                                        echo "<img onContextMenu='return false;' src='../profile-uploads/profile".$user_sending.".jpg?'".mt_rand().">";
                                    } else if ($row['imgStatus'] == 1) {
                                        echo "<img onContextMenu='return false;' src='../profile-uploads/DropchatProfile.jpg'>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div id="friendListButtonMid">
                                <?php
                                $fname = $row['fnameUsers'];
                                $lname = $row['lnameUsers'];
                                $me = $_SESSION['userId'];
                                ?>
                                <p><?php echo $fname;?> <?php echo $lname; ?></p>
                                <div id="nameButtonSeparator"></div>
                            </div>
                        </button>
                        <form action="../includes/friendlist.inc.php" method="post">
                            <div id="friendListButtonRight">
                            <input type='hidden' name='user_one' value='<?php echo "$me";?>'/> 
                            <input type='hidden' name='user_two' value='<?php echo "$user_sending";?>'/>
                            <button id='friendListButtonRight1' name='chatFriendFL'><i class="fas fa-comments"></i> Chat</button>
                            <button id='friendListButtonRight2' name='removeFriendFL'><i class="fas fa-user-minus"></i> Unfriend</button>
                            </div>
                        </form>
                        </div>
                        <?php
                        }
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
<?php
} else {
    header ("Location: ../index.php");
}
?>
</html>