<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
    
    <head>
        <meta charset="utf-8"> 
        <!--Title, browser bar -->
        <title>Dropchat | Sign Up</title>
        <!--Link css stylesheet-->
        <link href="../css/main.css" rel="stylesheet" type="text/css">
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
    
   <body class="signupBody">
       <div id="signupBackground">
           <div id="signupLogoSection">
               <h1 id="signupLogoText"><a href="../index.php">Dropchat</a></h1>
           </div>
           <div id="signupFormSection">
                <div id="signupForm">
                    <div id="signupError">
                       <?php
                            if(isset($_GET['error'])) {
                                if($_GET['error'] == "emptyfields") {
                                    echo '<p>Fill in all fields!</p>';
                                }
                                else if ($_GET['error'] == "invaliduidmail") {
                                    echo '<p>Invalid username and e-mail!</p>';
                                }
                                else if ($_GET['error'] == "invaliduidmail") {
                                    echo '<p>Invalid username and e-mail!</p>';
                                }
                                else if ($_GET['error'] == "invaliduid") {
                                    echo '<p>Invalid username!</p>';
                                }
                                else if ($_GET['error'] == "invalidmail") {
                                    echo '<p>Invalid e-mail!</p>';
                                }
                                else if ($_GET['error'] == "usertaken") {
                                    echo '<p">Username is alreadytaken!</p>';
                                }
                            }
                        ?>
                    </div>
                    <div id="signupActualForm">
                        <form action="../includes/signup.inc.php" method="post">
                                <input id="signupFname" type="text" name="fname" placeholder="First Name" autocomplete="off">
                                <input id="signupLname" type="text" name="lname" placeholder="Last Name" autocomplete="off">
                                <input id="signupUsername" type="text" name="uid" placeholder="Username" autocomplete="off">
                                <input id="signupDate" type="date" name="date" placeholder="Date of Birth">
                                <input id="signupMail" type="text" name="mail" placeholder="Email Address" autocomplete="off">
                                <input id="signupPassword1" type="password" name="pwd" placeholder="Password">
                                <input id="signupPassword2" type="password" name="pwd-repeat" placeholder="Repeat Password">
                                <div id="signupButtons">
                                    <div id="signupButtonsRight">
                                        <button class="signupButton" id="signupSignup" type="submit" name="signup-submit">Sign Up</button>
                                    </div>
                        </form>
                                    <div id="signupButtonsLeft">
                                        <form action="../index.php">
                                            <button id="signupLogin" href="../index.php">Go Back</button>
                                        </form>
                                    </div>
                                </div>
                    </div>
               </div>
           </div>
                <footer>
                    <div id="restFooterLeft">
                        <ul>
                            <a href="#"><li>About</li></a>
                            <a href="#"><li>Contact</li></a>
                        </ul>
                    </div>
                    <div id="restFooterRight">
                        <h2>@2020 Dropchat</h2>
                    </div>
                </footer>
       </div>
   </body>
   
</html>