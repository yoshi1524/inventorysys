<?php
require 'db.php'; 
function logUserAction($pdo, $username, $action) {
    $stmt = $pdo->prepare("INSERT INTO user_logs (username, action) VALUES (?, ?)");
    $stmt->execute([$username, $action]);
}
// After successful login
$username = $_SESSION['username']; // Assuming username is stored in the session
logUserAction($pdo, $username, "Logged in");

// After deleting a record
$username = $_SESSION['username'];
logUserAction($pdo, $username, "Deleted order ID 456");

// After updating a record  
$username = $_SESSION['username'];
logUserAction($pdo, $username, "Updated order ID 123");

$stmt = $pdo->query("SELECT username, action, timestamp FROM user_logs ORDER BY timestamp DESC");
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);


$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$stmt = $pdo->prepare("SELECT username, action, timestamp FROM user_logs ORDER BY timestamp DESC LIMIT ? OFFSET ?");
$stmt->execute([$limit, $offset]);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);