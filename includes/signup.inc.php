<?php
if (isset($_POST['signup-submit'])) {

   require 'dbh.inc.php';

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['uid'];
    $mail = $_POST['mail'];
    $email = strtolower($mail);
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];
    $date = $_POST['date'];
    $status = '1';
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    
    $url = "dropchat.chiahan.com/accounts/success.php?fname=".$fname."&lname=".$lname."&username=".$username."&email=".$email."&password=".$hashedPwd."&date=".$date."&status=".$status;
    
    $expires = date("U") + 1800;

    if (empty($fname) || empty($lname) || empty($username) || empty($email) || empty($password) || empty($passwordRepeat) || empty($date)) {
        header("Location: ../accounts/signup.php?signup&error=emptyfields&uid=".$username."&mail=".$email);
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../accounts/signup.php?signup&error=invalidmailuid");
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../accounts/signup.php?signup&error=invalidmail&uid=".$username);
        exit();
    }
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../accounts/signup.php?signup&error=invaliduid&mail=".$email);
        exit();
    }
    else if ($password !== $passwordRepeat) {
        header("Location: ../accounts/signup.php?signup&error=passwordcheck&uid=".$username."&mail=".$email);
        exit();
    }
    //if username already taken
    else {
        $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../accounts/signup.php?signup&error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: ../accounts/signup.php?signup&error=usertaken&mail=".$email);
                exit();
            } else {
                $sql = "SELECT emailUsers FROM users WHERE emailUsers=?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../accounts/signup.php?signup&error=sqlerror");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                    $resultCheck = mysqli_stmt_num_rows($stmt);
                    if ($resultCheck > 0) {
                        header("Location: ../accounts/signup.php?signup&error=invalidmail&uid=".$username);
                        exit();
                    }
                    else {
                    $sql = "INSERT INTO creatAcc (createAccEmail, createAccExpires) VALUES (?, ?);";
                    $stmt = mysqli_stmt_init($conn);
        
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "There was an error!";
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "ss", $email, $expires);
                        mysqli_stmt_execute($stmt);
                    }
        
                    mysqli_stmt_close($stmt); 
                    mysqli_close($conn);
                    
                    require 'phpmailer.inc.php';
        
                    $mail->setFrom('noreply@dropchat.chiahan.com', 'Dropchat');
                    $mail->addAddress($email);
                    $mail->addReplyTo('noreply@dropchat.chiahan.com');
                    
                    $mail->Subject = 'Create your account';
                    //$mail->addAttachment('/images/logo.png'); 
                
                    $mail->Body = '<p>Click the link or copy and paste it into your browser to finish creating your account.</p>';
                    $mail->Body .= '<p> The link is: <br></p>';
                    $mail->Body .= '<p><a href="' .$url . '">' . $url . '</a></p>';
                    
                    $mail->send();
                    
                    header("Location: ../accounts/signupMailCheck.php");
            }
        }
    }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}
else {
    header("Location: ../signup.php");
    exit();
}
