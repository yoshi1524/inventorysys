<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM inventory");
$inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<table border="1">
    <tr>
        <th>Inventory ID</th>
        <th>Product ID</th>
        <th>Quantity</th>
        <th>Transaction ID</th>
        <th>Date Created </th>
        <th>Date Updated</th>
        <th>Updated By</th>



    </tr>
    <?php foreach ($inventory as $inv): ?>
        <tr>
            <td><?= $inv['inventory_id'] ?></td>
            <td><?= $inv['product_id'] ?></td>
            <td><?= $inv['quantity'] ?></td>
            <td><?= $inv['transaction_id'] ?></td>
            <td><?= $inv['created_at'] ?></td>
            <td><?= $inv['updated_at'] ?></td>
            <td><?= $inv['updated_by'] ?></td>
      </tr>
    <?php endforeach; ?>
</table>
</body>
</html>

