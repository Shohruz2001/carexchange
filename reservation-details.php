<?php
require_once("util-db.php");

function getReservationDetails($reservation_id) {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT * FROM reservations WHERE reservation_id = ?");
        $stmt->bind_param("i", $reservation_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        return $result->fetch_assoc();
    } catch (Exception $e) {
        $conn->close();
        throw $e;
    }
}

// Fetch trip and car details related to this reservation
function getTripByReservation($trip_id) {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT * FROM trips WHERE trip_id = ?");
        $stmt->bind_param("i", $trip_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        return $result->fetch_assoc();
    } catch (Exception $e) {
        $conn->close();
        throw $e;
    }
}

function getCarByReservation($car_id) {
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

if (isset($_GET['id'])) {
    $reservation = getReservationDetails($_GET['id']);
    $trip = getTripByReservation($reservation['trip_id']);
    $car = getCarByReservation($reservation['car_id']);
} else {
    echo "Reservation ID not provided!";
    exit;
}

$pageTitle = "Reservation Details";
include "view-header.php";
?>

<h1>Reservation Details</h1>
<p>Start Date: <?php echo $reservation['start_date']; ?></p>
<p>End Date: <?php echo $reservation['end_date']; ?></p>
<p>Status: <?php echo $reservation['status']; ?></p>

<h2>Related Trip</h2>
<p>Destination: <?php echo $trip['destination']; ?></p>
<p>Departure City: <?php echo $trip['departure_city']; ?></p>
<p>Departure Date: <?php echo $trip['departure_date']; ?></p>
<p>Return Date: <?php echo $trip['return_date']; ?></p>

<h2>Related Car</h2>
<p>Make: <?php echo $car['make']; ?></p>
<p>Model: <?php echo $car['model']; ?></p>
<p>Year: <?php echo $car['year']; ?></p>
<p>License Plate: <?php echo $car['license_plate']; ?></p>

<?php include "view-footer.php"; ?>
