<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_level_id = $_POST['user_level_id'];

    if ($fname && $lname && $username && $email && $user_level_id) {
        $stmt = $pdo->prepare("INSERT INTO users (fname, lname, username, email, password, user_level_id, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$fname, $lname, $username, $email, $password, $user_level_id]);
        $message = "User created successfully!";
    } else {
        $message = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User - iNVAX</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #14532d; /* Dark green */
            color: #fff;
            height: 100vh;
            padding: 20px;
        }
        .sidebar h2 {
            margin-bottom: 20px;
        }
        .sidebar a {
            color: #d1fae5;
            display: block;
            margin: 10px 0;
            text-decoration: none;
        }
        .content {
            flex: 1;
            padding: 40px;
            background-color: #f4f4f4;
        }
        h1 {
            margin-bottom: 20px;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }
        label {
            display: block;
            margin-top: 15px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #14532d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .message {
            margin-top: 20px;
            color: green;
        }
    </style>
</head>
<body>
<div class="sidebar">
<p>Logged in as: 
  <strong>
    <?= isset($_SESSION['fname']) && isset($_SESSION['lname']) 
        ? htmlspecialchars($_SESSION['fname'] . ' ' . $_SESSION['lname']) 
        : 'Unknown' ?>
  </strong> (Superadmin)
</p>
    <a href="supad.php">Dashboard</a>
    <a href="logout.php">Logout</a>
</div>
<div class="content">
    <h1>Create New User</h1>
    <form method="POST">
    <input type="text" name="fname" placeholder="First Name" required>
    <input type="text" name="lname" placeholder="Last Name" required>
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <select name="user_level_id" required>
        <option value="4">Superadmin</option>
        <option value="3">Manager</option>
        <option value="2">Crew</option>
    </select>
    <button type="submit">Create User</button>
    <?php if (isset($message)): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
</form>
</div>
</body>
</html>
