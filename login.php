<?php 
if(($outUsername == $user OR $outEmail == $user) AND password_verify($password, $outPassword)){
session_start(); 

include('db.php');

$notif = '💬';

if (isset($_POST['btnLogin'])) {
    $notif = 'The button has been clicked.';

    if (!empty($_POST['user']) && !empty($_POST['password'])) {
        if (!preg_match('/;[\'$<>=&]/', $_POST['user'])) {

            $user = $_POST['user'];
            $password = $_POST['password'];

            $queryUser = mysqli_query($conn, "SELECT * FROM users WHERE (Username = '$user' OR Email = '$user')");
            $numberQuery = mysqli_num_rows($queryUser);

            if ($numberQuery > 0) {
                while ($row = mysqli_fetch_assoc($queryUser)) {
                    $outUsername = $row['Username'];
                    $outEmail = $row['Email'];
                    $outPassword = $row['Password'];

                    // Store full user data
                    $userID = $row['user_id'];
                    $fname = $row['fname'];
                    $lname = $row['lname'];
                    $userLevel = $row['user_level'];
                }

                if (($outUsername == $user || $outEmail == $user) && password_verify($password, $outPassword)) {
                    // ✅ Store session values
                    $_SESSION['user_id'] = $userID;
                    $_SESSION['username'] = $outUsername;
                    $_SESSION['user_level'] = $userLevel;
                    $_SESSION['fname'] = $fname;
                    $_SESSION['lname'] = $lname;

                    // Redirect to dashboard or appropriate location
                    header("Location: superadmin_dashboard.php");
                    exit();
                } else {
                    $notif = 'Username/Email and Password is incorrect. Please try again :(';
                }
            } else {
                $notif = 'Record is not yet in our system. Please register an account first :(';
            }
        } else {
            $notif = 'No special characters allowed. Please try again :(';
        }
    } else {
        $notif = 'Fields are required to fill up. Please try again :(';
    }
}}
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

            <h2>Login</h2>
                <center>
                    <span class='warn text-danger'><i><?php echo $notif; ?></i></span>
                </center>

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