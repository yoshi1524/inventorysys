<?php
session_start();
if (!isset($_SESSION['user_level']) || ($_SESSION['user_level'] !== 'manager' && $_SESSION['user_level'] !== 'owner')) {
    die("Access denied. Managers and owners only.");
}
?>
<h1>Manager Dashboard</h1>
