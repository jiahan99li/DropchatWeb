<?php 
session_start();
include 'includes/dbh.inc.php';
if (isset($_SESSION['userId'])) {
    header ("Location: ../home.php");
} else {
?>
<!DOCTYPE HTML>
<html>
    
    <head>
        <meta charset="utf-8"> 
        <!--Title, browser bar -->
        <title>Dropchat | Login</title>
        <!--Link css stylesheet-->
        <link href="css/main.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="css/fontawesome/css/all.css">
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
        <script src="js/caroufredsel.js" type="text/javascript"></script>
        <script src="js/main.js"></script>
    </head>
    
    <header>
        <div class="indexHeaderLogoSection">
            <div id="indexHeaderRow">
                <a href="" id="indexLogo"><p class="indexLogoText default-color">Dropchat</p></a>
            </div>
        </div>
    </header>
    
    <body class="indexBody" onload="alertexclaim()">
        <script>
            function alertexclaim() {
                //alert("Page not fully completed for fluid use!");
                //alert("This website will receive a hard reset on all data. New signup will be required");
            }
        </script>
        <div id="indexMain">
            <div id="indexLeft">
                <div id="indexBackgroundContainer">
                    <video src="images/background/raindrop.mp4" disablePictureInPicture autoplay loop muted id="indexBackground"></video>
                </div>
                <div id="indexContainer">
                    <div id="text-slider">
                        <p id="text-fixed">JOIN AND LOGIN TO</p>
                    </div>
                    <div id="text-slider2">
                        <div id="slider-text">
                           <div id="slider-text1">CONNECT WITH FRIENDS AROUND THE WORLD</div>
                           <div id="slider-text2">SHARE YOUR GREATEST MEMORIES</div>
                           <div id="slider-text3">SEE PHOTOS AND UPDATES OF FRIENDS</div>
                        </div>
                    </div>
                    <div id="text-info">
                        <div id="indexinfo-text">
                           <div id="indexinfo-text1">Work in progress for...</div>
                        </div>
                    </div>
                    <div id="text-infoIcon">
                        <div id="text-infoIcon1">
                            <div id="indexinfoIcon-text">
                               <div id="indexinfoIcon-text1"><i class="fab fa-apple"></i></div><span> App Store</span>
                            </div>
                        </div>
                        <div id="text-infoIcon2">
                            <div id="indexinfoIcon2-text">
                               <div id="indexinfoIcon-text2"><i class="fab fa-android"></i></div><span> Android</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="indexRight">
                <div id="indexOriginal">
                    <div id="indexLogoImg"></div>
                </div>
            </div>
        </div>  
        
        <div id="templateWhole">
            <div id="templateWholeLeft">
                
            </div>
            
            <div id="templateWholeRight">
                <div id="indexLoginForm">
                    <div id="indexLoginHeader">
                        <h1>Log in</h1>
                    </div>
                    <div id="indexLoginActual">
                        <?php
                            if (isset($_SESSION['userId'])) {
                                header("Location: home.php");
                            }
                            else {
                                ?>
                                    <form action="includes/login.inc.php" method="post" id="indexInsideForm">
                                    <input type="text" name="mailuid" placeholder="Username or Email" class="testMail" id="indexEmail">
                                    <input type="password" name="pwd" placeholder="Password" class="testPass" id="indexPassword">
                                    <div id="forgotAnimation">
                                    <a id="indexForgot" href="accounts/forgot.php"> Forgot password? </a>
                                    </div>
                                    <div id="indexButtonContainer">
                                        <div id="indexButtonContainerRight">
                                            <button type="submit" name="login-submit" id="loginButton">Login</button>
                                        </div>
                                    </form>
                                        <div id="indexButtonContainerLeft">
                                                <form action="accounts/signup.php">
                                                    <button id="signupButton"><a href="accounts/signup.php">Sign Up</a></button>
                                                </form>
                                        </div>
                                    </div>
                                <?php
                                    }
                        ?>
                    </div>
                </div>
                    <div id="loginErrorContainer">
                        <?php
                        if(isset($_GET['error'])) {
                            if($_GET['error'] == "emptyfields") {
                                ?>
                                <p>Fill in all fields</p>
                                <?php
                            }
                            if($_GET['error'] == "wrongpwd") {
                                ?>
                                <p>Password Incorrect</p>
                                <?php
                            }
                            if($_GET['error'] == "nouser") {
                                ?>
                                <p>User does not exist</p>
                                <?php
                            }
                        }
                        ?>
                    </div>
            </div>
                <footer>
                    <div id="footerLeft">
                        
                    </div>
                    <div id="footerRight">
                        <div id="footerRight1">
                            <ul>
                                <a href="#"><li>About</li></a>
                                <a href="#"><li>Contact</li></a>
                            </ul>
                        </div>
                        <div id="footerRight2">
                            <h2>@2020 Dropchat</h2>
                        </div>
                    </div>
                </footer>
        </div>
    </body>
<?php
}
?>
</html>