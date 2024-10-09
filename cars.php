<?php
require_once("util-db.php");
require_once("model-cars.php");

$pageTitle = "Cars";
include "view-header.php";

// Handling GET requests for filtering by location
if (isset($_GET['location'])) {
    $location = $_GET['location'];
    $conn = get_db_connection();
    $stmt = $conn->prepare("SELECT * FROM cars WHERE location = ?");
    $stmt->bind_param("s", $location);
    $stmt->execute();
    $cars = $stmt->get_result();
    $conn->close();
}
// Handling POST requests for filtering by year
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['year'])) {
    $year = $_POST['year'];
    $conn = get_db_connection();
    $stmt = $conn->prepare("SELECT * FROM cars WHERE year = ?");
    $stmt->bind_param("i", $year);
    $stmt->execute();
    $cars = $stmt->get_result();
    $conn->close();
}
// Display all cars by default
else {
    $cars = selectCars();
}
?>

<h1>Filter Cars</h1>

<!-- Form for filtering by year (POST method) -->
<form method="POST" action="cars.php">
    <label for="year">Filter by Year:</label>
    <input type="number" id="year" name="year" />
    <button type="submit">Filter</button>
</form>

<!-- Links for filtering by location (GET method) -->
<p>Filter by Location:</p>
<ul>
    <li><a href="cars.php?location=Los Angeles">Los Angeles</a></li>
    <li><a href="cars.php?location=New York">New York</a></li>
    <li><a href="cars.php?location=Chicago">Chicago</a></li>
    <li><a href="cars.php?location=Houston">Houston</a></li>
    <li><a href="cars.php">Clear Filter</a></li>
</ul>

<?php
// Display the cars in the table
include "view-cars.php";
include "view-footer.php";
?>
