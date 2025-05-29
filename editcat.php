<?php
require 'db.php';

// Handle adding a new category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $categoryName = trim($_POST['new_category_name']);

    if (!empty($categoryName)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO product_categories (category_name, created_at) VALUES (?, NOW())");
            $stmt->execute([$categoryName]);
            header("Location: editcat.php?status=added");
            exit;
        } catch (PDOException $e) {
            error_log("DB error: " . $e->getMessage());
            echo "<script>alert('Error adding category. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Category name cannot be empty.'); window.history.back();</script>";
    }
}

// Handle editing an existing category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_category'])) {
    $categoryId = $_POST['category_id'];
    $categoryName = trim($_POST['category_name']);

    if (!empty($categoryId) && !empty($categoryName)) {
        try {
            $stmt = $pdo->prepare("UPDATE product_categories SET category_name = ? WHERE category_id = ?");
            $stmt->execute([$categoryName, $categoryId]);
            header("Location: editcat.php?status=updated");
            exit;
        } catch (PDOException $e) {
            error_log("DB error: " . $e->getMessage());
            echo "<script>alert('Error updating category. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Category name cannot be empty.'); window.history.back();</script>";
    }
}

// Fetch all categories
$stmt = $pdo->query("SELECT * FROM product_categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- Add Category Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
        }
    </style>
</head>
<body>
    
<div id="addCategorySection">
    <h2>Manage and Add Categories</h2>
    <a href="mandash.php">Back to Dashboard</a>
    <form method="POST" action="editcat.php">
        <input type="hidden" name="add_category" value="1">
        <input type="text" id="newCategoryName" name="new_category_name" placeholder="Enter Category Name to Add" required>
        <button type="submit" style="margin-top: 15px; padding: 8px 16px; background-color: Indigo; color: white; border: none; border-radius: 4px; cursor: pointer;">Add Category</button>
    </form>
</div>
<hr>
<!-- Edit Category Modal -->
<div id="editCategoryModal" class="modal">
    <div class="modal-content">
    <span class="close" id="closeEditCategoryModal">&times;</span>
        <form method="POST" action="editcat.php">
            <input type="hidden" name="edit_category" value="1">
            <input type="hidden" id="editCategoryId" name="category_id">
            <input type="text" id="editCategoryName" name="category_name" placeholder="Edit Category Name" required>
            <button type="submit" style="margin-top: 15px; padding: 8px 16px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">Save Changes</button>
        </form>
    </div>
</div>

<!-- Categories Table -->
<table border="1">
    <tr>
        <th>Category ID</th>
        <th>Category Name</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($categories as $cat): ?>
        <tr>
            <td><?= $cat['category_id'] ?></td>
            <td><?= htmlspecialchars($cat['category_name']) ?></td>
            <td><?= $cat['created_at'] ?></td>
            <td>
                <!-- Edit Button -->
                <button class="editCategoryBtn" data-id="<?= $cat['category_id'] ?>" data-name="<?= htmlspecialchars($cat['category_name']) ?>">Edit</button>
                
                <!-- Remove Button -->
                <form method="POST" action="delcat.php" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">
                    <input type="hidden" name="category_id" value="<?= $cat['category_id'] ?>">
                    <button type="submit" style="color: red;">Remove</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<script>
    // Handle Edit Category Button Click
document.querySelectorAll(".editCategoryBtn").forEach(button => {
    button.addEventListener("click", function () {
        const categoryId = this.getAttribute("data-id");
        const categoryName = this.getAttribute("data-name");

        document.getElementById("editCategoryId").value = categoryId;
        document.getElementById("editCategoryName").value = categoryName;

        document.getElementById("editCategoryModal").style.display = "block";
    });
});

// Close the Edit Category Modal
document.getElementById("closeEditCategoryModal").onclick = function () {
    document.getElementById("editCategoryModal").style.display = "none";
};

// Optional: Close modal when clicking outside the modal content
window.onclick = function (event) {
    const modal = document.getElementById("editCategoryModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
};
</script>
</body>
</html>