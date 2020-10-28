<!DOCTYPE HTML>
<html>
    
    <head>
        <meta charset="utf-8"> 
        <!--Title, browser bar -->
        <title>Dropchat | Reset Password</title>
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
    
    <body class="resetBody">
        <div id="resetBackground">
            <div id="resetLogoSection">
               <h1 id="resetLogoText"><a href="../index.php">Dropchat</a></h1>
           </div>
           <div id="resetErrorContainer">
               <?php
                    if (isset($_GET["newpwd"])) {
                        if ($_GET["newpwd"] == "fillfields") {
                            echo '<p>Fill in the fields</p>';
                        }
                    }
                    if (isset($_GET["newpwd"])) {
                        if ($_GET["newpwd"] == "notmatch") {
                            echo '<p>Password does not match</p>';
                        }
                    }
                ?>
           </div>
           <div id="resetPasswordContainer">
                <?php
                $selector = $_GET["selector"];
                $validator = $_GET["validator"];
               
                if (empty($selector) || empty($validator)) {
                    echo "Could not validate your request!";
                } else {
                    if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                        ?>
                            <form action="../includes/reset-password.inc.php" method="post" id="resetForm">
                                <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                                <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                                <p></p>
                                <input id="resetPassword1" type="password" name="pwd" placeholder="New password">
                                <p></p>
                                <input id="resetPassword2" type="password" name="pwd-repeat" placeholder="Repeat password">
                                <p></p>
                                <button id= "resetButton" type="submit" name="reset-password-submit">Reset password</button>
                            </form>
                        <?php
                    }
                }
                ?>
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