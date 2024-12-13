<?php
require_once("util-db.php");
session_start(); // Start session to handle messages

function getTripOptions($selected_trip_id) {
    $conn = get_db_connection();
    $sql = "SELECT trip_id, destination FROM trips";
    $result = $conn->query($sql);
    $options = "";
    while ($row = $result->fetch_assoc()) {
        $selected = ($row['trip_id'] == $selected_trip_id) ? "selected" : "";
        $options .= "<option value='{$row['trip_id']}' $selected>{$row['destination']}</option>";
    }
    $conn->close();
    return $options;
}

function getCarOptions($selected_car_id) {
    $conn = get_db_connection();
    $sql = "SELECT car_id, make, model FROM cars";
    $result = $conn->query($sql);
    $options = "";
    while ($row = $result->fetch_assoc()) {
        $selected = ($row['car_id'] == $selected_car_id) ? "selected" : "";
        $options .= "<option value='{$row['car_id']}' $selected>{$row['make']} {$row['model']}</option>";
    }
    $conn->close();
    return $options;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservation_id = $_POST['reservation_id'];
    $trip_id = $_POST['trip_id'];
    $car_id = $_POST['car_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];

    $conn = get_db_connection();
    $stmt = $conn->prepare("UPDATE reservations SET trip_id = ?, car_id = ?, start_date = ?, end_date = ?, status = ? WHERE reservation_id = ?");
    $stmt->bind_param("iisssi", $trip_id, $car_id, $start_date, $end_date, $status, $reservation_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Reservation updated successfully!";
    } else {
        $_SESSION['message'] = "Error updating reservation: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    header("Location: reservations.php");
    exit();
}

if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];
    $conn = get_db_connection();
    $stmt = $conn->prepare("SELECT * FROM reservations WHERE reservation_id = ?");
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();
    $reservation = $stmt->get_result()->fetch_assoc();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>
</head>
<body>
    <h1>Edit Reservation</h1>
    <?php if (isset($_SESSION['message'])): ?>
    <script>alert('<?php echo $_SESSION['message']; ?>');</script>
    <?php unset($_SESSION['message']); endif; ?>
    <form action="edit-reservation.php" method="POST">
        <input type="hidden" name="reservation_id" value="<?php echo $reservation['reservation_id']; ?>">

        <label for="trip_id">Trip:</label>
        <select name="trip_id" id="trip_id" required><?php echo getTripOptions($reservation['trip_id']); ?></select><br>

        <label for="car_id">Car:</label>
        <select name="car_id" id="car_id" required><?php echo getCarOptions($reservation['car_id']); ?></select><br>

        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" value="<?php echo $reservation['start_date']; ?>" required><br>

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" value="<?php echo $reservation['end_date']; ?>" required><br>

        <label for="status">Status:</label>
        <input type="text" name="status" id="status" value="<?php echo $reservation['status']; ?>" required><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
