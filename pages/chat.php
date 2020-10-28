<?php
session_start();
include '../includes/dbh.inc.php';
?>
<?php
if (isset($_SESSION['userId'])) {
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8"> 
        <!--Title, browser bar -->
        <title>Dropchat | Chat</title>
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
        <script src="../js/chat.js"></script>
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
                    <a href="chat.php" id="currentPage"><li><i class="fas fa-comment"></i></li></a>
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
    
    <body class="chatBody">
        <div id="chatBackground">
            <div id="chatContentLeft">
                <div id="chatContentLeftTitle">
                    <p>Friends List</p>
                </div>
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
                        <form id="chatUserSelect" action="chat.php" method="get">
                            <button name="chat_id" type="submit" value="<?php echo $user_sending; ?>">
                                <div id="chatUserButtonLeft">
                                    <div id="chatUserImage">
                                        <?php
                                        $sqlImg = "SELECT * FROM users WHERE idUsers='$user_sending'";
                                        $resultImg = mysqli_query($conn, $sqlImg);
                                        $rowImg = mysqli_fetch_assoc($resultImg);

                                        echo "<div id='profileFriend'>";
                                        if ($rowImg['imgStatus'] == 0) { 
                                            echo "<img onContextMenu='return false;' src='../profile-uploads/profile".$user_sending.".jpg?'".mt_rand().">";
                                        } else if ($rowImg['imgStatus'] == 1) {
                                            echo "<img onContextMenu='return false;' src='../profile-uploads/DropchatProfile.jpg'>";
                                        }
                                        echo "</div>";
                                        ?>
                                    </div>
                                </div>
                                <div id="chatUserButton">
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
            <div id="chatContent">
                <?php
                if(isset($_GET['chat_id'])) {
                ?>
                <div id="chatContentTop">
                    <div id="chatContentTopContent">
                        <?php
                        $chattingUser = $_GET['chat_id'];
                        $sqlChatUser = "SELECT * FROM users WHERE idUsers=$chattingUser";
                        $resultChatUser = mysqli_query($conn, $sqlChatUser);
                        $rowChatUser = mysqli_fetch_assoc($resultChatUser);
                        $chatFname = $rowChatUser['fnameUsers'];
                        $chatLname = $rowChatUser['lnameUsers'];
                    
                        $_SESSION['receiver'] = $_GET['chat_id'];
                        $sendingto_id = $_GET['chat_id'];
                        $my_id = $_SESSION['userId'];
                        $now = date("Y-m-d h:i:s");
                        $read = "0";
                        ?>
                        <p><?php echo $chatFname; ?> <?php echo $chatLname; ?></p>
                    </div>
                </div>
                <div id="chatContentWrapper">
                <div id="chatContentMid" class="chatContentMid">
                    <?php
                        $query = "SELECT * FROM chat";
                        $resultquery = mysqli_query($conn, $query);
                        $rowquery = mysqli_fetch_assoc($resultquery);

                        while ($rowquery = mysqli_fetch_assoc($resultquery))
                        {
                            $sender = $rowquery['sender_id'];
                            $message = $rowquery['msg_content'];

                            if($rowquery['sender_id'] == $my_id && $rowquery['receiver_id'] == $sendingto_id){
                                ?>
                                <ul id="chatContentMidContainer" updateScroll()>
                                <li class='cm'><p id="msgText_right"><?php echo $message; ?></p></li>
                                </ul>
                                <?php
                            } else if ($rowquery['sender_id'] == $sendingto_id && $rowquery['receiver_id'] == $my_id){
                                ?>
                                <ul id="chatContentMidContainer" updateScroll()>
                                <li class='cm'><p id="msgText_left"><?php echo $message; ?></p></li>
                                </ul>
                                <?php
                            }
                        }
                        ?>
                </div>
                </div>
                <div id="chatContentBot">
                    <div id="chatContentBot1">
                        <form action="#" onSubmit="return false;" id="chatForm">
                            <button type="submit" name="send_msg"><i class="fas fa-paper-plane"></i></button>
                    </div>
                    <div id="chatContentBot2">
                            <input type="hidden" id="sending" name="sending" value="<?php echo $my_id; ?>">
                            <input type="hidden" id="receiving" name="receiving" value="<?php echo $sendingto_id; ?>">
                            <input type="hidden" id="time" name="time" value="<?php echo $now; ?>">
                            <input type="hidden" id="read" name="read" value="<?php echo $read; ?>">
                            <textarea autofocus type="text" name="text" id="text" value="" placeholder="" autocomplete="off"></textarea>
                        </form>
                    </div>
                </div>
                <?php
                } else {
                    ?>
                    <div id="noChat1"></div>
                    <div id="noChat2">
                        <div id="noChat2Image">
                            <img src="../images/logo/LogoQuestion.png" onContextMenu="return false;">
                        </div>
                        <p>Click on a friend to start a conversation</p>
                    </div>
                    <div id="noChat3"></div>
                    <?php
                }
                ?>
            </div>
        </div>
    </body>
<?php
} else {
    header ("Location: ../index.php");
}
?>
</html>