<?php
include 'db.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if($result) {
    echo "UU";
}else {
    echo"failed" .$conn->error;
}

$conn->close();
?>