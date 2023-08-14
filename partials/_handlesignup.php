<?php
    $showError = "false";
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        include '_dbconnect.php';
        $user_email = $_POST['signupemail'];
        $pass = $_POST['signuppassword'];
        $cpass = $_POST['signupcpassword'];
        //check whether this email exist
        $existSql = "select * from users where user_email = '$user_email'";
        $result = mysqli_query($conn, $existSql);
        $numrows = mysqli_num_rows($result);
        if($numrows>0){
            $showError = "Email already in use";
        }
        else{
            if($pass == $cpass){
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (user_email, user_password, time_stamp) VALUES ('$user_email', '$hash', current_timestamp())";
                $result = mysqli_query($conn, $sql);
                if($result){
                    $showAlert = true;
                    header("Location: /forms/forums.php?signupsuccess=true");
                    exit();
                }
            }
            else{
                $showError = "Passwords do not match";
            }
        }
        header("Location: /forms/forums.php?signupsuccess=false&error=$showError");

    }
?>