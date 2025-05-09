<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_level_id'] = $user['user_level_id'];
        $_SESSION['fname'] = $user['fname'];
        $_SESSION['lname'] = $user['lname'];

        // redirect based on role
        if ($user['user_level_id'] == 1) {
            header("Location: supad.php");
        } elseif ($user['user_level_id'] == 2) {
            header("Location: mandash.php");
        } else {
            header("Location: crewdashboard.php");
        }
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="shortcut icon" href="qweee.png" type="image/x-icon">
</head>

<body>
    
    <form action='login.php' method='POST'>

        <div class= 'wrapper'>
                    <div class= 'form-group'>
                        <input type='text' name='user' placeholder='Username or Email Address'>
                    </div>
                    <div class= 'form-group'>
                        <input type='password' name='password' placeholder='Password' id='password'>
                    </div>
                    <br>
                    <div class= 'form-group'>
                        <input type='submit' name='btnLogin' id='login' value="Login my Account">
                    </div>
                    <center>
                        <a href="registration.php">New user? Click here to create an account</a>
                    </center>

        </div>

    </form>

</body>
</html>