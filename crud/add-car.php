<?php
require_once("util-db.php");
session_start(); // Start session to handle messages

function getOwnerOptions() {
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
    $owner_id = $_POST['owner_id'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $license_plate = $_POST['license_plate'];
    $location = $_POST['location'];
    $availability_start = $_POST['availability_start'];
    $availability_end = $_POST['availability_end'];

    $conn = get_db_connection();
    $stmt = $conn->prepare("INSERT INTO cars (owner_id, make, model, year, license_plate, location, availability_start, availability_end) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ississss", $owner_id, $make, $model, $year, $license_plate, $location, $availability_start, $availability_end);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Car added successfully!";
    } else {
        $_SESSION['message'] = "Error adding car: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    header("Location: cars.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Car</title>
</head>
<body>
    <h1>Add New Car</h1>

    <!-- Success/Error Message -->
    <?php if (isset($_SESSION['message'])): ?>
    <script>alert('<?php echo $_SESSION['message']; ?>');</script>
    <?php unset($_SESSION['message']); endif; ?>

    <form action="add-car.php" method="POST">
        <label for="owner_id">Owner:</label>
        <select name="owner_id" id="owner_id" required><?php echo getOwnerOptions(); ?></select><br>

        <label for="make">Make:</label>
        <input type="text" name="make" id="make" required><br>

        <label for="model">Model:</label>
        <input type="text" name="model" id="model" required><br>

        <label for="year">Year:</label>
        <input type="number" name="year" id="year" required><br>

        <label for="license_plate">License Plate:</label>
        <input type="text" name="license_plate" id="license_plate" required><br>

        <label for="location">Location:</label>
        <input type="text" name="location" id="location" required><br>

        <label for="availability_start">Availability Start:</label>
        <input type="date" name="availability_start" id="availability_start" required><br>

        <label for="availability_end">Availability End:</label>
        <input type="date" name="availability_end" id="availability_end" required><br>

        <button type="submit">Add Car</button>
    </form>
</body>
</html>
