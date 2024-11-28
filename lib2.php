<!-- lib2.php -->
<?php
require_once('util-db.php');  // Include the database connection
$pageTitle = "Car Availability Heatmap";
include "view-header.php";  // Include the header for the page

// Fetch car availability data by location and time (could be monthly, daily, etc.)
$conn = get_db_connection();
$stmt = $conn->prepare("SELECT location, availability_start, availability_end FROM cars");
$stmt->execute();
$cars = $stmt->get_result();
$conn->close();

// Prepare data for the heatmap
$locations = [];
$times = [];
$availability = [];

// Example of data transformation (this will be done in the loop for dynamic data)
while ($row = $cars->fetch_assoc()) {
    $locations[] = $row['location'];
    $times[] = $row['availability_start'];  // Consider modifying the time format as needed
    $availability[] = rand(1, 10);  // Random data for heatmap intensity (replace with actual logic)
}

?>

<h1>Lib2: Car Availability Heatmap using Chart.js</h1>
<p>This page uses Chart.js to display a heatmap showing the availability of cars over time in different locations.</p>

<canvas id="carHeatmap" width="400" height="400"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-heatmap@1.0.0"></script>
<script>
    var ctx = document.getElementById('carHeatmap').getContext('2d');

    var carHeatmap = new Chart(ctx, {
        type: 'heatmap',
        data: {
            labels: <?php echo json_encode($locations); ?>,  // Locations dynamically from DB
            datasets: [{
                label: 'Car Availability',
                data: <?php echo json_encode($availability); ?>,  // Random availability data for heatmap
                backgroundColor: 'rgba(0, 255, 0, 0.5)',  // Modify color range for the heatmap
                borderColor: 'rgba(0, 255, 0, 1)',
                borderWidth: 1
            }]
        }
    });
</script>

<?php include "view-footer.php"; ?>
