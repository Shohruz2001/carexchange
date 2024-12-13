<?php
require_once("util-db.php");
require_once("model-reservations.php");

session_start(); // Start session to handle messages

$pageTitle = "Reservations";
include "view-header.php";

// Fetch all reservations
$reservations = selectReservations();
?>

<h1>Reservations</h1>

<!-- Session Message for Add/Edit/Delete -->
<?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php } ?>

<!-- Add Reservation Button -->
<a href="add-reservation.php" class="btn btn-success mb-3">Add New Reservation</a>

<table class="table table-bordered" style="table-layout: fixed; border-spacing: 0 10px;"> <!-- Added border-spacing -->
    <thead>
        <tr>
            <!-- Reservation data excluding Reservation ID, Trip ID, and Car ID -->
            <th style="padding: 10px;">Start Date</th> <!-- Added padding -->
            <th style="padding: 10px;">End Date</th> <!-- Added padding -->
            <th style="padding: 10px;">Status</th> <!-- Added padding -->
            <th style="padding: 10px;">Actions</th> <!-- Added padding -->
        </tr>
    </thead>
    <tbody>
    <?php while ($reservation = $reservations->fetch_assoc()) { ?>
        <tr>
            <td style="padding: 10px;"><?php echo $reservation['start_date']; ?></td>
            <td style="padding: 10px;"><?php echo $reservation['end_date']; ?></td>
            <td style="padding: 10px;"><?php echo $reservation['status']; ?></td>
            <td style="padding: 10px;">
                <!-- Action buttons for Edit, Delete, and Details -->
                <a href="edit-reservation.php?id=<?php echo $reservation['reservation_id']; ?>" class="btn btn-primary">Edit</a>

                <!-- Delete form with confirmation prompt -->
                <form action="delete-reservation.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                    <input type="hidden" name="reservation_id" value="<?php echo $reservation['reservation_id']; ?>">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>

                <!-- Details link -->
                <a href="reservation-details.php?id=<?php echo $reservation['reservation_id']; ?>" class="btn btn-info">Details</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php include "view-footer.php"; ?>
