<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $names = $_POST['product_name'];
    $prices = $_POST['unit_price'];
    $quantities = $_POST['quantity'];
    $categories = $_POST['category_id']; // Assuming it's also an array

    $successCount = 0;
    $errorCount = 0;

    for ($i = 0; $i < count($names); $i++) {
        $name = trim($names[$i]);
        $price = $prices[$i];
        $qty = $quantities[$i];
        $category_id = $categories[$i];

        if (!empty($name) && is_numeric($price) && is_numeric($qty) && is_numeric($category_id)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO product (category_id, product_name, unit_price, quantity) VALUES (?, ?, ?, ?)");
                $stmt->execute([$category_id, $name, $price, $qty]);
                $successCount++;
            } catch (PDOException $e) {
                $errorCount++;
                error_log("DB error at index $i: " . $e->getMessage());
            }
        } else {
            $errorCount++;
            error_log("Invalid input at index $i: name=$name, price=$price, qty=$qty, category_id=$category_id");
        }
    }

    echo "<script>alert('Added $successCount items. $errorCount errors.'); window.history.back();</script>";
}
?>
