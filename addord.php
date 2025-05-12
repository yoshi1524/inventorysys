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

    for ($i = 0; $i < count($product_ids); $i++) {
        $product_id = $product_ids[$i];
        $quantity = $quantities[$i];
        $category = $categories[$i];

        // Fetch product details from DB
        $stmt = $pdo->prepare("SELECT product_name, unit_price FROM product WHERE product_id = :product_id");
        $stmt->execute([':product_id' => $product_id]);
        $product = $stmt->fetch();

        if (!$product) {
            echo "Product not found for ID: $product_id";
            continue;
        }

        $total_price = $product['unit_price'] * $quantity;
        $order_status = 'pending';

        $sql = "INSERT INTO orders (
            product_name,
            category,
            supplier_name,
            quantity_ordered,
            total_price,
            order_status,
            order_date
        ) VALUES (
            :product_name,
            :category,
            :supplier_name,
            :quantity_ordered,
            :total_price,
            :order_status,
            NOW()
        )";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':product_name' => $product['product_name'],
    ':category' => $category,
    ':supplier_name' => $product['supplier_name'],
    ':quantity_ordered' => $quantity,
    ':total_price' => $total_price,
    ':order_status' => $order_status
]);
$transaction_sql = "INSERT INTO transactions 
    (product_id, supplier_name, quantity, transaction_type, transaction_date, order_agent) 
    VALUES 
    (:product_id, :supplier_name, :quantity, :transaction_type, NOW(), :order_agent)";

$transaction_stmt = $pdo->prepare($transaction_sql);
$transaction_stmt->execute([
    ':product_id' => $product_id,
    ':supplier_name' => $product['supplier_name'],
    ':quantity' => $quantity,
    ':transaction_type' => 'order', // or 'purchase' or whatever term fits
    ':order_agent' => $user_id // or the username if available
]);

    }
    $pdo->beginTransaction();
try {
    // Insert into orders
    // Insert into transactions
    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}


    header("Location: mandash.php?order=added");
    exit;
}
?>


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

                        <input type="number" name="quantity[]" placeholder="Quantity" required>

                        <select name="category_id[]" required>
                        <option value="">Select Category</option>
                        <?php
                        $stmt = $pdo->query("SELECT category_id, category_name FROM product_categories");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                            echo "<option value=\"" . htmlspecialchars($row['category_id']) . "\">" . htmlspecialchars($row['category_name']) . "</option>";
                        }
                        ?>
                        </select><br>
                        <br>

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
                            <input type="text" name="order_status" placeholder="Order Status" required><br>
                            <button type="button" class="removeItemBtn">Remove</button><br>
                        </div>
                    </div>
						<button type="button" id="addItemBtn">Add Another Item</button>
						<br><br>
						<button type="submit">Submit All Items</button>
                </form>
