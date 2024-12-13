<?php
require_once("util-db.php");
session_start(); // Start session to handle messages

// Fetch options for trips and cars
function getTripOptions() {
    $conn = get_db_connection();
    $sql = "SELECT trip_id, destination FROM trips";
    $result = $conn->query($sql);
    $options = "";
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='{$row['trip_id']}'>{$row['destination']}</option>";
    }
    $conn->close();
    return $options;
}

function getCarOptions() {
    $conn = get_db_connection();
    $sql = "SELECT car_id, make, model FROM cars";
    $result = $conn->query($sql);
    $options = "";
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='{$row['car_id']}'>{$row['make']} {$row['model']}</option>";
    }
    $conn->close();
    return $options;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trip_id = $_POST['trip_id'];
    $car_id = $_POST['car_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];

    $conn = get_db_connection();
    $stmt = $conn->prepare("INSERT INTO reservations (trip_id, car_id, start_date, end_date, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $trip_id, $car_id, $start_date, $end_date, $status);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Reservation added successfully!";
    } else {
        $_SESSION['message'] = "Error adding reservation: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    header("Location: reservations.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Reservation</title>
</head>
<body>
    <h1>Add New Reservation</h1>
    <?php if (isset($_SESSION['message'])): ?>
    <script>alert('<?php echo $_SESSION['message']; ?>');</script>
    <?php unset($_SESSION['message']); endif; ?>
    <form action="add-reservation.php" method="POST">
        <label for="trip_id">Trip:</label>
        <select name="trip_id" id="trip_id" required><?php echo getTripOptions(); ?></select><br>

        <label for="car_id">Car:</label>
        <select name="car_id" id="car_id" required><?php echo getCarOptions(); ?></select><br>

        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" required><br>

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" required><br>

        <label for="status">Status:</label>
        <input type="text" name="status" id="status" required><br>

        <button type="submit">Add Reservation</button>
    </form>
</body>
</html>
