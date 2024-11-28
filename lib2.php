<!-- lib2.php -->
<?php
require_once('util-db.php');  // Include the database connection
$pageTitle = "Stacked Bar Chart: Car Data by Location and Year";
include "view-header.php";  // Include the header for the page

// Fetch car data by location and year
$conn = get_db_connection();
$stmt = $conn->prepare("SELECT location, year, COUNT(*) AS car_count FROM cars GROUP BY location, year");
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
?>

<h1>Lib2: Stacked Bar Chart using Chart.js</h1>
<p>This page uses Chart.js to display a stacked bar chart comparing car counts by location and year.</p>

<canvas id="barChart"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var locations = <?php echo json_encode($locations); ?>;
    var years = <?php echo json_encode($years); ?>;
    var data = <?php echo json_encode($data); ?>;

    var traces = [];

    years.forEach(function(year) {
        var trace = {
            x: locations,
            y: locations.map(function(location) { return data[location][year] || 0; }),
            type: 'bar',
            name: year
        };
        traces.push(trace);
    });

    var layout = {
        barmode: 'stack',
        title: 'Car Count by Location and Year',
        xaxis: { title: 'Location' },
        yaxis: { title: 'Number of Cars' }
    };

    Plotly.newPlot('barChart', traces, layout);
</script>

<?php include "view-footer.php"; ?>
