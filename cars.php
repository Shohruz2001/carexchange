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

// Function to get reservations for each car
function getCarReservations($car_id) {
    $conn = get_db_connection();
    $stmt = $conn->prepare("SELECT * FROM reservations WHERE car_id = ?");
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close();
    return $result;
}
?>

<h1 class="mt-4">Filter Cars</h1>

<!-- Session Message for Add/Edit/Delete -->
<?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php } ?>

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

<!-- Add Car Button -->
<a href="add-car.php" class="btn btn-success mb-3">Add New Car</a>

<!-- Display the cars in the table -->
<table class="table table-bordered" style="table-layout: fixed;">
    <thead>
        <tr>
            <!-- Remove ID and Owner ID columns -->
            <th>Make</th>
            <th>Model</th>
            <th>Year</th>
            <th>License Plate</th>
            <th>Location</th>
            <th>Availability Start</th>
            <th>Availability End</th>
            <th>Reservations</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($car = $cars->fetch_assoc()) { ?>
        <tr>
            <!-- Remove ID and Owner ID data -->
            <td><?php echo $car['make']; ?></td>
            <td><?php echo $car['model']; ?></td>
            <td><?php echo $car['year']; ?></td>
            <td><?php echo $car['license_plate']; ?></td>
            <td><?php echo $car['location']; ?></td>
            <td><?php echo $car['availability_start']; ?></td>
            <td><?php echo $car['availability_end']; ?></td>
            <td>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $reservations = getCarReservations($car['car_id']);
                    if ($reservations->num_rows > 0) {
                        while ($reservation = $reservations->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $reservation['start_date']; ?></td>
                            <td><?php echo $reservation['end_date']; ?></td>
                            <td><?php echo $reservation['status']; ?></td>
                        </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='3'>No reservations</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </td>
            <td>
                <!-- Action buttons for Edit and Delete -->
                <a href="edit-car.php?id=<?php echo $car['car_id']; ?>" class="btn btn-primary">Edit</a>
                
                <form action="delete-car.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this car along with all associated reservations?');">
                       <input type="hidden" name="car_id" value="<?php echo $car['car_id']; ?>">
                       <button type="submit" class="btn btn-danger">Delete</button>
                </form>


            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php
include "view-footer.php";
?>
