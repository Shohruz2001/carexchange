<!-- lib1.php -->
<?php
require_once('util-db.php');  // Include the database connection
$pageTitle = "Pie Chart: Car Models";
include "view-header.php";  // Include the header for the page

// Fetch car model counts from the database
$conn = get_db_connection();
$stmt = $conn->prepare("SELECT model, COUNT(*) AS model_count FROM cars GROUP BY model");
$stmt->execute();
$result = $stmt->get_result();
$conn->close();

$models = [];
$counts = [];
while ($row = $result->fetch_assoc()) {
    $models[] = $row['model'];
    $counts[] = $row['model_count'];
}
?>

<h1>Lib1: Interactive Pie Chart using Chart.js</h1>
<p>This page uses Chart.js to display a dynamic and interactive pie chart showing the distribution of car models across different locations.</p>

<canvas id="carPieChart" width="400" height="400"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('carPieChart').getContext('2d');
    var carPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($models); ?>,  // Car models dynamically from DB
            datasets: [{
                label: 'Car Models',
                data: <?php echo json_encode($counts); ?>,  // Car model counts dynamically from DB
                backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A6', '#FFC300', '#DAF7A6', '#581845'],
                borderColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A6', '#FFC300', '#DAF7A6', '#581845'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw + ' cars';
                        }
                    }
                },
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            }
        }
    });
</script>

<?php include "view-footer.php"; ?>