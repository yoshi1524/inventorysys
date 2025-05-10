<?php
include 'db.php';  // Include your DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['id'];
    $productName = $_POST['product_name'];
    $unitPrice = $_POST['unit_price'];
    $quantity = $_POST['quantity'];

    $stmt = $pdo->prepare("UPDATE product SET product_name = ?, unit_price = ?, quantity = ? WHERE product_id = ?");
    $stmt->execute([$productName, $unitPrice, $quantity, $productId]);

    echo json_encode(['success' => true]);
}
?>
