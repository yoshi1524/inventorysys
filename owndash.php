<?php
session_start();
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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="owndashb.css">

	<title>AdminHub</title>
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
				<a href="#">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-package' ></i>
					<span class="text">My Stocks</span>
				</a>
			</li>
			<li>
				<a href="#">
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
				<a href="#">
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
				<img src="img/people.png">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-shopping-bag'></i>
					<span class="text">
						<h3>80</h3>
						<p>Items</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-package' ></i>
					<span class="text">
						<h3>80</h3>
						<p>Stocks</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group' ></i>
					<span class="text">
						<h3>768</h3>
						<p>Customers</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-dollar-circle' ></i>
					<span class="text">
						<h3>₱75230</h3>
						<p>Total Sales</p>
					</span>
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
				<div class="employee-list">
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
				<div class="activity-log">
					<div class="head">
						<h3>Activity Logs</h3>
					</div>
					<ul class="activity-log-list">
						<li class="log-list">
							<input type="text" name="add-item" placeholder="Add Item6">
							<button class="add-item-button" id="add-item-button">Add</button>
						</li>
						<li class="log-list">
							<p>Edit Items</p>
							<button class="edit-item-button" id="edit-item-button">Edit</button>
						</li>
						<li class="log-list">
							<p>Archive Items</p>
							<button class="archive-item-button" id="archive-item-button">Archive</button>
						</li>
					</ul>
				</div>
			</div>
              	

		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
	<script src="scripts.js"></script>
</body>
</html>
