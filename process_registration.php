<?php
    include("dbh.php");

    //Process Login
    if(isset($_POST['login'])){
        $email = strtolower($_POST['email']);
        $password = $_POST['password'];

        $checkUser = $mysqli->query("SELECT * FROM users WHERE email='$email' ");

        if(mysqli_num_rows($checkUser) <= 0){
            $_SESSION['loginError'] = "Email not found. Please try again.";
            header("location: login.php?email=".$email);
        }
        else{
            $newCheckUser = $checkUser->fetch_array();
            $hashPassword = $newCheckUser['password'];
            $verify = password_verify($password, $hashPassword);
            if ($verify){
                $_SESSION['email'] = $newCheckUser["email"];
                $_SESSION['firstname'] = $newCheckUser["firstname"];
                $_SESSION['lastname'] = $newCheckUser["lastname"];
                header("location: index.php");
            } else {
                $_SESSION['loginError'] = "Incorrect password!";
            }
        }
    }

    if(isset($_POST['register'])){
        $fname = ucfirst($_POST['fname']);
        $lname = ucfirst($_POST['lname']);
        $email = strtolower($_POST['email']);
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        $checkUser = $mysqli->query("SELECT * FROM users WHERE email='$email' ");
        if(mysqli_num_rows($checkUser)>0){
            $_SESSION['registerError'] = "Email already taken. Please try another.";
            header("location: register.php?fname=".$fname."&lname=".$lname);
        }
        else if($password1!=$password2){
            $_SESSION['registerError'] = "Password not match. Please try again.";
            header("location: register.php?fname=".$fname."&lname=".$lname."&email=".$email);
        }
        else{
            $mysqli->query(" INSERT INTO users ( firstname, lastname, email, password) VALUES('$fname','$lname','$email','$password1') ") or die ($mysqli->error());

            $_SESSION['loginError'] = "User Account Creation Successful!";
            header("location: login.php");
        }
    }

?>