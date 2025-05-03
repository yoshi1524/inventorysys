<?php
session_start();
$servername = "localhost";
$username = "root";        
$password = "";           
$dbname = "tcinv";  

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn) {
    echo "Success!";
}
// Registration form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
   
        $sql = "INSERT INTO `users` (`fname`, `lname`, `username`, `email`, `password`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $fname, $lname, $username, $email, $password, $user_level_id);
        
        if ($stmt->execute()) {
            echo "Registration successful! Redirecting to login page...";
        } else {
            echo "Error: " . $stmt->error;
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/registration.css">
</head>
<body>
    <div class="wrapper">
        <h2>Register</h2>
        <form action="reg.php" method="post" enctype="multipart/form-data">

        <label for="firstname">First Name:</label>
        <input type="text" name="firstname" required>

        <label for="lastname">Last Name:</label>
        <input type="text" name="lastname" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Register</button>
        <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>
</html>