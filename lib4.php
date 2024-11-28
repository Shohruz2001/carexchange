<!-- lib4.php -->
<?php
require_once('util-db.php');  // Include the database connection
$pageTitle = "Bar Chart: Cars by Location";
include "view-header.php";  // Include the header for the page

// Fetch car counts by location from the database
$conn = get_db_connection();
$stmt = $conn->prepare("SELECT location, COUNT(*) AS car_count FROM cars GROUP BY location");
$stmt->execute();
$result = $stmt->get_result();
$conn->close();

$locations = [];
$counts = [];
while ($row = $result->fetch_assoc()) {
    $locations[] = $row['location'];
    $counts[] = $row['car_count'];
}
?>

<h1>Lib4: Bar Chart using Chart.js</h1>
<p>This page uses Chart.js to display a bar chart showing the count of cars by location.</p>

<canvas id="carBarChart" width="400" height="400"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('carBarChart').getContext('2d');
    var carBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($locations); ?>,  // Car locations dynamically from DB
            datasets: [{
                label: 'Car Count by Location',
                data: <?php echo json_encode($counts); ?>,  // Car count by location dynamically from DB
                backgroundColor: '#3498db',
                borderColor: '#2980b9',
                borderWidth: 1
            }]
        }
    });
</script>

<?php include "view-footer.php"; ?>
