<?php
require 'db.php';

try {
    // Update all notifications to mark them as read
    $stmt = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE is_read = 0");
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>