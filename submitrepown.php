<?php
require 'db.php'; // sets up $pdo
session_start();

// Make sure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id']; // get from session
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title && $content) {
        // Insert the report
        $sql = "INSERT INTO reports (user_id, title, content) 
                VALUES (:user_id, :title, :content)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':title' => $title,
            ':content' => $content
        ]);

        // Fetch user's full name (adjust column name if needed)
        $user_sql = "SELECT fname FROM users WHERE user_id = :user_id";
        $user_stmt = $pdo->prepare($user_sql);
        $user_stmt->execute([':user_id' => $user_id]);
        $user = $user_stmt->fetch();

        $username = $user ? $user['fname'] : 'Unknown User';

        // Insert notification with name
        $notif_sql = "INSERT INTO notifications (user_id, message) VALUES (:user_id, :message)";
        $notif_stmt = $pdo->prepare($notif_sql);
        $notif_stmt->execute([
            ':user_id' => $user_id,
            ':message' => $username . ' submitted a report.'
        ]);

        header("Location: owndash.php?report=submitted");
        exit;
    } else {
        echo "Please fill in all fields.";
    }
}
?>
