<!-- lib2.php -->
<?php
require_once('util-db.php');  // Include the database connection
$pageTitle = "Column Chart: Car Data by Location and Year";
include "view-header.php";  // Include the header for the page

// Fetch car data by location and year
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

// Prepare the years list and data
$years = array_keys($years);  // Extract unique years
$locations = array_unique($locations);  // Remove duplicates from locations
?>

<h1>Lib2: Column Chart using Plotly.js</h1>
<p>This page uses Plotly.js to display a column chart comparing car counts by location and year.</p>

<div id="carColumnChart" style="width:100%; height: 400px;"></div>

<script src="https://cdn.jsdelivr.net/npm/plotly.js"></script>
<script>
    var locations = <?php echo json_encode($locations); ?>;
    var years = <?php echo json_encode($years); ?>;
    var data = <?php echo json_encode($data); ?>;

    // Prepare data for the plot
    var traces = [];

    // Generate a trace for each year
    years.forEach(function(year) {
        var trace = {
            x: locations,
            y: locations.map(function(location) { return data[location][year] || 0; }),
            type: 'bar',
            name: year
        };
        traces.push(trace);
    });

    // Layout for the column chart
    var layout = {
        barmode: 'group',  // Bars grouped together for each location
        title: 'Car Count by Location and Year',
        xaxis: {
            title: 'Location',
            tickmode: 'array',
            tickvals: locations,
        },
        yaxis: {
            title: 'Number of Cars',
            tickformat: 'd',  // Format y-axis as integer (no decimals)
            rangemode: 'tozero'
        }
    };

    // Create the chart
    Plotly.newPlot('carColumnChart', traces, layout);
</script>

<?php include "view-footer.php"; ?>
