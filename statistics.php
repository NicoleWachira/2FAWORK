<?php
require 'events_connect.php'; // Database connection

// Get Total Events
$totalEventsQuery = $conn->query("SELECT COUNT(*) AS total_events FROM events");
$totalEvents = $totalEventsQuery->fetch()['total_events'];

// Get Total Tickets Sold
$totalTicketsQuery = $conn->query("SELECT SUM(tickets_sold) AS total_tickets FROM events");
$totalTickets = $totalTicketsQuery->fetch()['total_tickets'];

// Get Revenue per Event
$revenueQuery = $conn->query("
    SELECT eventname, (price * tickets_sold) AS revenue 
    FROM events
");
$revenueData = $revenueQuery->fetchAll();

// Get Total Revenue
$totalRevenueQuery = $conn->query("
    SELECT SUM(price * tickets_sold) AS total_revenue FROM events
");
$totalRevenue = $totalRevenueQuery->fetch()['total_revenue'];

// Get Highest & Lowest Revenue Event
$highestRevenueEvent = $conn->query("
    SELECT eventname, (price * tickets_sold) AS revenue 
    FROM events 
    ORDER BY revenue DESC LIMIT 1
")->fetch();

$lowestRevenueEvent = $conn->query("
    SELECT eventname, (price * tickets_sold) AS revenue 
    FROM events 
    ORDER BY revenue ASC LIMIT 1
")->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics</title>
    <link rel="stylesheet" href="statistics.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="Home2.php">Home</a></li>
            <li><a href="dashboard2.php">Profile</a></li>
            <li><a href="admin.php" class="active">Dashboard</a></li>
            <li><a href="statistics.php">Statistics</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>


<div class="container">
    <h2>Event & Ticket Sales Statistics</h2>
    <div class="stats-box">Total Events: <?php echo $totalEvents; ?></div>
    <div class="stats-box">Total Tickets Sold: <?php echo $totalTickets; ?></div>

    <h2>Financial Statistics</h2>
    <div class="stats-box">Total Revenue: Ksh <?php echo number_format($totalRevenue, 2); ?></div>
    <div class="stats-box">Highest Revenue Event: <?php echo $highestRevenueEvent['event_name']; ?> (Ksh <?php echo number_format($highestRevenueEvent['revenue'], 2); ?>)</div>
    <div class="stats-box">Lowest Revenue Event: <?php echo $lowestRevenueEvent['event_name']; ?> (Ksh <?php echo number_format($lowestRevenueEvent['revenue'], 2); ?>)</div>

    <!-- Charts -->
    <h2>Revenue per Event</h2>
    <canvas id="revenueChart"></canvas>

    <h2>Ticket Sales Distribution</h2>
    <canvas id="salesPieChart"></canvas>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const eventLabels = <?php echo json_encode(array_column($revenueData, 'event_name')); ?>;
    const revenueData = <?php echo json_encode(array_column($revenueData, 'revenue')); ?>;

    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: eventLabels,
            datasets: [{
                label: 'Revenue (Ksh)',
                data: revenueData,
                backgroundColor: 'yellow',
                borderColor: 'black',
                borderWidth: 2
            }]
        },
        options: {
            plugins: {
                legend: { labels: { color: 'yellow' } }
            },
            scales: {
                x: { ticks: { color: 'yellow' }, grid: { color: 'gray' } },
                y: { ticks: { color: 'yellow' }, grid: { color: 'gray' } }
            }
        }
    });

    new Chart(document.getElementById('salesPieChart'), {
        type: 'pie',
        data: {
            labels: eventLabels,
            datasets: [{
                data: revenueData,
                backgroundColor: ['yellow', 'black', 'gray', '#FFD700', '#FFA500'],
                borderColor: 'black'
            }]
        },
        options: {
            plugins: {
                legend: { labels: { color: 'yellow' } }
            }
        }
    });
});
</script>

</body>
</html>
