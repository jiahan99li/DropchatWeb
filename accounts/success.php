<?php
include '../includes/dbh.inc.php';

$fname = $_GET['fname'];
$lname = $_GET['lname'];
$username = $_GET['username'];
$email = $_GET['email'];
$password = $_GET['password'];
$date = $_GET['date'];
$status = $_GET['status'];
$privacy = 1;
$currentDate = date("U");

$sql = "SELECT * FROM creatAcc WHERE createAccEmail=? AND createAccExpires >=?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "There was an error!";
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "ss", $email, $currentDate);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    if (!$row = mysqli_fetch_assoc($result)) {
        echo 'There was an error. Please re-submit your reset request.';
        exit();
    } else {
        $sql = "INSERT INTO users (fnameUsers, lnameUsers, uidUsers, emailUsers, pwdUsers, dateUsers, imgStatus, privacyUsers) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup.php?signup&error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "ssssssss", $fname, $lname, $username, $email, $password, $date, $status, $privacy);
            mysqli_stmt_execute($stmt);
        }
    }
    $sql = "DELETE FROM creatAcc WHERE createAccEmail=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error!";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
    }
}
?>
<!DOCTYPE HTML>
<html>
    
    <head>
        <meta charset="utf-8"> 
        <!--Title, browser bar -->
        <title>Dropchat | Successfully Registered</title>
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
    
    <body class="signupSuccessBody">
        <div id="signupSuccessBackground">
            <div id="signupSuccessLogoSection">
               <h1 id="signupSuccessLogoText"><a href="../index.php">Dropchat</a></h1>
            </div>
            <div id="signupSuccessSection">
               <div id="signupSuccessContainer">
                   <h2><span><i class="fas fa-check"></i></span><br>You have successfully registered your account</h2>
                   <h3>Congratulations!<br> You can now log in and enjoy your time with your friends.</h3>
               </div>
            </div>
            <div id="signupSuccessFormContainer">
                <form action="../index.php">
                    <button id="signupSuccessLogin" href="../index.php">Log In</button>
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