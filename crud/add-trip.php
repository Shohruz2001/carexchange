<?php
require_once("util-db.php");
session_start(); // Start session to handle messages

function getUserOptions() {
    $conn = get_db_connection();
    $sql = "SELECT user_id, username FROM users";
    $result = $conn->query($sql);
    $options = "";
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='{$row['user_id']}'>{$row['username']}</option>";
    }
    $conn->close();
    return $options;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $destination = $_POST['destination'];
    $departure_city = $_POST['departure_city'];
    $departure_date = $_POST['departure_date'];
    $return_date = $_POST['return_date'];

    $conn = get_db_connection();
    $stmt = $conn->prepare("INSERT INTO trips (user_id, destination, departure_city, departure_date, return_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $destination, $departure_city, $departure_date, $return_date);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Trip added successfully!";
    } else {
        $_SESSION['message'] = "Error adding trip: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    header("Location: trips.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Trip</title>
</head>
<body>
    <h1>Add New Trip</h1>
    <?php if (isset($_SESSION['message'])): ?>
    <script>alert('<?php echo $_SESSION['message']; ?>');</script>
    <?php unset($_SESSION['message']); endif; ?>
    <form action="add-trip.php" method="POST">
        <label for="user_id">User:</label>
        <select name="user_id" id="user_id" required><?php echo getUserOptions(); ?></select><br>

        <label for="destination">Destination:</label>
        <input type="text" name="destination" id="destination" required><br>

        <label for="departure_city">Departure City:</label>
        <input type="text" name="departure_city" id="departure_city" required><br>

        <label for="departure_date">Departure Date:</label>
        <input type="date" name="departure_date" id="departure_date" required><br>

        <label for="return_date">Return Date:</label>
        <input type="date" name="return_date" id="return_date" required><br>

        <button type="submit">Add Trip</button>
    </form>
</body>
</html>
