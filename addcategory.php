<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        echo "<script>alert('User not logged in.'); window.history.back();</script>";
        exit;
    }

    $categoryName = trim($_POST['category_name']);

    if (!empty($categoryName)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO `product_categories` (`category_name`, `created_at`) VALUES (?, NOW())");
            $stmt->execute([$categoryName]);
            // Redirect to another page after successful submission
            header("Location: mandash.php?status=success");
            exit;
        } catch (PDOException $e) {
            error_log("DB error: " . $e->getMessage());
            echo "<script>alert('Error adding category. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Category name cannot be empty.'); window.history.back();</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>ADD CATEGORIES</h1>
<form method="POST" action="">
    <label for="category_name">Category Name:</label>
    <input type="text" id="category_name" name="category_name" required>
    <button type="submit">Add Category</button><br><br>
    <a href="mandash.php">Back to Dashboard</a>
</form>
</body>
</html>
