<?php
require_once("util-db.php");
session_start(); // Start session to handle messages

function getUserOptions($selected_user_id) {
    $conn = get_db_connection();
    $sql = "SELECT user_id, username FROM users";
    $result = $conn->query($sql);
    $options = "";
    while ($row = $result->fetch_assoc()) {
        $selected = ($row['user_id'] == $selected_user_id) ? "selected" : "";
        $options .= "<option value='{$row['user_id']}' $selected>{$row['username']}</option>";
    }
    $conn->close();
    return $options;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trip_id = $_POST['trip_id'];
    $user_id = $_POST['user_id'];
    $destination = $_POST['destination'];
    $departure_city = $_POST['departure_city'];
    $departure_date = $_POST['departure_date'];
    $return_date = $_POST['return_date'];

    $conn = get_db_connection();
    $stmt = $conn->prepare("UPDATE trips SET user_id = ?, destination = ?, departure_city = ?, departure_date = ?, return_date = ? WHERE trip_id = ?");
    $stmt->bind_param("issssi", $user_id, $destination, $departure_city, $departure_date, $return_date, $trip_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Trip updated successfully!";
    } else {
        $_SESSION['message'] = "Error updating trip: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    header("Location: trips.php");
    exit();
}

if (isset($_GET['id'])) {
    $trip_id = $_GET['id'];
    $conn = get_db_connection();
    $stmt = $conn->prepare("SELECT * FROM trips WHERE trip_id = ?");
    $stmt->bind_param("i", $trip_id);
    $stmt->execute();
    $trip = $stmt->get_result()->fetch_assoc();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Trip</title>
</head>
<body>
    <h1>Edit Trip</h1>
    <?php if (isset($_SESSION['message'])): ?>
    <script>alert('<?php echo $_SESSION['message']; ?>');</script>
    <?php unset($_SESSION['message']); endif; ?>
    <form action="edit-trip.php" method="POST">
        <input type="hidden" name="trip_id" value="<?php echo $trip['trip_id']; ?>">

        <label for="user_id">User:</label>
        <select name="user_id" id="user_id" required><?php echo getUserOptions($trip['user_id']); ?></select><br>

        <label for="destination">Destination:</label>
        <input type="text" name="destination" id="destination" value="<?php echo $trip['destination']; ?>" required><br>

        <label for="departure_city">Departure City:</label>
        <input type="text" name="departure_city" id="departure_city" value="<?php echo $trip['departure_city']; ?>" required><br>

        <label for="departure_date">Departure Date:</label>
        <input type="date" name="departure_date" id="departure_date" value="<?php echo $trip['departure_date']; ?>" required><br>

        <label for="return_date">Return Date:</label>
        <input type="date" name="return_date" id="return_date" value="<?php echo $trip['return_date']; ?>" required><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
