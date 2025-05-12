<?php
require 'db.php'; // contains $pdo setup

$sql = "
SELECT 
    t.transaction_id,
    t.product_id,
    t.order_agent,
    t.quantity,
    t.transaction_type,
    t.transaction_date,
    s.supplier_name
FROM 
    transactions t
JOIN 
    supplier s ON t.supplier_name = s.supplier_id
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<table>";
echo "<tr><th>ID</th><th>Product</th><th>Agent</th><th>Qty</th><th>Type</th><th>Date</th><th>Supplier</th></tr>";

foreach ($transactions as $t) {
    echo "<tr>";
    echo "<td>{$order['order_id']}</td>";
    echo "<td>{$order['product_name']}</td>";
    echo "<td>{$order['quantity_ordered']}</td>";
    echo "<td>{$order['total_price']}</td>";
    echo "<td>{$order['order_status']}</td>";
    echo "<td><button class='viewOrderBtn' 
                  data-order-id='{$order['order_id']}'
                  data-product-name='{$order['product_name']}'
                  data-quantity='{$order['quantity_ordered']}'
                  data-total='{$order['total_price']}'
                  data-status='{$order['order_status']}'>
                  View
          </button></td>";
}
echo "</table>";
?>
