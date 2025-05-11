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
    echo "<td>{$t['transaction_id']}</td>";
    echo "<td>{$t['product_id']}</td>";
    echo "<td>{$t['order_agent']}</td>";
    echo "<td>{$t['quantity']}</td>";
    echo "<td>{$t['transaction_type']}</td>";
    echo "<td>{$t['transaction_date']}</td>";
    echo "<td>{$t['supplier_name']}</td>";
    echo "</tr>";
}
echo "</table>";
?>
