<?php

    if (isset($_POST["reset-request-submit"])) {
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
        
        //$url = "../forgottenpwd/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
        $url = "dropchat.chiahan.com/accounts/reset-password.php?selector=".$selector."&validator=".bin2hex($token);
        
        $expires = date("U") + 1800; //in seconds
        
        require 'dbh.inc.php';
        
        $userEmail = $_POST["email"];
        
        $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
        $stmt = mysqli_stmt_init($conn);
        
        if (empty($userEmail)){
            header("Location: ../accounts/forgot.php?reset=fillfields");
            exit();
        }
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo 'There was an error!';
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $userEmail);
            mysqli_stmt_execute($stmt);
        }
        
        $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error!";
            exit();
        } else {
            $hashedToken = password_hash($token, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
            mysqli_stmt_execute($stmt);
        }
        
        mysqli_stmt_close($stmt); 
        mysqli_close($conn);
        
        require 'phpmailer.inc.php';
        
        $mail->setFrom('noreply@dropchat.chiahan.com', 'Dropchat');
        $mail->addAddress($userEmail);
        $mail->addReplyTo('noreply@dropchat.chiahan.com');
        
        $mail->Subject = 'Reset your password';
        //$mail->addAttachment('/images/logo.png'); 
    
        $mail->Body = '<p>You have recently requested a password reset. Follow the link below to reset your password. If you did not request a password reset, you can ignore this email.</p>';
        $mail->Body .= '<p> You password reset link is: <br></p>';
        $mail->Body .= '<p><a href="' .$url . '">' . $url . '</a></p>';
        
        $mail->send();
        
        header("Location: ../accounts/forgotMailCheck.php");
        
    } else {
        header("Location: ../index.php");
    }