<?php
require_once("util-db.php");
require_once("model-reservations.php");

$pageTitle = "Reservations";
include "view-header.php";

// Fetch all reservations
$reservations = selectReservations();
?>

<h1>Reservations</h1>
<table class="table">
    <thead>
        <tr>
            <th>Reservation ID</th>
            <th>Trip ID</th>
            <th>Car ID</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php while ($reservation = $reservations->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $reservation['reservation_id']; ?></td>
            <td><?php echo $reservation['trip_id']; ?></td>
            <td><?php echo $reservation['car_id']; ?></td>
            <td><?php echo $reservation['start_date']; ?></td>
            <td><?php echo $reservation['end_date']; ?></td>
            <td><?php echo $reservation['status']; ?></td>
            <td><a href="reservation-details.php?id=<?php echo $reservation['reservation_id']; ?>">Details</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php include "view-footer.php"; ?>
