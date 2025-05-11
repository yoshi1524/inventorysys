<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $names = $_POST['product_name'];
    $prices = $_POST['unit_price'];
    $quantities = $_POST['quantity'];
    $categories = trim('category')[$i];

    $successCount = 0;
    $errorCount = 0;

    for ($i = 0; $i < count($names); $i++) {
        $name = trim($names[$i]);
        $price = $prices[$i];
        $qty = $quantities[$i];
        $category = trim($categories[$i]);

        if (!empty($name) && is_numeric($price) && is_numeric($qty)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO product (category, product_name, unit_price, quantity) VALUES (?, ?, ?, ?)");
                $stmt->execute([$categories, $name, $price, $qty]);
                $successCount++;
            } catch (PDOException $e) {
                $errorCount++;
            }
        } else {
            $errorCount++;
        }
    }

    echo "<script>alert('Added $successCount items. $errorCount errors.'); window.history.back();</script>";
}
?>

