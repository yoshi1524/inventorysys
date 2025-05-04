<?php
require 'db.php';

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if ($username && $password) {
    $stmt = $pdo->prepare("INSERT INTO users (username, password, user_level_id) VALUES (?, ?, 4)");
    $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
    header("Location: landing.php");
} else {
    echo "All fields are required.";
}
?>
