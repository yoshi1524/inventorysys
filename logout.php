
<!-- logout.php -->
<?php
session_start();
session_destroy();
header("Location: landing.php");
exit();
?>