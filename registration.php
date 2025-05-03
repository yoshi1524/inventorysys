<?php 

        //DATABASE CONNECTION
        include('db.php');

        //NOTIFICATION
            $notif = '💬';

            //CHECK IF THE USER CLICKED THE BUTTON
                if(isset($_POST['btnRegister'])){

                    //CHECK IF ALL THE ELEMENTS HAVE BEEN FILLED UP
                    if(!empty($_POST['lastName']) AND !empty($_POST['firstName'])AND !empty($_POST['username']) AND !empty($_POST['email'])
                    AND !empty($_POST['password']) AND !empty($_POST['confirmPassword'])){
                        //CHECK FOR THE SPECIAL CHARACTERS
                        if(!preg_match('/[\'^$&{}<>;=!]/',$_POST['username'])){
                            //DECLARE THE USER'S INPUT AS VARIABLES
                            $inputFirstName = $_POST['firstName'];
                            $inputLastName = $_POST['lastName'];
                            $inputUsername = $_POST['username'];
                            $inputEmail = $_POST['email'];
                            $inputPassword = $_POST['password'];
                            $inputConfirmPassword = $_POST['confirmPassword'];
                
                            //CHECK IF THE USERNAME EXIST IN DATABASE
                            $checkUsername = mysqli_query($conn, "SELECT Username FROM users WHERE Username = '$inputUsername'");
                            $numberOfUser = mysqli_num_rows($checkUsername);
                
                            if($numberOfUser < 1){
                            //CHECK IF THE EMAIL ADDRESS EXIST IN DATABASE
                                $checkEmail = mysqli_query($conn, "SELECT Email FROM users WHERE Email = '$inputEmail'");
                                $numberOfEmail = mysqli_num_rows($checkEmail);
                
                                if($numberOfEmail < 1){
                                    //CHECK FOR THE PASSWORD CHARACTERS, MIN OF 8 CHARACTERS
                                    if(strlen($inputPassword)>= 8){
                                        //CHECK IF PASSWORDS AND CONFIRM PASSWORD ARE THE SAME
                                        if($inputPassword == $inputConfirmPassword){
                                            //HASH OR ENCRYPT THE PASSWORD//
                                            $hashPassword = password_hash($inputPassword, PASSWORD_BCRYPT, array('cost'=>12));
                                            
                
                                            //SAVE THE RECORDS IN THE DATABASE
                                            //PREPARED STATEMENT
                                            //PREPARED QUERY
                
                                            $saveRecord = $conn->prepare ("INSERT INTO `users`( `fname`, `lname`, `Username`, `Email`, `Password`) 
                                            VALUES (?,?,?,?,?)");
                
                                            //BIND PARAMETERS
                                            $saveRecord->bind_param("sssss",$inputFirstName,$inputLastName,$inputUsername,$inputEmail,$hashPassword);
                
                                            //CHECK FOR BIND ERRORS
                                            if($saveRecord->errno){
                                                $notif = 'The record has not been saved in database';
                                            }
                                            else{
                                                $notif = 'Record has been saved.';
                                                $saveRecord->execute();
                                                $saveRecord->close();
                                               $conn->close();
                                            }
                                        }
                                        else{
                                            $notif = 'Password should match with the Confirm Password.';
                                        }
                                    }
                                    else{
                                        $notif = 'Password should be at least 8 characters long. Please try again :(';
                                    }
                                }
                                else{
                                    $notif = 'Email address is already exist. Please try again :(';
                                }
                            }
                            else{
                                $notif = 'Username is already exist. Please try again :(';
                            }
                        }
                        else{
                            $notif = 'No special characters for username is allowed. Please try again :(';
                        }
                    }
                    else{
                        $notif = 'All fields are required to filled up. Please try again :(';
                    }

                }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="registration.css">
    <link rel="shortcut icon" href="qweee.png" type="image/x-icon">
</head>

<body>
    
    <form action='registration.php' method='POST'>

        <div class="flex-wrap">

            <div class='wrapper 1'>

                    <h2>Registration</h2>

                    <center>
                        <span class='warn text-danger'><i><?php echo $notif; ?></i></span>
                    </center>

                        <div class='form-group'>
                            <input type='text' name='firstName' placeholder='First Name' >
                        </div>
                        <div class='form-group'>
                            <input type='text' name='lastName' placeholder='Last Name' >
                        </div>

            </div>




            <div class='wrapper 2'>

                    <h2>Registration</h2>
                        <div class='form-group'>
                            <input type='text' name='username' placeholder='Username' >
                        </div>
                
                    
                
                        <div class='form-group'>
                            <input type='email' name='email' placeholder='Email Address' >
                        </div>
                
                        <div class='form-group'>
                            <input type='password' name='password'  placeholder='Password' >
                        </div>
                
                        <div class='form-group'>
                            <input type='password' name='confirmPassword'  placeholder='Confirm Password' >
                        </div>  
                            

                        <div class='form-group'>
                        <input type='submit' name='btnRegister' id='register' value="Register My Account">
                        <a href="login.php"><p>Already have an account? Click here to login</p></a>
                        </div>

            </div>

        </div>

    </form>

</body>
</html>