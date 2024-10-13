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

<h1 class="mt-4">Filter Cars</h1>

<!-- Form for filtering by year (POST method) -->
<div class="row mb-4">
    <div class="col-md-6">
        <form method="POST" action="cars.php" class="form-inline">
            <div class="mb-3">
                <label for="year" class="form-label">Filter by Year:</label>
                <input type="number" id="year" name="year" class="form-control" placeholder="Enter year" />
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>

    <!-- Links for filtering by location (GET method) -->
    <div class="col-md-6">
        <p>Filter by Location:</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="cars.php?location=Los Angeles" class="btn btn-outline-primary">Los Angeles</a></li>
            <li class="list-inline-item"><a href="cars.php?location=New York" class="btn btn-outline-primary">New York</a></li>
            <li class="list-inline-item"><a href="cars.php?location=Chicago" class="btn btn-outline-primary">Chicago</a></li>
            <li class="list-inline-item"><a href="cars.php?location=Houston" class="btn btn-outline-primary">Houston</a></li>
            <li class="list-inline-item"><a href="cars.php" class="btn btn-outline-secondary">Clear Filter</a></li>
        </ul>
    </div>
</div>

<!-- Display the cars in the table -->
<?php
include "view-cars.php";
include "view-footer.php";
?>
