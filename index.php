<?php  
$pageTitle = "Home";
include "view-header.php"; 
?>

<div class="container mt-5">
    <!-- Homepage Title -->
    <h1 class="text-center display-4 text-warning mb-4">Welcome to the Car Exchange Platform</h1>
    <p class="text-center lead text-light">
        Discover a smarter way to explore new cities and share your car! With our platform, you can earn points by sharing your car and find available vehicles for your next trip.
    </p>

    <!-- Advertisement Section -->
    <div class="bg-dark p-4 rounded mt-5">
        <h2 class="text-center text-light mb-3">Why Choose Us?</h2>
        <p class="text-center text-white-50 fs-5">
            Are you tired of working all week and want to visit a new city for the weekend? Don't have your car with you and don't want to pay high car rental fees? 
            <span class="text-warning">Register your car on our website</span>, earn points, and check out available cars for your next trip. Travel smarter, save more, and explore better with the Care Exchange Platform!
        </p>
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

<!-- Updated JavaScript for Charts -->
<script>
    // Pie Chart
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
                title: {
                    display: true,
                    text: 'Car Models Distribution',
                    color: '#FFFFFF',
                    font: {
                        size: 16,
                        family: 'Arial'
                    }
                },
                legend: {
                    labels: {
                        color: '#FFFFFF',
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });

    // Column Chart
    Highcharts.chart('carColumnChart', {
        chart: { type: 'column', backgroundColor: 'transparent' },
        title: { text: 'Car Count by Location and Year', style: { color: '#FFFFFF', fontSize: '16px' } },
        xAxis: { 
            categories: <?php echo json_encode(array_values($locations)); ?>, 
            title: { text: 'Locations', style: { color: '#FFFFFF' } },
            labels: { style: { color: '#FFFFFF' } }
        },
        yAxis: { 
            title: { text: 'Number of Cars', style: { color: '#FFFFFF' } },
            labels: { style: { color: '#FFFFFF' } }
        },
        series: <?php echo json_encode($series_data); ?>,
        legend: {
            itemStyle: { color: '#FFFFFF' }
        }
    });

    // Line Chart
    var ctxLine = document.getElementById('availabilityLineChart').getContext('2d');
    new Chart(ctxLine, {
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
            plugins: {
                title: {
                    display: true,
                    text: 'Car Availability Over Time',
                    color: '#FFFFFF',
                    font: { size: 16 }
                }
            },
            scales: { 
                x: { 
                    title: { display: true, text: 'Months', color: '#FFFFFF' },
                    ticks: { color: '#FFFFFF' }
                },
                y: { 
                    title: { display: true, text: 'Number of Cars', color: '#FFFFFF' },
                    ticks: { color: '#FFFFFF' }
                }
            }
        }
    });

    // Donut Chart
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
                title: {
                    display: true,
                    text: 'Car Distribution by Location',
                    color: '#FFFFFF',
                    font: {
                        size: 16
                    }
                },
                legend: {
                    labels: {
                        color: '#FFFFFF',
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });
</script>

<?php include "view-footer.php"; ?>
