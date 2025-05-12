<?php
include 'db.php'; // make sure this connects to your DB properly

if (isset($_POST['query'])) {
    $search = trim($_POST['query']);

    if ($search === '') {
        echo '<p>Please enter a search term.</p>';
        exit;
    }

    // Adjust table and field names as needed
    $stmt = $pdo->prepare("SELECT  fname  FROM users WHERE fname LIKE ?");
    $stmt->execute(["%$search%"]);

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        echo '<ul style="list-style:none; padding:0;">';
        foreach ($users as $user) {
            echo '<li style="margin-bottom:10px; border-bottom:1px solid #ccc; padding:5px 0;">';
            echo '<strong>' . htmlspecialchars($user['fname']) . '</strong><br>';
            //echo 'Username: ' . htmlspecialchars($user['username']) . '<br>';
            //echo 'Email: ' . htmlspecialchars($user['email']);
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No users found.</p>';
    }
} else {
    echo '<p>Invalid request.</p>';
}
?>
