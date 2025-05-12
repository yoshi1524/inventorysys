<?php
require 'db.php';

// Fetch reports from the database
$stmt = $pdo->query("SELECT * FROM reports");
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1">
    <tr>
        <th>Report ID</th>
        <th>Title</th>
        <th>Content</th>
        <th>Created At</th>
    </tr>
    <?php foreach ($reports as $report): ?>
        <tr>
            <td><?= htmlspecialchars($report['report_id']) ?></td>
            <td><?= htmlspecialchars($report['title']) ?></td>
            <td><?= htmlspecialchars($report['content']) ?></td>
            <td><?= htmlspecialchars($report['created_at']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>