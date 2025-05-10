<?php
require 'db.php';

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if ($username && $password) {
    $stmt = $pdo->prepare("INSERT INTO users (username, password, user_level_id) VALUES (?, ?, '1')");
    $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
    header("Location: landing.php");
} else {
    echo "All fields are required.";
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
