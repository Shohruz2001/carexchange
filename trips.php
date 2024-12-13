<?php
require_once("util-db.php");
require_once("model-trips.php");

session_start(); // Start session to handle messages

$pageTitle = "Trips";
include "view-header.php";

// Fetch all trips
$trips = selectTrips();
?>

<h1>Trips</h1>

<!-- Session Message for Add/Edit/Delete -->
<?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php } ?>

<!-- Add Trip Button -->
<a href="add-trip.php" class="btn btn-success mb-3">Add New Trip</a>

<table class="table table-bordered" style="table-layout: fixed;">
    <thead>
        <tr style="font-size: 1.5rem; font-weight: bold;"> <!-- Added font size and weight -->
            <!-- Remove Trip ID and User ID columns -->
            <th>Destination</th>
            <th>Departure City</th>
            <th>Departure Date</th>
            <th>Return Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($trip = $trips->fetch_assoc()) { ?>
        <tr>
            <!-- Display trip information -->
            <td><?php echo $trip['destination']; ?></td>
            <td><?php echo $trip['departure_city']; ?></td>
            <td><?php echo $trip['departure_date']; ?></td>
            <td><?php echo $trip['return_date']; ?></td>
            <td>
                <!-- Action buttons for Edit, Delete, and Details -->
                <a href="edit-trip.php?id=<?php echo $trip['trip_id']; ?>" class="btn btn-primary">Edit</a>
                
                <!-- Delete form with confirmation prompt -->
                <form action="delete-trip.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this trip along with all associated reservations?');">
                    <input type="hidden" name="trip_id" value="<?php echo $trip['trip_id']; ?>">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>

                <!-- Details link -->
                <a href="trip-details.php?id=<?php echo $trip['trip_id']; ?>" class="btn btn-info">Details</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>


<?php include "view-footer.php"; ?>
