<?php  
$pageTitle = "Home";
include "view-header.php"; 
?>

<div class="container mt-5">
    <!-- Homepage Title -->
    <h1 class="text-center display-2 text-warning fw-bold mb-5" style="text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);">
        Welcome to the Car Exchange Platform
    </h1>
    <p class="text-center lead text-light fs-3" style="max-width: 900px; margin: 0 auto; line-height: 2.2; font-weight: 500;">
        Discover a smarter way to explore new cities and share your car! With our platform, you can earn points by sharing your car and find available vehicles for your next trip.
    </p>

    <!-- Advertisement Section -->
    <div class="bg-dark p-5 rounded mt-5" style="box-shadow: 0 10px 20px rgba(0, 0, 0, 0.6);">
        <h2 class="text-center text-light fw-bold mb-4" style="font-size: 3.5rem; text-shadow: 2px 2px 5px rgba(255, 215, 0, 0.8);">
            Why Choose Us?
        </h2>
        <p class="text-center text-white fs-3" style="max-width: 850px; margin: 0 auto; line-height: 2.5;">
            Are you tired of working all week and want to visit a new city for the weekend? Don't have your car with you and don't want to pay high car rental fees? 
            <span class="text-warning fw-bold">Register your car on our website</span>, earn points, and check out available cars for your next trip. Travel smarter, save more, and explore better with the Car Exchange Platform!
        </p>
    </div>

    <!-- Add Space at the Bottom -->
    <div class="mt-5" style="height: 80px;"></div>
</div>


    <!-- Row for Charts -->
    <div class="row mt-5">
        <!-- Pie Chart: Car Models -->
        <div class="col-md-6 mb-4">
            <h3 class="text-center text-light">Car Models Distribution</h3>
            <p class="text-center text-light">A breakdown of car models in our system.</p>
            <canvas id="carPieChart" style="max-height: 400px;"></canvas>
        </div>

        <!-- Column Chart: Car Count By Location and Year -->
        <div class="col-md-6 mb-4">
            <h3 class="text-center text-light">Car Count by Location and Year</h3>
            <p class="text-center text-light">Compare car counts across various locations and years.</p>
            <div id="carColumnChart" style="height: 400px;"></div>
        </div>
    </div>

    <div class="row">
        <!-- Line Chart: Car Availability -->
        <div class="col-md-6 mb-4">
            <h3 class="text-center text-light">Car Availability Over Time</h3>
            <p class="text-center text-light">Track monthly trends in car availability.</p>
            <canvas id="availabilityLineChart" style="max-height: 400px;"></canvas>
        </div>

        <!-- Donut Chart: Distribution of Cars by Location -->
        <div class="col-md-6 mb-4">
            <h3 class="text-center text-light">Car Distribution by Location</h3>
            <p class="text-center text-light">Explore the distribution of cars across different locations.</p>
            <canvas id="carDonutChart" style="max-height: 400px;"></canvas>
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

<!-- Chart.js: Pie Chart -->
<script>
    var ctxPie = document.getElementById('carPieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($models); ?>,
            datasets: [{
                data: <?php echo json_encode($counts); ?>,
                backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A6', '#FFC300', '#DAF7A6', '#581845']
            }]
        },
       options: {
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: '#FFD700', 
                    font: {
                        size: 14, 
                        weight: 'bold' 
                    },
                    boxWidth: 20, 
                    padding: 10 
                }
            },
            title: {
                display: true,
                text: 'Car Models Distribution',
                font: {
                        size: 24},
                color: '#FFD700' 
            }
        }
    }
    });
</script>

<!-- Highcharts: Column Chart -->
<script>
    Highcharts.chart('carColumnChart', {
        chart: { type: 'column' },
        title: { text: 'Car Count by Location and Year', color: '#FFD700' },
        xAxis: { 
            categories: <?php echo json_encode(array_values($locations)); ?>, 
            title: { text: 'Locations', color: '#FFD700' }
        },
        yAxis: { 
            title: { text: 'Number of Cars', color: '#FFD700' } 
        },
        series: <?php echo json_encode($series_data); ?>, 
        plotOptions: { 
            column: { stacking: 'normal' } 
        },
        legend: { 
            layout: 'horizontal', 
            align: 'center', 
            verticalAlign: 'bottom',
            color: '#FFD700'
        }
    });
</script>


<!-- Chart.js: Line Chart -->
<script>
    var ctxLine = document.getElementById('availabilityLineChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($formatted_months); ?>,
            datasets: [{
                label: 'Car Availability Over Time', color: '#FFD700',
                data: <?php echo json_encode($car_counts); ?>,
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                fill: true
            }]
        },
        options: { 
        scales: { 
            x: { 
                title: { 
                    display: true, 
                    text: 'Months', 
                    color: '#FFD700'
                }
            },
            y: { 
                title: { 
                    display: true, 
                    text: 'Number of Cars', 
                    color: '#FFD700' 
                }
            }
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: '#FFD700', 
                    font: {
                        size: 14, 
                        weight: 'bold' 
                    },
                    boxWidth: 20,
                    padding: 10 
                }
            },
        }
    }
    });
</script>

<!-- Chart.js: Donut Chart -->
<script>
    var ctxDonut = document.getElementById('carDonutChart').getContext('2d');
    new Chart(ctxDonut, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($donut_locations); ?>,
            datasets: [{
                data: <?php echo json_encode($donut_counts); ?>,
                backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A6']
            }]
        },
       options: {
        plugins: {
            legend: { 
                position: 'top',
                labels: {
                    color: '#FFD700', // Highlight legend text with golden color
                    font: {
                        size: 14, // Increase font size for better visibility
                        weight: 'bold' // Make text bold
                    },
                    boxWidth: 20, // Adjust the size of the color box
                    padding: 10 // Add spacing between legend items
                }
            },
            title: {
                display: true,
                text: 'Car Distribution by Location',
                color: '#FFD700', // Highlight title with golden color
                font: {
                    size: 24, // Increase font size for emphasis
                    weight: 'bold' // Make the title bold
                }
            }
        }
    }
    });
</script>

<?php include "view-footer.php"; ?>
