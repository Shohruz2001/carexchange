<!-- lib2.php -->
<?php
require_once('util-db.php');  // Include the database connection
$pageTitle = "Stacked Column Chart: Car Data by Location and Year";
include "view-header.php";  // Include the header for the page

// Fetch car data grouped by location and year
$conn = get_db_connection();
$stmt = $conn->prepare("
    SELECT location, year, COUNT(*) AS car_count 
    FROM cars 
    GROUP BY location, year
    ORDER BY location, year
");
$stmt->execute();
$cars = $stmt->get_result();
$conn->close();

$locations = [];
$years = [];
$data = [];

while ($row = $cars->fetch_assoc()) {
    $locations[] = $row['location'];
    $years[$row['year']] = true;  // Keep track of unique years
    $data[$row['location']][$row['year']] = $row['car_count'];
}

// Prepare the years list and data for Highcharts
$years = array_keys($years);  // Extract unique years
$locations = array_unique($locations);  // Remove duplicates from locations

// Prepare data for the Highcharts chart
$series_data = [];
foreach ($years as $year) {
    $year_data = [
        'name' => (string)$year,  // Set the year as the name of the series
        'data' => []
    ];
    foreach ($locations as $location) {
        $year_data['data'][] = isset($data[$location][$year]) ? $data[$location][$year] : 0;
    }
    $series_data[] = $year_data;
}
?>

<h1>Lib2: Stacked Column Chart using Highcharts.js</h1>
<p>This page uses Highcharts.js to display a stacked column chart comparing car counts by location and year.</p>

<div id="carColumnChart" style="width:100%; height: 400px;"></div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    // Debugging: Check if the locations and data are correctly passed to JavaScript
    console.log('Locations:', <?php echo json_encode($locations); ?>);  // Locations should be unique names
    console.log('Years:', <?php echo json_encode($years); ?>);  // List of years
    console.log('Series Data:', <?php echo json_encode($series_data); ?>);  // Data for each year

    // Prepare data for the Highcharts chart
    var chartData = <?php echo json_encode($series_data); ?>; // Data passed from PHP

    Highcharts.chart('carColumnChart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Car Count by Location and Year'
        },
        xAxis: {
            categories: <?php echo json_encode($locations); ?>,  // Locations for the x-axis (using actual names)
            title: {
                text: 'Location'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Number of Cars'
            }
        },
        legend: {
            reversed: true
        },
        tooltip: {
            pointFormat: '{series.name}: {point.y}<br>Total: {point.stackTotal}'
        },
        series: chartData,  // Data for each year
        plotOptions: {
            column: {
                stacking: 'normal'  // Enable stacking
            }
        }
    });
</script>

<?php include "view-footer.php"; ?>
