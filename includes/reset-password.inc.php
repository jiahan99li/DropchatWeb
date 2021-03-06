<?php

    if(isset($_POST["reset-password-submit"])) {
        
        $selector = $_POST["selector"];
        $validator = $_POST["validator"];
        $password = $_POST["pwd"];
        $passwordRepeat = $_POST["pwd-repeat"];
        
        if (empty($password) || empty($passwordRepeat)) {
            header("Location:  ../accounts/reset-password.php?newpwd=fillfields&selector=" . $selector . "&validator=" . $validator);
            exit();
        } else if ($password != $passwordRepeat) {
            header("Location:  ../accounts/reset-password.php?newpwd=notmatch&selector=" . $selector . "&validator=" . $validator);
            exit();
        }
        
        $currentDate = date("U");
        
        require 'dbh.inc.php';
        
        $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >=?";
        $stmt = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error!";
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
            mysqli_stmt_execute($stmt);
            
            $result = mysqli_stmt_get_result($stmt);
            if (!$row = mysqli_fetch_assoc($result)) {
                echo 'There was an error. Please re-submit your reset request.';
                exit();
            } else {
                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);
                    if ($tokenCheck === false) {
                        echo 'There was an error. Please re-submit your reset request.';
                        exit();
                    } elseif ($tokenCheck === true) {
                        $tokenEmail = $row["pwdResetEmail"];
                        $sql = "SELECT * FROM users WHERE emailUsers=?;";
                        $stmt = mysqli_stmt_init($conn);
                        
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "There was an error!";
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "s", $tokenEmail);  
                            mysqli_stmt_execute($stmt);
                             $result = mysqli_stmt_get_result($stmt);
                            if (!$row = mysqli_fetch_assoc($result)) {
                                echo 'There was an error';
                                exit();
                            } else {
                                $sql = "UPDATE users SET pwdUsers=? WHERE emailUsers=?";
                                $stmt = mysqli_stmt_init($conn);
        
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    echo "There was an error!";
                                    exit();
                                } else {
                                    $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                                    mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);  
                                    mysqli_stmt_execute($stmt);
                                    
                                    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
                                    $stmt = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        echo "There was an error!";
                                        exit();
                                    } else {
                                        mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                        mysqli_stmt_execute($stmt);
                                        header("Location: ../accounts/success-reset.php");
                                    }
                                }
                            }
                        }
                        }
        }
    }
        
    } else {
        header("Location: ../index.php");
    }

