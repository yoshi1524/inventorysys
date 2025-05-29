<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = $_POST['category_id']?? null;

    if (!empty($categoryId)) {
        try {
            $stmt = $pdo->prepare("DELETE FROM product_categories WHERE category_id = ?");
            $stmt->execute([$categoryId]);
            header("Location: editcat.php?status=deleted");
            exit;
        } catch (PDOException $e) {
            error_log("DB error: " . $e->getMessage());
            echo "<script>alert('Error deleting category. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Invalid category ID.'); window.history.back();</script>";
    }
}
?>