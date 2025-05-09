<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_level_id'] !== 1) {
    header("Location: login.php");
    var_dump($user);
    exit();
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
    </style>
</head>
<body>
<div class="sidebar">
<p>Logged in as: 
  <strong>
    <?= isset($_SESSION['fname']) && isset($_SESSION['lname']) 
        ? htmlspecialchars($_SESSION['fname'] . ' ' . $_SESSION['lname']) 
        : '' ?>
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
