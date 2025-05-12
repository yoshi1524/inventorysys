<?php
session_start();
require_once 'db.php'; // Assumes $pdo is available

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debugging: Check the POST data
    
    // Get and validate the order_id from POST
    $order_id = isset($_POST['order_id']) && is_numeric($_POST['order_id']) ? (int)$_POST['order_id'] : null;

    // If no valid order_id provided, display message
    if (!$order_id) {
        echo "No valid order ID provided.";
        exit;
    }

    try {
        $pdo->beginTransaction();

        // Get order details from the orders table
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = ?");
        $stmt->execute([$order_id]);
        $order = $stmt->fetch();

        // If no order found
        if (!$order) {
            throw new Exception("Order not found.");
        }

        // Mark order as completed
        $update = $pdo->prepare("UPDATE orders SET order_status = 'Completed' WHERE order_id = ?");
        $update->execute([$order_id]);

        // Get product_id from the product table based on product_name
        $productCheck = $pdo->prepare("SELECT * FROM product WHERE product_id = ?");
        $productCheck->execute([$order['product_id']]);
        if (!$productCheck->fetch()) {
            throw new Exception("Product not found in product table.");
        }
        $product_id = $order['product_id'];

        // Check if product exists in inventory
        $check = $pdo->prepare("SELECT * FROM inventory WHERE product_id = ?");
        $check->execute([$order['product_id']]);
        $inventory = $check->fetch();

        if ($inventory) {
            // Update inventory if product exists
            $newQty = $inventory['quantity'] + $order['quantity_ordered'];
            $updateInv = $pdo->prepare("UPDATE inventory SET quantity = ?, last_updated = NOW() WHERE product_id = ?");
            $updateInv->execute([$newQty, $order['product_id']]);
        } else {
            // Insert into inventory if product doesn't exist
            $insertInv = $pdo->prepare("INSERT INTO inventory (product_id, quantity, updated_at) VALUES (?, ?, NOW())");
            $insertInv->execute([$order['product_id'], $order['quantity_ordered']]);
        }

        // Log the inventory transaction
        $transaction = $pdo->prepare("
            INSERT INTO transactions (product_id, order_agent, , quantity, transaction_type, transaction_date, supplier_id)
            VALUES (?, ?, ?, ?, NOW(), ?)
        ");
        $transaction->execute([
            $product_id,                  // Now using product_id fetched from the product table
            $order['supplier_id'],       // Can also be supplier_id
            $order['quantity_ordered'],
            'inventory_update',
            $_SESSION['user_id'] ?? null   // Assumes user_id is in session
        ]);

       
        // Commit the transaction if everything is successful
        $pdo->commit();

        // Redirect with success message
        echo "<script>
                alert('Order completed and inventory updated.');
                window.location.href='mandash.php';
              </script>";
        exit;
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $pdo->rollBack();

        // Display error with JavaScript alert
        echo "<script>
                alert('Error: " . $e->getMessage() . "');
                window.history.back();
              </script>";
    }
}
?>
