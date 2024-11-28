<!-- lib3.php -->
<?php
require_once('util-db.php');  // Include the database connection
$pageTitle = "Line Chart: Car Availability Over Time (By Month)";
include "view-header.php";  // Include the header for the page

// Fetch car availability grouped by month and year
$conn = get_db_connection();
$stmt = $conn->prepare("
    SELECT 
        DATE_FORMAT(availability_start, '%Y-%m') AS month, 
        COUNT(*) AS car_count 
    FROM cars 
    GROUP BY month
    ORDER BY month ASC
");
$stmt->execute();
$result = $stmt->get_result();
$conn->close();

$months = [];
$car_counts = [];

while ($row = $result->fetch_assoc()) {
    $months[] = $row['month'];  // Format: 'YYYY-MM'
    $car_counts[] = $row['car_count'];
}

// Format months as 'Month YYYY'
$formatted_months = array_map(function($month) {
    $date = DateTime::createFromFormat('Y-m', $month);
    return $date->format('F Y');  // e.g., 'January 2024'
}, $months);
?>

<h1>Lib3: Line Chart for Car Availability Over Time (By Month)</h1>
<p>This page uses Chart.js to display a line chart visualizing car availability by month, based on the start dates of car availability.</p>

<canvas id="availabilityLineChart" width="400" height="400"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('availabilityLineChart').getContext('2d');
    var availabilityLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($formatted_months); ?>,  // Formatted month labels
            datasets: [{
                label: 'Car Availability Over Time (Monthly)',
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
                        text: 'Month and Year'
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 12
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
