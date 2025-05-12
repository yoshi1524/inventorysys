<?php
$host = "localhost";       // or the IP address of your MySQL server
$user = "root";            // default XAMPP username
$password = "";            // default XAMPP password (usually empty)
$database = "tcinv1";      // your database name

// Create a new MySQL connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Inventory data
$inventory = $conn->query("SELECT * FROM inventory");

// Stats
$totalItems = $conn->query("SELECT COUNT(*) AS count FROM inventory")->fetch_assoc()['count'];
$lowStock = $conn->query("SELECT COUNT(*) AS count FROM inventory WHERE status = 'Low'")->fetch_assoc()['count'];
$outOfStock = $conn->query("SELECT COUNT(*) AS count FROM inventory WHERE status = 'Out of Stock'")->fetch_assoc()['count'];
$pendingRequests = $conn->query("SELECT COUNT(*) AS count FROM requests WHERE status = 'Pending'")->fetch_assoc()['count'];
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
        <li><a href="crewdashboard.php">Dashboard</a></li>
        <li><a href="crewview.php">Crew View</a></li>
        <li><a href="report.html">Report</a></li>
      </ul>
    </nav>
  </aside>

  <div class="main">
    <div class="cards">
      <div class="card card-small"><h3>Total Items</h3><p><?php echo $totalItems; ?></p></div>
      <div class="card card-small"><h3>Low Stock</h3><p><?php echo $lowStock; ?></p></div>
      <div class="card card-small"><h3>Out of Stock</h3><p><?php echo $outOfStock; ?></p></div>
      <div class="card card-small"><h3>Pending Requests</h3><p><?php echo $pendingRequests; ?></p></div>
    </div>

    <div class="card">
      <h2>Live Inventory</h2>
      <table>
        <thead>
          <tr>
            <th>Item Name</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $inventory->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['item_name']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td class="<?php
              if ($row['status'] == 'OK') echo 'status-ok';
              elseif ($row['status'] == 'Low') echo 'status-low';
              else echo 'status-out';
            ?>"><?php echo $row['status']; ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>