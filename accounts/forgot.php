<html>
    
    <head>
        <meta charset="utf-8"> 
        <!--Title, browser bar -->
        <title>Dropchat | Forgot Password</title>
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
    
    <body class="forgotBody">
        <div id="forgotBackground">
            <div id="forgotLogoSection">
               <h1 id="forgotLogoText"><a href="../index.php">Dropchat</a></h1>
            </div>
            <div id="forgotInfoText">
                <div id="forgotInfoContent">
                    <h1>Oops!</h1>
                    <h2>It seems you have forgotten your password.</h2>
                    <h2>Dont worry. Enter your password and you will receive a reset link.</h2>
                </div>
            </div>
            <div id="forgotError">
                <?php
                    if (isset($_GET["reset"])) {
                        if ($_GET["reset"] == "fillfields") {
                            echo '<p id="forgotInfoError">Fill in the field</p>';
                        }
                    }
                    if (isset($_GET["reset"])) {
                        if ($_GET["reset"] == "success") {
                            echo '<p id="forgotInfoCheck">Check your e-mail</p>';
                            /* header("Location: forgotMailCheck.php") */
                        }
                    }
                ?>
            </div>
            <div id="forgotInputSection">
                <form action="../includes/forgot.inc.php" method="post" id="forgotFormContainer">
                    <input id="forgotMail" type="text" name="email" placeholder="Email Address">
                    <button type="submit" name="reset-request-submit" id="forgotSubmit">Reset you password</button>
                </form>
                <form action="../index.php" id="forgotLoginContainer">
                    <button id="forgotLogin">Log In</button>
                </form>
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