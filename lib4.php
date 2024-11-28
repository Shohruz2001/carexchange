<!-- lib4.php -->
<?php
require_once('util-db.php'); 
$pageTitle = "Donut Chart: Car Counts by Location";
include "view-header.php"; 

// Fetch car counts by location
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

<h1>Lib4: Donut Chart using Chart.js</h1>
<p>This page uses Chart.js to display a donut chart showing the distribution of cars by location.</p>

<canvas id="carDonutChart" width="400" height="400"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('carDonutChart').getContext('2d');
    var carDonutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($locations); ?>,  // Dynamic car locations
            datasets: [{
                label: 'Car Count by Location',
                data: <?php echo json_encode($counts); ?>,  // Dynamic car counts
                backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A6'],
                borderColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A6'],
                borderWidth: 1
            }]
        }
    });
</script>

<?php include "view-footer.php"; ?>
