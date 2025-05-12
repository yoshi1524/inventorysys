<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM orders");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1">
    <tr>
        <th>Order ID</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Status</th>
    </tr>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order['order_id'] ?></td>
            <td><?= $order['product_id'] ?></td>
            <td><?= $order['quantity_ordered'] ?></td>
            <td id="status-<?= $order['order_id'] ?>"><?= $order['order_status'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
