<?php
session_start();
require 'db.php';

$user_id = $_POST['user_id'] ?? null;
if ($user_id) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
}

header("Location: supad.php");
exit();
?>
