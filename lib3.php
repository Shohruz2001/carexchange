<!-- lib3.php -->
<?php
require_once('util-db.php');  // Include the database connection
$pageTitle = "Line Chart: Car Availability Over Time";
include "view-header.php";  // Include the header for the page

// Fetch car availability over time
$conn = get_db_connection();
$stmt = $conn->prepare("SELECT availability_start, COUNT(*) AS car_count FROM cars GROUP BY availability_start ORDER BY availability_start ASC");
$stmt->execute();
$result = $stmt->get_result();
$conn->close();

$dates = [];
$car_counts = [];

while ($row = $result->fetch_assoc()) {
    $dates[] = $row['availability_start'];
    $car_counts[] = $row['car_count'];
}
?>

<h1>Lib3: Line Chart for Car Availability Over Time</h1>
<p>This page uses Chart.js to display a line chart visualizing car availability over time, based on the start dates of car availability.</p>

<canvas id="availabilityLineChart" width="400" height="400"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('availabilityLineChart').getContext('2d');
    var availabilityLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($dates); ?>,  // Dynamic availability dates from DB
            datasets: [{
                label: 'Car Availability Over Time',
                data: <?php echo json_encode($car_counts); ?>,  // Car counts dynamically from DB
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Availability Start Date'
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 10
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Number of Cars'
                    },
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return 'Available cars: ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
</script>

<?php include "view-footer.php"; ?>
