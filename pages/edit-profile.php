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
        <title>Dropchat | Edit Profile</title>
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
                            window.location.href = "search-friends.php?friendname="+value;
                        });
            }
        }
    </script>
    
    <body class="editBody">
        <div id="editBackground">
            <div id="editContainer">
                <div id="editContainerLeft">
                    <ul>
                        <a><li id="editCurrent">Edit Profile</li></a>
                        <a href=""><li id="editNavigation">Change Password</li></a>
                        <a href=""><li id="editNavigation">Privacy and Security</li></a>
                    </ul>
                </div>
                <div id="editContainerRight">
                    <div id="editProfileImageBackContainer">
                        <div id="editProfileImageContainer">
                            <button id="editProfileImageButton"><p>Edit</p></button>
                            <?php
                            $id = $_SESSION['userId'];
                            $sqlImg = "SELECT * FROM users WHERE idUsers='$id'";
                            $resultImg = mysqli_query($conn, $sqlImg);
                            if ($rowImg = mysqli_fetch_assoc($resultImg)) {
                                if ($rowImg['imgStatus'] == 0) {
                                    echo "<img onContextMenu='return false;' onmouseover=\"document.getElementById('editProfileImageButton').style.display='block'\" onmouseout=\"document.getElementById('editProfileImageButton').style.display='none'\" src='../profile-uploads/profile".$id.".jpg?'".mt_rand().">";
                                } else if ($rowImg['imgStatus'] == 1) {
                                    ?>
                                    <img onContextMenu='return false;' onmouseover="document.getElementById('editProfileImageButton').style.display='block'" onmouseout="document.getElementById('editProfileImageButton').style.display='none'" src='../profile-uploads/DropchatProfile.jpg'>
                                    <?php
                                }
                            }
                            ?>
                        </div>
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