<?php
require 'db.php';
session_start();

$firstName = $_POST['fname'] ?? null;
$lastName = $_POST['lname'] ?? null;
$email = $_POST['email'] ?? null;
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if ($firstName && $lastName && $email && $username && $password) {
    $stmt = $pdo->prepare("INSERT INTO users (fname, lname, email, username, password, user_level_id)
                           VALUES (?, ?, ?, ?, ?, '1')");
    $stmt->execute([
        $firstName,
        $lastName,
        $email,
        $username,
        password_hash($password, PASSWORD_DEFAULT)
    ]);

    // Optionally set session here if logging them in immediately
    $_SESSION['fname'] = $firstName;
    $_SESSION['lname'] = $lastName;

    header("Location: landing.php");
} else {
    echo "All fields are required.";
}
?>
