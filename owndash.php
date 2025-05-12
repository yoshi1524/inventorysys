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

	<title>Manager Hub</title>
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
				<a href="#" id="sidebarStockLink">
					<i class='bx bxs-package' ></i>
					<span class="text">My Stocks</span>
				</a>
			</li>
			<li>
				<a href="#myChart">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Analytics</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Message</span>
				</a>
			</li>
			<li>
				<a href="#team">
					<i class='bx bxs-group' ></i>
					<span class="text">Team</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
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
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">8</span>
			</a>
			<a href="#" class="profile">
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
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a>
			</div>

			<ul class="box-info">
                <li class="collapsible-box">
                     <div class="box-header">
                        <i class='bx bxs-shopping-bag'></i>
					    <span class="text">
						<h3>80</h3>
						<p>Products</p>
					    </span>
                     </div>
                     <div class="box-content">
			            <p>Additional details about Products...</p>
		            </div>
				</li>
                <li class="collapsible-box" id="stockBox">
                    <div class="box-header">
					    <i class='bx bxs-package' ></i>
					    <span class="text">
						<h3>80</h3>
						<p>Stocks</p>
					    </span>
                    </div>
                    <div class="box-content">
			            <p>More info about Stocks...</p>
		            </div>
				</li>
                <li class="collapsible-box">
                    <div class="box-header">
					    <i class='bx bxs-group' ></i>
                        <span class="text">
                            <h3>768</h3>
                            <p>Suppliers</p>
                        </span>
                    </div>
                    <div class="box-content">
			            <p>More info about Suppliers...</p>
		            </div>
				</li>
                <li class="collapsible-box">
                    <div class="box-header">
					    <i class='bx bxs-dollar-circle' ></i>
                        <span class="text">
                            <h3>₱75230</h3>
                            <p>Total Transactions</p>
                        </span>
                    </div>
                    <div class="box-content">
			            <p>More info about Total Transactions...</p>
		            </div>
				</li>
			</ul>

            <div class="graphBox">
                <div class="box">
                    <canvas id="myChart"></canvas>
                </div>
                <div class="box">
                    <canvas id="myChart2"></canvas>
                </div>
               </div>

			<div class="table-data">
				<div class="employee-list" id="team">
					<div class="head">
						<h3>Employee List</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>User</th>
								<th>Status</th>
								<th>Role</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<img src="img/people.png">
									<p>John Wick</p>
								</td>
								<td>Full Time</td>
								<td><span class="status manager">Manager</span></td>
							</tr>
							<tr>
								<td>
									<img src="assets/nel.jpg">
									<p>Nel Garin</p>
								</td>
								<td>Full Time</td>
								<td><span class="status employee">Employee</span></td>
							</tr>
							<tr>
								<td>
									<img src="assets/RM.jpg">
									<p>RM Santos</p>
								</td>
								<td>Full Time</td>
								<td><span class="status employee">Employee</span></td>
							</tr>
							<tr>
								<td>
									<img src="assets/JArmonio.jpg">
									<p>Janjan Armonio</p>
								</td>
								<td>Full Time</td>
								<td><span class="status employee">Employee</span></td>
							</tr>
							<tr>
								<td>
									<img src="assets/mirror shot.jpg">
									<p>Allen</p>
								</td>
								<td>Part TIme</td>
								<td><span class="status employee">Employee</span></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
        </div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->


    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
	<script src="scripts/scripts.js"></script>

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
            <button type="button" class="removeItemBtn">Remove</button>
        `;
        container.appendChild(entry);
    });

    container.addEventListener("click", (e) => {
        if (e.target.classList.contains("removeItemBtn")) {
            e.target.parentElement.remove();
        }
    });
});
</script>

</body>
</html>
