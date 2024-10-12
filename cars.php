<?php
require_once("util-db.php");
require_once("model-cars.php");

$pageTitle = "Cars";
include "view-header.php";
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

<?php
// Display the cars in the table
include "view-cars.php";
include "view-footer.php";
?>
