<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;

    $product_ids = $_POST['product_id'] ?? [];
    $quantities = $_POST['quantity'] ?? [];
    $category_ids = $_POST['category_id'] ?? [];
    $supplier_ids = $_POST['supplier_id'] ?? [];

    if (!$user_id) {
        echo "User not logged in.";
        exit;
    }

    $pdo->beginTransaction();

    try {
        for ($i = 0; $i < count($product_ids); $i++) {
            $product_id = $product_ids[$i];
            $quantity = $quantities[$i];
            $category_id = $category_ids[$i];
            $supplier_id = $supplier_ids[$i];

            // Get product price
            $stmt = $pdo->prepare("SELECT unit_price FROM product WHERE product_id = :product_id");
            $stmt->execute([':product_id' => $product_id]);
            $product = $stmt->fetch();

            if (!$product) {
                throw new Exception("Product not found for ID: $product_id");
            }

            $total_price = $product['unit_price'] * $quantity;
            $order_status = 'pending';

            // Insert into orders
            $sql = "INSERT INTO orders (
                product_id, category_id, supplier_id,
                quantity_ordered, total_price, order_status, order_date
            ) VALUES (
                :product_id, :category_id, :supplier_id,
                :quantity_ordered, :total_price, :order_status, NOW()
            )";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':product_id' => $product_id,
                ':category_id' => $category_id,
                ':supplier_id' => $supplier_id,
                ':quantity_ordered' => $quantity,
                ':total_price' => $total_price,
                ':order_status' => $order_status
            ]);

            // Insert into transactions
            $transaction_sql = "INSERT INTO transactions 
                (product_id, supplier_id, quantity, transaction_type, transaction_date, order_agent) 
                VALUES 
                (:product_id, :supplier_id, :quantity, :transaction_type, NOW(), :order_agent)";

            $transaction_stmt = $pdo->prepare($transaction_sql);
            $transaction_stmt->execute([
                ':product_id' => $product_id,
                ':supplier_id' => $supplier_id,
                ':quantity' => $quantity,
                ':transaction_type' => 'order',
                ':order_agent' => $user_id
            ]);
        }

        $pdo->commit();
        header("Location: mandash.php?order=added");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    /* General Page Styling */
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5; /* Light gray background */
        color: #333; /* Dark text color */
        margin: 0;
        padding: 0;
    }

    h1 {
        text-align: center;
        color: #6a0dad; /* Purple color */
        margin-top: 20px;
    }

    form {
        max-width: 800px;
        margin: 20px auto;
        background-color: #fff; /* White background */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #6a0dad; /* Purple color */
    }

    input, select, button {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }

    input:focus, select:focus {
        border-color: #6a0dad; /* Purple border on focus */
        outline: none;
    }

    button {
        background-color: #6a0dad; /* Purple button */
        color: #fff; /* White text */
        border: none;
        cursor: pointer;
        font-weight: bold;
    }

    button:hover {
        background-color: #5a0cb0; /* Darker purple on hover */
    }

    .removeItemBtn {
        background-color: #ff4d4d; /* Red button for remove */
        color: #fff;
        border: none;
        cursor: pointer;
        font-weight: bold;
    }

    .removeItemBtn:hover {
        background-color: #e60000; /* Darker red on hover */
    }

    #addItemBtn {
        background-color: #6a0dad; /* Purple button */
        color: #fff;
        border: none;
        cursor: pointer;
        font-weight: bold;
    }

    #addItemBtn:hover {
        background-color: #5a0cb0; /* Darker purple on hover */
    }

    a {
        display: inline-block;
        margin-top: 15px;
        text-decoration: none;
        color: #6a0dad; /* Purple link */
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }

    .item-entry {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 4px;
        background-color: #f9f9f9; /* Light background for item entries */
    }
</style>
</head>
<body>
    
<h1>ADD ORDERS</h1>
                <form id="multiItemForm" method="POST" >
                    <div id="itemContainer">
                        <div class="item-entry">
                        <select name="product_id[]" required>
                        <option value="">Select Product</option>
                        <?php
                        $stmt = $pdo->query("SELECT product_id, product_name FROM product");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value=\"" . htmlspecialchars($row['product_id']) . "\">" . htmlspecialchars($row['product_name']) . "</option>";
                        }
                        ?>
                        </select><br>

                        <input type="number" name="quantity[]" placeholder="Quantity" required><br>

                        <select name="category_id[]" required>
                        <option value="">Select Category</option>
                        <?php
                        $stmt = $pdo->query("SELECT category_id, category_name FROM product_categories");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                            echo "<option value=\"" . htmlspecialchars($row['category_id']) . "\">" . htmlspecialchars($row['category_name']) . "</option>";
                        }
                        ?>
                        </select><br>
                        

                        <!-- Supplier Dropdown -->
                        <select name="supplier_id[]" required>
                        <option value="">Select Supplier</option>
                        <?php
                        $stmt = $pdo->query("SELECT supplier_id, supplier_name FROM supplier");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . htmlspecialchars($row['supplier_id']) . '">' . htmlspecialchars($row['supplier_name']) . '</option>';
                        }
                        ?>
                        </select>
                        <br>
                            <!--<input type="number" name="quantity_ordered[]" placeholder="Quantity" required><br>-->
                            <input type="number" name="total_price[]" placeholder="Total price" required><br>
                            <input type="dropdown" name="order_status" placeholder="Order Status" required><br>
                            <button type="button" class="removeItemBtn">Remove</button><br>
                        </div>
                    </div>
						<button type="button" id="addItemBtn">Add Another Item</button>
						<br><br>
						<button type="submit">Submit All Items</button><br>
                        <a href="mandash.php">Back to Dashboard</a>
                </form>

</body>
</html>