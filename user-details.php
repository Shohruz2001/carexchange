<?php
require_once("util-db.php");

function getUserDetails($user_id) {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        return $result->fetch_assoc();
    } catch (Exception $e) {
        $conn->close();
        throw $e;
    }
}

function getUserTrips($user_id) {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT * FROM trips WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
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
    $user = getUserDetails($_GET['id']);
    $trips = getUserTrips($_GET['id']);
} else {
    echo "User ID not provided!";
    exit;
}

$pageTitle = "User Details";
include "view-header.php";
?>

<h1>User Details</h1>
<p>Username: <?php echo $user['username']; ?></p>
<p>Email: <?php echo $user['email']; ?></p>
<p>Contact Info: <?php echo $user['contact_info']; ?></p>

<h2>Trips by this User</h2>
<table class="table">
    <thead>
        <tr>
           <!-- <th>Trip ID</th> -->
            <th>Destination</th>
            <th>Departure City</th>
            <th>Departure Date</th>
            <th>Return Date</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($trip = $trips->fetch_assoc()) { ?>
        <tr>
            <!-- <td><?php echo $trip['trip_id']; ?></td> -->
            <td><?php echo $trip['destination']; ?></td>
            <td><?php echo $trip['departure_city']; ?></td>
            <td><?php echo $trip['departure_date']; ?></td>
            <td><?php echo $trip['return_date']; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php include "view-footer.php"; ?>
