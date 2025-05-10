<?php
session_start();
require_once 'db.php'; // This must define $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = trim($_POST['product_name']);
    $unit_price = $_POST['unit_price'];
    $quantity = $_POST['quantity'];

    if (!empty($product_name) && is_numeric($unit_price) && is_numeric($quantity)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO product (product_name, unit_price, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$product_name, $unit_price, $quantity]);

            echo "<script>alert(" . json_encode('Item added successfully.') . "); window.location.href = 'mandash.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert(" . json_encode('Database error: ' . $e->getMessage()) . "); window.history.back();</script>";
        }
    } else {
        echo "<script>alert(" . json_encode('Invalid input. Please check the form.') . "); window.history.back();</script>";
    }
}
?>
