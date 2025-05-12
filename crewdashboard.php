<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Get the user from DB
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // Fetch product data
    $stmt = $pdo->query("SELECT product_name, quantity FROM product");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// Fetch total supplier count
	$supplierCount = 0;
	$suppliers = [];
	
	try {
		$stmt = $pdo->query("SELECT COUNT(*) as total FROM supplier");
		$row = $stmt->fetch();
		$supplierCount = $row ? $row['total'] : 0;
	
		// Fetch supplier list
		$stmt = $pdo->query("SELECT supplier_name, contact_person, phone FROM supplier");
		$suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo "Database error: " . $e->getMessage();
	}


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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="owndashbb.css">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


	<title>Crew Hub</title>
    <style>
        .box-content {
	max-height: 0;
	overflow: hidden;
	transition: max-height 0.3s ease, opacity 0.3s ease;
	opacity: 0;
	padding-left: 1rem;
}

.collapsible-box.active .box-content {
	max-height: 200px; /* Adjust as needed */
	opacity: 1;
}
.box-header {
	cursor: pointer;
	display: flex;
	align-items: center;
	justify-content: start;
	gap: 10px;
}
/* Modal Styles */
.modal {
  display: none; /* Hidden by default */
  position: fixed;
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto; /* Enable scroll if needed */
  background-color: rgba(0, 0, 0, 0.4); /* Black with opacity */
}

.modal-content {
  background-color: #fff;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Change the width as needed */
  max-width: 600px;
}

.close {
  color: #aaa;
  font-size: 28px;
  font-weight: bold;
  float: right;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
.notification {
  position: relative;
  cursor: pointer;
}

.notif-dropdown {
  display: none;
  position: absolute;
  top: 40px; /* Adjust to position below the bell */
  right: 0;
  background: white;
  border: 1px solid #ccc;
  width: 300px;
  max-height: 300px;
  overflow-y: auto;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  z-index: 999;
  padding: 10px;
  border-radius: 6px;
}

.notif-dropdown ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.notif-dropdown ul li {
  padding: 8px;
  border-bottom: 1px solid #eee;
}

.notif-dropdown ul li:last-child {
  border-bottom: none;
}

.modal {
  display: none; /* Hides the modal initially */
  position: fixed;
  z-index: 999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.4); /* Dim background */
}

.modal-content {
  background-color: white;
  margin: 10% auto;
  padding: 20px;
  width: 80%;
  border-radius: 8px;
  animation: slideDown 0.3s ease;
}

@keyframes slideDown {
  from {
    transform: translateY(-50px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

#notificationsList {
    list-style: none;
    padding: 0;
    margin: 0;
}

.notification-item {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    cursor: pointer;
}

.notification-item:hover {
    background-color: #f0f0f0;
}

.activity-log-listt {
    list-style: none;
    padding: 0;
    margin: 0;
}

.log-list {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}
</style>

</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span>Welcome 
<strong>
    <?= isset($_SESSION['username']) 
        ? htmlspecialchars($_SESSION['username']) 
        : 'Unknown' ?>
  </strong>
  </span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="#db">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="#curve_chart" id="sidebarStockLink">
					<i class='bx bxs-package' ></i>
					<span class="text">Stocks</span>
				</a>
			</li>
			<li>
				<a href="#"id="openReportModalBtn">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Generate Reports</span>
				</a>
			</li>
			<!-- Modal Structure for Report Submission -->
			<div id="reportModal" class="modal">
				<div class="modal-content">
					<span class="close" id="closeReportModal">&times;</span>
					<h2>What's your concern?</h2>
					<form action="ownsubmitrep.php" method="POST">
					<label for="title">Title:</label><br>
					<input type="text" id="title" name="title" required><br><br>

					<label for="content">Content:</label><br>
					<textarea id="content" name="content" rows="5" required></textarea><br><br>

					<!-- Hidden user_id (you can replace this with session ID logic) -->
					<input type="hidden" name="user_id" value="1">

					<button type="submit" style="background: #4CAF50; color: white; padding: 8px 16px; border: none; border-radius: 4px;">
						Submit
					</button>
					</form>
				</div>
			</div>
		</ul>
		<ul class="side-menu">
			<!-- Sidebar Button -->
    <li>
      <a href="#" id="openModalBtn">
        <i class='bx bxs-cog'></i>
        <span class="text">View Reports</span>
      </a>
		</li>

		<!-- Modal Structure -->
		<div id="myModal" class="modal">
			<div class="modal-content">
					<span class="close" id="closeModalBtn">&times;</span>
					<h2>Reports List</h2>
					<p>Here you can view reports.</p><br>
					
					<!-- Orders Table -->
					<div id="reportssContent">
					<?php include 'crewfetchrep.php'; ?> <!-- Shows current reports -->
					</div><br>
      </div>
		</div>
			<li>
				<a href="logout.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->
	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<p>iNVAX - Inventory Management System</p>
				</div>
				<div id="search-results"></div>

				<script>
document.querySelector('.search-btn').addEventListener('click', function (e) {
    e.preventDefault(); // Prevent form submission if it's inside a form

    const query = document.getElementById('live-search').value.trim();

    if (query === '') {
        document.getElementById('search-results').innerHTML = ''; // Clear results
        return; // Don't send the request
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'serach.php', true); // Make sure it's spelled correctly
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.status === 200) {
            document.getElementById('search-results').innerHTML = this.responseText;
        }
    };

    xhr.send('query=' + encodeURIComponent(query));
});
</script>

			</form>
			<!-- Notification Bell -->
			<a href="#" class="notification" id="notifBell" style="position: relative;">
			<i class='bx bxs-bell'></i>
			<span class="num">0</span>
			</a>

			<!-- Notification Dropdown -->
			<div id="notifDropdown" class="notif-dropdown">
			<h4>Notifications</h4>
			<ul id="notifList">
				<!-- Notifications will load here -->
			</ul>
			</div>

			<!--bgmc logo-->
			<a href="https://www.facebook.com/profile.php?id=100076371194984" class="profile">
				<img src="assets/bgmc-modified.png">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left" id="db">
					<h1>Dashboard</h1>
						<!--<li><i class='bx bx-chevron-right' ></i></li>-->
				</div>
				<a href="https://www.facebook.com/KLDOfficialFBPage" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Contact Developers</span>
				</a>
			</div>

			<ul class="box-info">
			<li class="collapsible-box">
				<div class="box-header">
					<i class='bx bxs-shopping-bag'></i>
					<span class="text">
						<?php
						include 'db.php';

						$stmt = $pdo->query("SELECT COUNT(*) as total FROM product_categories");
						$row = $stmt->fetch();
						$totalProducts = $row['total'];
						?>
						<h3><?= $totalProducts ?></h3>
						<p>Product Categories</p>
					</span>
				</div>
			</li>

                <li class="collapsible-box" id="stockBox">
                    <div class="box-header">
					    <i class='bx bxs-package' ></i>
					    <span class="text">
							<?php
							include 'db.php';

							$stmt = $pdo->query("SELECT COUNT(*) as total FROM orders");
							$row = $stmt->fetch();
							$totalStocks = $row['total'];
							?>
							<h3><?= $totalStocks ?></h3>
						<p>Stocks</p>
					    </span>
                    </div>
                    <div class="box-content">
			            <p>More info about Stocks...</p>
		            </div>
				</li>
                <li class="collapsible-box">
				<div class="box-header">
					<i class='bx bxs-group'></i>
					<span class="text">
					<?php
						include 'db.php';

						$stmt = $pdo->query("SELECT COUNT(*) as total FROM supplier");
						$row = $stmt->fetch();
						$totalSupp = $row['total'];
						?>
						<h3><?= $totalSupp ?></h3>
						<p>Suppliers</p>
					</span>
				</div>
    <div class="box-content">
        <ul>
		<?php
						//$stmt = $pdo->query("SELECT supplier_name FROM product");
						// ($supplier = $stmt->fetch(PDO::FETCH_ASSOC)) {
						//	echo "<li>";
						//	echo "<strong>" . htmlspecialchars($product['product_name']) . "</strong><br>";
							//echo "Price: ₱" . number_format($product['unit_price'], 2) . "<br>";
//echo "Quantity: " . intval($product['quantity']);
						//	echo "</li>";
//}
						?>
        </ul>
    </div>
</li>

					<li class="collapsible-box">
						<div class="box-header">
							<i class='bx bxs-dollar-circle'></i>
							<span class="text">
								<h3>
									<?php
									require 'db.php';
									$stmt = $pdo->query("
										SELECT SUM(t.quantity * p.unit_price) AS total_value
										FROM transactions t
										JOIN product p ON t.product_id = p.product_id
									");
									$total = $stmt->fetchColumn();
									echo "₱" . number_format($total ?? 0, 2);
									?>
								</h3>
								<p>Total Transactions</p>
							</span>
						</div>
						<div class="box-content">
							<p>More info about Total Transactions...</p>
						</div>
					</li>
			</ul>
<!--graphs-->
            <div class="graphBox">
    <div class="box">
        <div id="chart1" style="width: 200%; height: 400px;"></div>
    </div>
    <div class="box">
        <div id="chart2" style="width: 100%; height: 400px;"></div>
    </div>
</div>

			<?php
			try {
				$stmt = $pdo->query("SELECT fname, lname, employment_status, user_level_id FROM users ORDER BY created_at DESC");
				$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				die("Error fetching users: " . $e->getMessage());
			}
			?>
			
					<!-- Chart Container -->
    <div id="curve_chart" style="width: 100%; height: 500px; margin-top: 20px;"></div>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    // Fetch data from the backend
    fetch('fetchitemdata.php')
      .then(response => response.json())
      .then(chartData => {
        // Convert JSON data to Google Charts format
        const data = google.visualization.arrayToDataTable(chartData);

        // Chart options
        const options = {
          title: 'Stock and Product Acquisition Data', 
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        // Draw the chart
        const chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
      })
      .catch(error => console.error('Error fetching chart data:', error));
  }
</script>
			
            <div id="addItemSidebar" class="activity-sidebar">
                <div class="sidebar-header">
                    <h3>Add Items into Inventory</h3>
                    <button id="closeAddItemSidebar">&times;</button>
                </div>
                <form id="multiItemForm" method="POST" action="addprod.php">
					<div id="itemContainer">
						<div class="item-entry">
							<input type="text" name="product_name[]" placeholder="Item name" required>
							<input type="number" name="unit_price[]" placeholder="Unit price" required>
							<input type="number" name="quantity[]" placeholder="Quantity" required>
						<!-- Category Dropdown (inside item-entry div) -->
							<select name="category_id[]" required>
								<option value="">Select Category</option>
								<?php
								require 'db.php';
								// Fetch categories from the product_categories table
								$stmt = $pdo->query("SELECT category_id, category_name FROM product_categories");
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									echo "<option value=\"" . htmlspecialchars($row['category_id']) . "\">" . htmlspecialchars($row['category_name']) . "</option>";
								}
								?>
							</select>
							<button type="button" class="removeItemBtn">Remove</button>
						</div>
					</div>
					<button type="button" id="addItemBtn">Add Another Item</button>
					<br><br>
					<button type="submit">Submit All Items</button>
				</form>

            </div>
        </div>
		</main>
		<!-- MAIN -->
	</section>


	<div id="notification" style="display:none; background: #4caf50; color: white; padding: 12px; border-radius: 5px; margin: 10px 0;">
  ✅ Order Successful!
</div>

	<!-- CONTENT -->


    <!-- JS -->
   <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
	<script src="scripts/scripts.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

	<script type ="text/javascript">
			$(document).ready(function(){
				$("#live-search").on("keyup", function() {
					var input = $(this).val();
						if(input != "") {
							$.ajax({
								url: "search.php",
								method: "POST",
								data: {input: input},
								success: function(data) {
									$("#searchresult").html(data);
								}
							});
						} else {
							$("#searchresult").css("display", "none");
						}


					$(".employee-list tbody tr").filter(function() {
						$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
					});
				});
			});
	</script>
    <script>
    // Close sidebar when clicking outside of it
    document.addEventListener('click', function(event) {
    const isClickInsideSidebar = addItemSidebar.contains(event.target);
    const isClickOnButton = openAddItemBtn.contains(event.target);

    if (!isClickInsideSidebar && !isClickOnButton) {
        addItemSidebar.classList.remove('open');
    }
});
//for adding items
    const addItemSidebar = document.getElementById('addItemSidebar');
    const openAddItemBtn = document.getElementById('add-item-button');
    const closeAddItemBtn = document.getElementById('closeAddItemSidebar');

    openAddItemBtn.addEventListener('click', () => {
    addItemSidebar.classList.add('open');
    });

    closeAddItemBtn.addEventListener('click', () => {
    addItemSidebar.classList.remove('open');
    });
    document.querySelectorAll('.box-header').forEach(header => {
	header.addEventListener('click', () => {
		const parent = header.parentElement;
		parent.classList.toggle('active');
	});
});
//for boxes
    document.getElementById('sidebarStockLink').addEventListener('click', function (e) {
	e.preventDefault(); // Prevent default anchor behavior

	const stockBox = document.getElementById('stockBox');
	stockBox.classList.toggle('active');
});
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("itemContainer");
    const addItemBtn = document.getElementById("addItemBtn");

    addItemBtn.addEventListener("click", () => {
        const entry = document.createElement("div");
        entry.classList.add("item-entry");
        entry.innerHTML = `
            <input type="text" name="product_name[]" placeholder="Item name" required>
            <input type="number" name="unit_price[]" placeholder="Unit price" required>
            <input type="number" name="quantity[]" placeholder="Quantity" required>
            <button type="button" class="removeItemBtn">Remove</button>`;
        container.appendChild(entry);
    });

    container.addEventListener("click", (e) => {
        if (e.target.classList.contains("removeItemBtn")) {
            e.target.parentElement.remove();
        }
    });
});
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var openModalBtn = document.getElementById("openModalBtn");

// Get the <span> element that closes the modal
var closeModalBtn = document.getElementById("closeModalBtn");

// When the user clicks the button, open the modal
openModalBtn.onclick = function(event) {
  event.preventDefault(); // Prevent default anchor behavior
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
closeModalBtn.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

document.getElementById("openReportModalBtn").onclick = function() {
  document.getElementById("reportModal").style.display = "block";
};
document.getElementById("closeReportModal").onclick = function() {
  document.getElementById("reportModal").style.display = "none";
};
window.onclick = function(event) {
  if (event.target == document.getElementById("reportModal")) {
    document.getElementById("reportModal").style.display = "none";
  }
};
  // Check if the URL contains ?report=submitted
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('report') === 'submitted') {
    alert('Report submitted successfully!');
    // Remove the parameter from URL without reloading
    history.replaceState(null, '', window.location.pathname);
  }
const bell = document.getElementById('notifBell');
const dropdown = document.getElementById('notifDropdown');

bell.addEventListener('click', function (e) {
  e.preventDefault();
  dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
  loadNotifications();
});

window.addEventListener('click', function(e) {
  if (!bell.contains(e.target) && !dropdown.contains(e.target)) {
    dropdown.style.display = 'none';
  }
});

function loadNotifications() {
  fetch('fetchnotif.php')
    .then(res => res.json())
    .then(data => {
      const notifList = document.getElementById('notifList');
      notifList.innerHTML = '';
      data.forEach(n => {
        notifList.innerHTML += `<li>${n.message} <br><small>${n.created_at}</small></li>`;
      });
      document.querySelector('.notification .num').textContent = data.length;
    });
}

setInterval(loadNotifications, 5000);
loadNotifications();
//for orders notif
  document.addEventListener("DOMContentLoaded", function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get("order") === "success") {
      const note = document.getElementById("notification");
      if (note) {
        note.style.display = "block";
        setTimeout(() => note.style.display = "none", 3000);
      }
    }
  });

 type="text/javascript">
  google.charts.load("current", { packages: ["corechart"] });
  google.charts.setOnLoadCallback(drawCharts);

  function drawCharts() {
    // Chart 1: Product Categories
    var data1 = google.visualization.arrayToDataTable([
      ['Category', 'Count'],
      <?php
      $conn = mysqli_connect("localhost", "root", "", "system");
      $sql1 = "SELECT category_name, COUNT(*) as count FROM product_categories GROUP BY category_name";
      $result1 = mysqli_query($conn, $sql1);
      if ($result1 && mysqli_num_rows($result1) > 0) {
          while ($row = mysqli_fetch_assoc($result1)) {
              echo "['" . $row['category_name'] . "', " . $row['count'] . "],";
          }
      } else {
          echo "['No Data', 0]";
      }
      ?>
    ]);

    var options1 = {
      title: 'Product Categories',
      pieHole: 0.7,
	  slices: {
    1: { offset: 0.1 },
    3: { offset: 0.4 },
    4: { offset: 0.2 }
  }
	  
    };

    var chart1 = new google.visualization.PieChart(document.getElementById('chart1'));
    chart1.draw(data1, options1);

    // Chart 2: Order Status
    var data2 = google.visualization.arrayToDataTable([
      ['Status', 'Count'],
      <?php
      $sql2 = "SELECT order_status, COUNT(*) as count FROM orders GROUP BY order_status";
      $result2 = mysqli_query($conn, $sql2);
      if ($result2 && mysqli_num_rows($result2) > 0) {
          while ($row = mysqli_fetch_assoc($result2)) {
              echo "['" . $row['order_status'] . "', " . $row['count'] . "],";
          }
      } else {
          echo "['No Data', 0]";
      }
      ?>
    ]);

    var options2 = {
      title: 'Order Status Distribution',
      is3D: true
    };

    var chart2 = new google.visualization.PieChart(document.getElementById('chart2'));
    chart2.draw(data2, options2);
  }

// Function to reload orders via AJAX
function refreshOrders() {
  fetch('fetchord.php')
    .then(response => response.text())
    .then(data => {
      document.getElementById('ordersContent').innerHTML = data;
    })
    .catch(error => console.error('Error fetching orders:', error));
}

// Refresh every 5 seconds
setInterval(() => {
  const modal = document.getElementById('myModal');
  if (modal && modal.style.display === 'block') { // Only refresh if modal is open
    refreshOrders();
  }
}, 5000);

// Fetch data from fetchnotif.php
fetch('fetchnotif.php')
    .then(response => response.json())
    .then(data => {
        console.log(data);

        // Display notifications
        data.notifications.forEach(notification => {
            console.log(`Notification: ${notification.message} at ${notification.created_at}`);
        });

        // Display recent orders
        data.recent_orders.forEach(order => {
            console.log(`Order ID: ${order.order_id}, Product ID: ${order.product_id}, Quantity: ${order.quantity_ordered}`);
        });

        // Display inventory updates
        data.inventory_updates.forEach(update => {
            console.log(`Product ID: ${update.product_id}, Quantity: ${update.quantity}, Last Updated: ${update.last_updated}`);
        });
    })
    .catch(error => console.error('Error fetching data:', error));


	document.getElementById('notificationsButton').addEventListener('click', () => {
    fetch('fetchnotif.php')
        .then(response => response.json())
        .then(data => {
            const notifList = document.getElementById('notifList');
            notifList.innerHTML = ''; // Clear existing notifications

            data.notifications.forEach(notification => {
                const listItem = document.createElement('li');
                listItem.textContent = notification.message;
                listItem.setAttribute('data-id', notification.id); // Assuming each notification has an 'id'
                listItem.classList.add('notification-item');
                notificationsList.appendChild(listItem);
            });

            // Show the modal
            document.getElementById('notificationsModal').style.display = 'block';
        })
        .catch(error => console.error('Error fetching notifications:', error));
});
document.getElementById('notifList').addEventListener('click', (event) => {
    if (event.target.classList.contains('notification-item')) {
        const notificationId = event.target.getAttribute('data-id');

        // Fetch the report for the clicked notification
        fetch(`fetchreport.php?id=${notificationId}`)
            .then(response => response.text())
            .then(reportHtml => {
                // Display the report below the "Items Management" section
                const itemsManagementSection = document.getElementById('itemsManagement');
                const reportContainer = document.getElementById('reportContainer') || document.createElement('div');
                reportContainer.id = 'reportContainer';
                reportContainer.innerHTML = reportHtml;
                itemsManagementSection.appendChild(reportContainer);
            })
            .catch(error => console.error('Error fetching report:', error));
    }
});
// Add event listener to the notification bell
document.getElementById('notifiBell').addEventListener('click', () => {
    // Fetch reports from the backend
    fetch('fetchnotif.php')
        .then(response => response.json())
        .then(reports => {
            const reportsList = document.getElementById('reportsList');
            reportsList.innerHTML = ''; // Clear existing reports

            // Populate the reports list
            reports.forEach(report => {
                const listItem = document.createElement('li');
                listItem.classList.add('log-list');
                listItem.innerHTML = `
                    <p><strong>${report.title}</strong></p>
                    <p>Created At: ${report.created_at}</p>
                `;
                reportsList.appendChild(listItem);
            });
        })
        .catch(error => console.error('Error fetching reports:', error));
});
</script>

  

</body>
</html>
