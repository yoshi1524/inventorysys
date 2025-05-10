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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crew Dashboard</title>
  <link rel="stylesheet" href="crewdash.css">
</head>
<body>

  <header>
    <h1>Crew Dashboard</h1>
  </header>

  <div class="container">
    <aside class="sidebar">
      <nav>
        <ul>
         
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Crew View</a></li>
            <li><a href="#">Report</a></li>
        </ul>
        </ul>
      </nav>
    </aside>
    <div class="crew-view" id="crewView">
      <h2>Crew Member Details</h2>
    <main class="main-content">
      <h2>Crew Members</h2>
      <div class="crew-list">
        <div class="crew-card">
          <h3>John allen</h3>
          <p>Crew staff</p>
          <p>Experience: 10 years</p>
          <button class="view-btn">View Profile</button>
        </div>
        <div class="crew-card">
          <h3>RM santos</h3>
          <p>manager</p>
          <p>Experience: 5 years</p>
          <button class="view-btn">View Profile</button>
        </div>
        <div class="crew-card">
          <h3>Johnric</h3>
          <p>Crew staff</p>
          <p>Experience: 7 years</p>
          <button class="view-btn">View Profile</button>
        </div>
        <div class="crew-card">
            <h3>Nel Crimson</h3>
            <p>Onwer</p>
            <p>Experience: 7 years</p>
            <button class="view-btn">View Profile</button>
          </div>
      </div>
    </main>
  </div>

</body>
</html>