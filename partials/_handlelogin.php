<?php
    $showError = "false";
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        include '_dbconnect.php';
        $email = $_POST['loginemail'] ;
        $pass = $_POST['loginpass'];
        $sql="select * from users where user_email = '$email'";
        $result = mysqli_query($conn, $sql);
        $numrows = mysqli_num_rows($result);
        if($numrows==1){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($pass, $row['user_password']) && $email===$row['user_email']){
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['srno'] = $row['srno'];
                $_SESSION['useremail']=$email;
                echo "Logged in" . $email;
                header("Location: /forms/forums.php");
                // exit();
            }          
            header("Location: /forms/forums.php?password=". $showError);
        }
        else{
            
            header("Location: /forms/forums.php?loginerror=". $showError);
        }

    }
?>