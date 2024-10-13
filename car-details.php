<?php
require_once("util-db.php");

// Fetch car details and related reservations
function getCarDetails($car_id) {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT * FROM cars WHERE car_id = ?");
        $stmt->bind_param("i", $car_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        return $result->fetch_assoc();
    } catch (Exception $e) {
        $conn->close();
        throw $e;
    }
}

// Fetch reservations associated with the car
function getCarReservations($car_id) {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT * FROM reservations WHERE car_id = ?");
        $stmt->bind_param("i", $car_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        return $result;
    } catch (Exception $e) {
        $conn->close();
        throw $e;
    }
}

if (isset($_GET['id'])) {
    $car = getCarDetails($_GET['id']);
    $reservations = getCarReservations($_GET['id']);
} else {
    echo "Car ID not provided!";
    exit;
}

$pageTitle = "Car Details";
include "view-header.php";
?>

<h1>Car Details</h1>
<p>Make: <?php echo $car['make']; ?></p>
<p>Model: <?php echo $car['model']; ?></p>
<p>Year: <?php echo $car['year']; ?></p>
<p>License Plate: <?php echo $car['license_plate']; ?></p>
<p>Location: <?php echo $car['location']; ?></p>
<p>Availability: <?php echo $car['availability_start']; ?> to <?php echo $car['availability_end']; ?></p>

<h2>Reservations for this car</h2>
<table class="table">
    <thead>
        <tr>
            <th>Reservation ID</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($reservation = $reservations->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $reservation['reservation_id']; ?></td>
            <td><?php echo $reservation['start_date']; ?></td>
            <td><?php echo $reservation['end_date']; ?></td>
            <td><?php echo $reservation['status']; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php include "view-footer.php"; ?>
