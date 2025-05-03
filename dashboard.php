<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Dashboard</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="dash.css">
    <!-- Include Chart.js library from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Dashboard Container -->
    <div class="dashboard">
        <!-- Navigation Sidebar -->
        <nav class="sidebar">
            <h2 class="logo">Dashboard</h2>
            <ul>
                <li><a href="#">User</a>
</li>

                <li><a href="#">Product Monitoring</a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="#">Settings</a></li>
            </ul>
        </nav>

        <!-- Main Content Area -->
        <div class="main-content">
            <!-- Header Section -->
            <header>
                <h1>Welcome, User</h1>
                <p>Here are your latest stats.</p>
            </header>

            <!-- Widgets Section -->
            <section class="widgets">
                <!-- Widget 1 -->
                <div class="widget">
                    <h3>Total Sales</h3>
                    <p>1,234</p>
                </div>
                <!-- Widget 2 -->
                <div class="widget">
                    <h3>Customer</h3>
                    <p>10</p>
                </div>
                <!-- Widget 3 -->
                <div class="widget">
                    <h3>Product</h3>
                    <p>89</p>
                </div>
                <div class="widget">
                    <h3>Stock</h3>
                    <p>89</p>
                </div>
            </section>

            <!-- Charts Section -->
            <section class="charts">
                <!-- Line Chart Container -->
                <div class="chart-container">
                    <h1>Monthly Sales</h1>
        <canvas id="salesChart" class="chart"></canvas>
    </div>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May'],
                datasets: [{
                    label: 'Sales',
                    data: [12000, 15000, 18000, 20000, 22000],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
                    <canvas id="lineChart"></canvas>
                </div>
                <!-- Bar Chart Container -->
                <div class="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
            </section>
        </div>
    </div>
    <!-- Link to external JavaScript file -->
    <script src="script.js"></script>
</body>