<?php
session_start();

// Check if logged in and user is owner
if (!isset($_SESSION['user_level']) || $_SESSION['user_level'] !== 'owner') {
    die("Access denied. Owners only.");
}
?>
<h1>Owner Dashboard</h1>
