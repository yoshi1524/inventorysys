<?php
session_start();
require_once 'db.php'; // Assumes $pdo is available

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and validate the order_id from POST
    $order_id = isset($_POST['order_id']) && is_numeric($_POST['order_id']) ? (int)$_POST['order_id'] : null;

    // If no valid order_id provided, display message
    if (!$order_id) {
        echo "No valid order ID provided.";
        exit;
    }

    try {
        // Mark order as completed
        $update = $pdo->prepare("UPDATE orders SET order_status = 'Completed' WHERE order_id = ?");
        $update->execute([$order_id]);

        // Success message
        echo "<script>
                alert('Order has been marked as completed.');
                window.location.href='owndash.php';
              </script>";
        exit;
    } catch (Exception $e) {
        // Log the error
        error_log("Error: " . $e->getMessage());

        // Display error with JavaScript alert
        echo "<script>
                alert('Error: " . $e->getMessage() . "');
                window.history.back();
              </script>";
    }
}
?>