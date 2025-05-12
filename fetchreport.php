<?php
require 'db.php';

// Get the report_id from the URL
$report_id = isset($_GET['report_id']) ? (int)$_GET['report_id'] : null;

// Debugging: Check if report_id is being passed correctly
if ($report_id === null) {
    
    echo "<li class='log-list'>Please provide a valid report ID.</li>";
    exit;
}

try {
    // Use the correct column name (e.g., id or report_id)
    $stmt = $pdo->prepare("SELECT title, content FROM reports WHERE report_id = ?");
    $stmt->execute([$report_id]);
    $report = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($report) {
        echo "<li class='log-list'><strong>{$report['title']}</strong></li>";
        echo "<li class='log-list'>{$report['content']}</li>";
    } else {
        echo "<li class='log-list'>Report not found.</li>";
    }
} catch (PDOException $e) {
    echo "<li class='log-list'>Error fetching report: " . htmlspecialchars($e->getMessage()) . "</li>";
}
?>