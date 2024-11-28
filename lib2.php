<!-- lib2.php -->
<?php
require_once('util-db.php');  // Include the database connection
$pageTitle = "Car Availability Heatmap";
include "view-header.php";  // Include the header for the page

// Fetch car availability data from the database
$conn = get_db_connection();
$stmt = $conn->prepare("SELECT location, availability_start, availability_end, COUNT(*) AS car_count FROM cars GROUP BY location, availability_start, availability_end");
$stmt->execute();
$result = $stmt->get_result();
$conn->close();

$locations = [];
$availability = [];
$car_counts = [];

while ($row = $result->fetch_assoc()) {
    $locations[] = $row['location'];
    $availability[] = $row['availability_start'];
    $car_counts[] = $row['car_count'];
}
?>

<h1>Lib2: Heatmap of Car Availability</h1>
<p>This page uses Chart.js with the Heatmap plugin to visualize car availability over time and location.</p>

<canvas id="carHeatmap" width="400" height="400"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-heatmap"></script>
<script>
    var ctx = document.getElementById('carHeatmap').getContext('2d');

    var data = {
        datasets: [{
            label: 'Car Availability by Location and Time',
            data: <?php echo json_encode($car_counts); ?>,
            xAxisID: 'location',
            yAxisID: 'time',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    };

    var config = {
        type: 'heatmap',
        data: data,
        options: {
            responsive: true,
            scales: {
                x: { 
                    type: 'category',
                    labels: <?php echo json_encode($locations); ?>,
                    title: { text: 'Location', display: true }
                },
                y: { 
                    type: 'category',
                    labels: <?php echo json_encode($availability); ?>,
                    title: { text: 'Availability Date', display: true }
                }
            }
        }
    };

    var carHeatmap = new Chart(ctx, config);
</script>

<?php include "view-footer.php"; ?>
