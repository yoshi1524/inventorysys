<?php
require 'db.php';

// Fetch sales and expenses data from the database
$stmt = $pdo->query("SELECT category_id, quantity_ordered, total_price FROM orders ORDER BY order_date ASC");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for Google Charts
$chartData = [['category_id', 'quantity_ordered', 'total_price']]; // Add column headers
foreach ($data as $row) {
    $chartData[] = [$row['category_id'], (int)$row['quantity_ordered'], (int)$row['total_price']];
}

// Return data as JSON
echo json_encode($chartData);
?>