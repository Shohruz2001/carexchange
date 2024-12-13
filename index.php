<?php 
$pageTitle = "Home";
include "view-header.php"; 
?>

<div class="container mt-5">
    <!-- Homepage Title -->
    <h1 class="text-center">Welcome to the Care Exchange Platform</h1>
    <p class="text-center mt-3">Explore key insights into car availability, usage trends, and distribution across our platform through interactive visualizations below.</p>

    <!-- Row for Charts -->
    <div class="row mt-5">
        <!-- Pie Chart: Car Models -->
        <div class="col-md-6 mb-4">
            <h3 class="text-center">Car Models Distribution</h3>
            <p class="text-center">A breakdown of car models in our system.</p>
            <canvas id="carPieChart" style="max-height: 300px;"></canvas>
        </div>

        <!-- Column Chart: Car Count By Location and Year -->
        <div class="col-md-6 mb-4">
            <h3 class="text-center">Car Count by Location and Year</h3>
            <p class="text-center">Compare car counts across various locations and years.</p>
            <div id="carColumnChart" style="max-height: 300px;"></div>
        </div>
    </div>

    <div class="row">
        <!-- Line Chart: Car Availability -->
        <div class="col-md-6 mb-4">
            <h3 class="text-center">Car Availability Over Time</h3>
            <p class="text-center">Track car availability trends over months.</p>
            <canvas id="availabilityLineChart" style="max-height: 300px;"></canvas>
        </div>

        <!-- Donut Chart: Distribution of Cars by Location -->
        <div class="col-md-6 mb-4">
            <h3 class="text-center">Car Distribution by Location</h3>
            <p class="text-center">The distribution of cars across locations.</p>
            <canvas id="carDonutChart" style="max-height: 300px;"></canvas>
        </div>
    </div>
</div>

<!-- JavaScript for all charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>

<!-- PHP: Fetch Data for Charts -->
<?php
require_once('util-db.php');

// Pie Chart Data
$conn = get_db_connection();
$stmt = $conn->prepare("SELECT model, COUNT(*) AS model_count FROM cars GROUP BY model");
$stmt->execute();
$result = $stmt->get_result();
$models = [];
$counts = [];
while ($row = $result->fetch_assoc()) {
    $models[] = $row['model'];
    $counts[] = $row['model_count'];
}
$stmt->close();

// Column Chart Data
$stmt = $conn->prepare("
    SELECT location, year, COUNT(*) AS car_count 
    FROM cars 
    GROUP BY location, year
    ORDER BY location, year
");
$stmt->execute();
$cars = $stmt->get_result();
$locations = [];
$years = [];
$data = [];
while ($row = $cars->fetch_assoc()) {
    $locations[] = $row['location'];
    $years[$row['year']] = true;
    $data[$row['location']][$row['year']] = $row['car_count'];
}
$years = array_keys($years);
$locations = array_unique($locations);
$series_data = [];
foreach ($years as $year) {
    $year_data = ['name' => (string)$year, 'data' => []];
    foreach ($locations as $location) {
        $year_data['data'][] = isset($data[$location][$year]) ? $data[$location][$year] : 0;
    }
    $series_data[] = $year_data;
}
$stmt->close();

// Line Chart Data
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
$months = [];
$car_counts = [];
while ($row = $result->fetch_assoc()) {
    $months[] = $row['month'];
    $car_counts[] = $row['car_count'];
}
$formatted_months = array_map(function($month) {
    $date = DateTime::createFromFormat('Y-m', $month);
    return $date->format('F Y');
}, $months);
$stmt->close();

// Donut Chart Data
$stmt = $conn->prepare("SELECT location, COUNT(*) AS car_count FROM cars GROUP BY location");
$stmt->execute();
$result = $stmt->get_result();
$donut_locations = [];
$donut_counts = [];
while ($row = $result->fetch_assoc()) {
    $donut_locations[] = $row['location'];
    $donut_counts[] = $row['car_count'];
}
$conn->close();
?>

<!-- Chart.js: Pie Chart (Car Models) -->
<script>
    var ctxPie = document.getElementById('carPieChart').getContext('2d');
    var carPieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($models); ?>,
            datasets: [{
                data: <?php echo json_encode($counts); ?>,
                backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A6', '#FFC300', '#DAF7A6', '#581845'],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: { position: 'top' },
                tooltip: { callbacks: { label: (tooltipItem) => tooltipItem.label + ': ' + tooltipItem.raw + ' cars' } }
            }
        }
    });
</script>

<!-- Highcharts: Column Chart -->
<script>
    Highcharts.chart('carColumnChart', {
        chart: { type: 'column' },
        title: { text: '' },
        xAxis: { categories: <?php echo json_encode($locations); ?> },
        yAxis: { title: { text: 'Number of Cars' } },
        series: <?php echo json_encode($series_data); ?>,
        plotOptions: { column: { stacking: 'normal' } },
        legend: { reversed: true }
    });
</script>

<!-- Chart.js: Line Chart (Car Availability) -->
<script>
    var ctxLine = document.getElementById('availabilityLineChart').getContext('2d');
    var availabilityLineChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($formatted_months); ?>,
            datasets: [{
                label: 'Car Availability Over Time',
                data: <?php echo json_encode($car_counts); ?>,
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: { title: { display: true, text: 'Month and Year' } },
                y: { title: { display: true, text: 'Number of Cars' }, beginAtZero: true }
            }
        }
    });
</script>

<!-- Chart.js: Donut Chart -->
<script>
    var ctxDonut = document.getElementById('carDonutChart').getContext('2d');
    var carDonutChart = new Chart(ctxDonut, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($donut_locations); ?>,
            datasets: [{
                data: <?php echo json_encode($donut_counts); ?>,
                backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A6'],
                borderWidth: 1
            }]
        }
    });
</script>

<?php include "view-footer.php"; ?>
