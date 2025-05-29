<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM product_categories");
$category = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
        <th>Category ID</th>
        <th>Category Name</th>
        <th>Date Created</th>

    </tr>
    <?php foreach ($category as $cat): ?>
        <tr>
            <td><?= $cat['category_id'] ?></td>
            <td><?= $cat['category_name'] ?></td>
            <td><?= $cat['created_at'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>


