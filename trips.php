<?php
require_once("util-db.php");
require_once("model-trips.php");

$pageTitle = "Trips";
include "view-header.php";

// Fetch all trips
$trips = selectTrips();
?>

<h1>Trips</h1>
<table class="table">
    <thead>
        <tr>
           <!-- <th>Trip ID</th> -->
            <!-- <th>User ID</th> -->
            <th>Destination</th>
            <th>Departure City</th>
            <th>Departure Date</th>
            <th>Return Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php while ($trip = $trips->fetch_assoc()) { ?>
        <tr>
            <!-- <td><?php echo $trip['trip_id']; ?></td> -->
            <!-- <td><?php echo $trip['user_id']; ?></td> -->
            <td><?php echo $trip['destination']; ?></td>
            <td><?php echo $trip['departure_city']; ?></td>
            <td><?php echo $trip['departure_date']; ?></td>
            <td><?php echo $trip['return_date']; ?></td>
            <td><a href="trip-details.php?id=<?php echo $trip['trip_id']; ?>">Details</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php include "view-footer.php"; ?>
