<?php
require 'db.php';

$sql = "SELECT id, message, created_at FROM notifications WHERE is_read = 0 ORDER BY created_at DESC LIMIT 10";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$notifs = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($notifs);
?>
