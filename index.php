<?php 
$pageTitle = "Home";
include "view-header.php"; 
?>

<div class="container mt-5">
    <!-- Homepage Title -->
    <h1 class="text-center">Welcome to the Care Exchange Platform</h1>
    <p class="text-center mt-3">Explore our platform with insights into car availability, usage trends, and more. Below, you will find interactive visualizations to help you understand key data points.</p>

    <!-- Row for Charts -->
    <div class="row mt-5">
        <!-- Pie Chart: Car Models -->
        <div class="col-md-6 mb-4">
            <h3 class="text-center">Car Models Distribution</h3>
            <p class="text-center">View the breakdown of car models across our platform.</p>
            <canvas id="carPieChart" style="max-height: 300px;"></canvas>
        </div>

        <!-- Column Chart: Car Count By Location and Year -->
        <div class="col-md-6 mb-4">
            <h3 class="text-center">Car Count by Location and Year</h3>
            <p class="text-center">Compare car counts across different locations and years.</p>
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
            <p class="text-center">Explore the distribution of cars across locations.</p>
            <canvas id="carDonutChart" style="max-height: 300px;"></canvas>
        </div>
    </div>
</div>

<!-- JavaScript for all charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>

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
            labels: <?php echo json_encode($locations); ?>,
            datasets: [{
                data: <?php echo json_encode($counts); ?>,
                backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A6'],
                borderWidth: 1
            }]
        }
    });
</script>

<?php include "view-footer.php"; ?>
