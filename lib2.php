<!-- lib2.php -->
<?php
require_once('util-db.php');  // Include the database connection
$pageTitle = "Column Chart: Car Data by Location and Year";
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

// Prepare the years list and data for Plotly.js
$years = array_keys($years);  // Extract unique years
$locations = array_unique($locations);  // Remove duplicates from locations

// Prepare data for the Plotly chart
$trace_data = [];

foreach ($years as $year) {
    $trace = [
        'x' => $locations,  // X-axis (locations)
        'y' => array_map(function($location) use ($year, $data) {
            return isset($data[$location][$year]) ? $data[$location][$year] : 0;
        }, $locations),
        'type' => 'bar',
        'name' => (string) $year  // Set the year as the name of the trace
    ];
    $trace_data[] = $trace;
}
?>

<h1>Lib2: Column Chart using Plotly.js</h1>
<p>This page uses Plotly.js to display a column chart comparing car counts by location and year.</p>

<div id="carColumnChart" style="width:100%; height: 400px;"></div>

<script src="https://cdn.jsdelivr.net/npm/plotly.js"></script>
<script>
    console.log('Locations:', <?php echo json_encode($locations); ?>);
    console.log('Years:', <?php echo json_encode($years); ?>);
    console.log('Trace Data:', <?php echo json_encode($trace_data); ?>);

    var data = <?php echo json_encode($trace_data); ?>;  // Data from PHP passed to JavaScript

    // Layout configuration for the Plotly chart
    var layout = {
        barmode: 'stack',  // Stacked bar mode
        title: 'Car Count by Location and Year',
        xaxis: {
            title: 'Location',
            tickmode: 'array',
            tickvals: <?php echo json_encode($locations); ?>  // Dynamic location labels
        },
        yaxis: {
            title: 'Number of Cars',
            rangemode: 'tozero',  // Ensure y-axis starts at 0
            tickformat: 'd'  // Format y-axis as integer
        }
    };

    // Create the Plotly chart
    Plotly.newPlot('carColumnChart', data, layout);
</script>

<?php include "view-footer.php"; ?>
