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
        <title>Dropchat | Search</title>
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
                <form action="#" method="get">
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
    
    <body class="search-friendsBody">
        <div id="search-friendsBackground">
            <div id="search-friendsContainer">
                <div id="searchResult">
                    <?php
                    if (isset($_GET['friendname'])){
                        $_SESSION['frname'] = $_GET['friendname'];
                        $frname = $_SESSION['frname'];
                        ?>
                        <h1>Searching for '<?php echo $frname; ?>'</h1>
                        <?php
                        $nameResult = $_SESSION['userId'];
                    } else 
                    if(isset($_POST)){
                        $_GET['friendname'] = $_GET['friendname'];
                        $_SESSION['frname'] = $_GET['friendname'];
                        $frname = $_SESSION['frname'];
                        ?>
                        <h1>Searching for '<?php echo $frname; ?>'</h1>
                        <?php
                        $nameResult = $_SESSION['userId'];
                    }
                    ?>
                </div>
                <div id="searchOutcome">
                    <?php
                    if(!empty($frname)) {
                    $frname = preg_replace("#[^0-9a-z]#i","",$frname);
                    $query = "SELECT * FROM users WHERE fnameUsers LIKE '%$frname%' OR lnameUsers LIKE '%$frname%' AND idUsers!=$nameResult";
                    $result = mysqli_query($conn, $query);
                    $count = mysqli_num_rows($result);
                    $me = $_SESSION['userId'];
                    $fquery = "SELECT * FROM users WHERE idUsers";
                    $fresult = mysqli_query($conn, $fquery);
                        
                        
                    if($count > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $fname = $row['fnameUsers'];
                            $lname = $row['lnameUsers'];
                            $id = $row['idUsers'];
                            $nameResult = $_SESSION['userId'];
                            
                            if($id != $_SESSION['userId']) {
                            ?>
                            <div id="searchOutcomeContainer">
                                <form id="friendSearchResult" action="view.php" method="get"></form>
                                    <button id='searchOutcomeButton' form="friendSearchResult" name="user" value="<?php echo $id; ?>">
                                    <?php
                                    $sqlImg = "SELECT * FROM users WHERE idUsers='$id'";
                                    $resultImg = mysqli_query($conn, $sqlImg);
                                    if ($rowImg = mysqli_fetch_assoc($resultImg)) {
                                        ?>
                                        <div id="searchImageLeft">
                                        <div id="searchOutcomeImage">
                                        <?php
                                        if ($rowImg['imgStatus'] == 0) {
                                            echo "<img src='../profile-uploads/profile".$id.".jpg?'".mt_rand().">";
                                        } else if ($rowImg['imgStatus'] == 1) {
                                            echo "<img src='../profile-uploads/DropchatProfile.jpg'>";
                                        }
                                        ?>
                                        </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div id="searchImageRight">
                                    <p><?php echo $fname;?> <?php echo $lname; ?></p>
                                    </div>
                                    
                                    <div id="searchImageButton"></div>
                                    </button>
                                    <?php
                                    $get_friends = "SELECT * FROM friends";
                                    $gfresult = mysqli_query($conn, $get_friends);
                                    require_once '../classes/friendclass.php';
                                
                                    if ($rowAdd = mysqli_fetch_assoc($gfresult)) {
                                        $one = $rowAdd['user_one'];
                                        $two = $rowAdd['user_two'];
                                        $fr_official = $rowAdd['friendship_official'];
                                        
                                        ?>
                                        <form id="searchButtonSection" action="../includes/friends.inc.php" method="post">
                                        <div id="searchActionButton">
                                        <?php
                                        if (Friends::renderFriendShip($_SESSION['userId'], $id, 'isThereRequestPending') == 1) {
                                        ?>
                                            <button id='reqPending' disabled form="searchButtonSection"><p>Request Pending</p></button>
                                         <?php
                                        } else if (Friends::renderFriendShip($_SESSION['userId'], $id, 'isItAccepted') == 1) {
                                        ?>
                                            <input type='hidden' name='user_one' value='<?php echo "$nameResult";?>'/> 
                                            <input type='hidden' name='user_two' value='<?php echo "$id";?>'/> 
                                            <input type='hidden' name='search_name' value='<?php echo "$frname";?>'/>
                                            <button id='acceptBtn' name='acceptFriend'><p><i class="fas fa-check"></i> Accept</p></button>
                                            <button id='rejectBtn' name='rejectFriend'><i class="fas fa-times"></i> Reject</button>
                                        <?php
                                        } else if (Friends::renderFriendShip($_SESSION['userId'], $id, 'isThereFriendship') == 0) {
                                        ?>
                                            <input type='hidden' name='user_one' value='<?php echo "$nameResult";?>'/> 
                                            <input type='hidden' name='user_two' value='<?php echo "$id";?>'/> 
                                            <input type='hidden' name='search_name' value='<?php echo "$frname";?>'/> 
                                            <button id='friendBtn' value='' name='addfriend'><i class="fas fa-user-plus"></i> Add Friend</button>
                                        <?php
                                        } else {
                                        ?>
                                            <input type='hidden' name='user_one' value='<?php echo "$nameResult";?>'/> 
                                            <input type='hidden' name='user_two' value='<?php echo "$id";?>'/> 
                                            <input type='hidden' name='search_name' value='<?php echo "$frname";?>'/> 
                                            <button id='chatfriend' name='chatFriendFL'><i class="fas fa-comments"></i> Chat</button>
                                            <button id='unfriendBtn' name='unfriend'><i class="fas fa-user-minus"></i> Remove</button>
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        </form>
                                        <?php
                                    }
                                    ?>
                            </div>
                            <?php
                            } else {
                                ?>
                                <div id="searchOutcomeContainer">
                                    <form action="profile.php">
                                        <button id='searchOutcomeButton'>
                                        <?php
                                        $sqlImg = "SELECT * FROM users WHERE idUsers='$id'";
                                        $resultImg = mysqli_query($conn, $sqlImg);
                                        if ($rowImg = mysqli_fetch_assoc($resultImg)) {
                                            ?>
                                            <div id="searchImageLeft">
                                            <div id="searchOutcomeImage">
                                            <?php
                                            if ($rowImg['imgStatus'] == 0) {
                                                echo "<img src='../profile-uploads/profile".$id.".jpg?'".mt_rand().">";
                                            } else if ($rowImg['imgStatus'] == 1) {
                                                echo "<img src='../profile-uploads/DropchatProfile.jpg'>";
                                            }
                                            ?>
                                            </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <div id="searchImageRight">
                                        <p><?php echo $fname;?> <?php echo $lname; ?></p>
                                        </div>
                                        </button>
                                    </form>
                                </div>
                                <?php
                            }
                        }
                    }
                    }
                    ?>
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