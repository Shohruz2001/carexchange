<?php
require_once("util-db.php");

function getTripDetails($trip_id) {
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

// Fetch reservations associated with the trip
function getTripReservations($trip_id) {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT * FROM reservations WHERE trip_id = ?");
        $stmt->bind_param("i", $trip_id);
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
    $trip = getTripDetails($_GET['id']);
    $reservations = getTripReservations($_GET['id']);
} else {
    echo "Trip ID not provided!";
    exit;
}

$pageTitle = "Trip Details";
include "view-header.php";
?>

<h1>Trip Details</h1>
<p>Destination: <?php echo $trip['destination']; ?></p>
<p>Departure City: <?php echo $trip['departure_city']; ?></p>
<p>Departure Date: <?php echo $trip['departure_date']; ?></p>
<p>Return Date: <?php echo $trip['return_date']; ?></p>

<h2>Reservations for this trip</h2>
<table class="table">
    <thead>
        <tr>
            <th>Reservation ID</th>
            <th>Car ID</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($reservation = $reservations->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $reservation['reservation_id']; ?></td>
            <td><?php echo $reservation['car_id']; ?></td>
            <td><?php echo $reservation['start_date']; ?></td>
            <td><?php echo $reservation['end_date']; ?></td>
            <td><?php echo $reservation['status']; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php include "view-footer.php"; ?>
