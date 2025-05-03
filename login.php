<?php 

        //DATABASE CONNECTION
            include('db.php');

        //NOTIFICATION
            $notif = '💬';

            //CHECK IF THE USER CLICKED THE BUTTON
                if(isset($_POST['btnLogin'])){

                    $notif='The button has been clicked.';
                    //USERNAME AND PASSWORD SHOULD BE COMPLETELY FILLED UP
                    if (!empty($_POST['user']) AND !empty($_POST['password'])){
                        //CHECK FOR SPECIAL CHARACTERS IN USERNAME
                        if(!preg_match('/;[\'$<>=&]/', $_POST['user'])){
                
                            //user's input from the form
                            $user = $_POST['user'];
                            $password = $_POST['password'];
                
                            //QUERY FOR username/email and password
                            $queryUser = mysqli_query($conn, "SELECT * FROM users WHERE (Username = '$user' OR Email  = '$user')");
                            $numberQuery = mysqli_num_rows($queryUser);
                
                            if($numberQuery > 0){
                               //PULL OUT THE RECORDS IN THE DATABASE
                               while($row = mysqli_fetch_assoc($queryUser)){
                                $outUsername = $row['Username'];
                                $outEmail = $row['Email'];
                                $outPassword = $row['Password'];
                               }
                               if(($outUsername == $user OR $outEmail == $user) AND password_verify($password, $outPassword)){
                                    $notif = 'Login Successfully';
                                    //SESSION
                                    //$_SESSION['username'] = $user;
                                    //header("Location: ");
                                    //exit();
                               }
                               else{
                                    $notif = 'Username/Email and Password is incorrect. Please try again :(';
                               }
                
                            }
                            else{
                                $notif = 'Record is not yet in our system. Please register an account first :(';
                            }
                        }
                        else{
                            $notif = 'No special characters allowed. Please try again :(';
                        }
                    }
                    else{
                        $notif = 'Fields are required to fill up. Please try again :(';
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