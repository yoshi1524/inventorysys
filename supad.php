<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Get the user from DB
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify user exists and password matches
    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_level_id'] = $user['user_level_id'];
        $_SESSION['fname'] = $user['first_name'];
        $_SESSION['lname'] = $user['last_name'];

        // Check user level and redirect
        if ($user['user_level_id'] == 1) {
            header('Location: supad.php');
        } elseif ($user['user_level_id'] == 2) {
            header('Location: owndash.php');
        }elseif($user['user_level_id'] == 3) {
            header('Location: mandash.php');
        } elseif ($user['user_level_id'] == 4) {
            header('Location: crewdashboard.php');
        } else
        exit();
    } else {
        // Invalid credentials
        echo "<script>alert('Incorrect username or password.'); window.location.href = 'landing.php';</script>";
        exit();
    }
}

// Fetch user logs
$logs = $pdo->query("SELECT * FROM user_logs ORDER BY timestamp DESC")->fetchAll(PDO::FETCH_ASSOC);
// Fetch all users
$users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Superadmin Dashboard - iNVAX</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #fff;
            height: 100vh;
            padding: 20px;
        }
        .sidebar h2 {
            margin-bottom: 20px;
        }
        .sidebar a {
            color: #ecf0f1;
            display: block;
            margin: 10px 0;
            text-decoration: none;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .sidebar img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 50%;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        .sidebar h3 {
        color: white;
        margin-top: 10px;
        font-size: 18px;
        }
    </style>
</head>
<body>
<div class="sidebar">
        <!-- Logo & Branding -->
        <div style="text-align: center; padding: 1rem;">
        <img src="assets/bgmc-modified.png" alt="Logo">
        <h3 style="color: white; margin-top: 10px; font-size: 18px;">Superadmin Dashboard</h3>
    </div>
<p>Welcome: 
<strong>
    <?= isset($_SESSION['username']) 
        ? htmlspecialchars($_SESSION['username']) 
        : 'Unknown' ?>
  </strong> (Superadmin)
</p>
    <a href="#logs">User Logs</a>
    <a href="adduse.php">Manage Users</a>
    <a href="logout.php">Logout</a>
</div>
<div class="content">
    <h1 id="logs">User Activity Logs</h1>
    <table>
        <tr>
            <th>User</th>
            <th>Action</th>
            <th>Date/Time</th>
        </tr>
        <?php foreach ($logs as $log): ?>
        <tr>
            <td><?= htmlspecialchars($log['username']) ?></td>
            <td><?= htmlspecialchars($log['action']) ?></td>
            <td><?= htmlspecialchars($log['timestamp']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h1 id="users">Registered Users</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>User Level</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['user_id'] ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['user_level_id']) ?></td>
            <td><?= htmlspecialchars($user['created_at']) ?></td>
            <td>
                <form action="deluser.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
