<?php
require_once("util-db.php");
session_start(); // Start session to handle messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_id = $_POST['car_id'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $license_plate = $_POST['license_plate'];
    $location = $_POST['location'];
    $availability_start = $_POST['availability_start'];
    $availability_end = $_POST['availability_end'];

    $conn = get_db_connection();
    $stmt = $conn->prepare("UPDATE cars SET make = ?, model = ?, year = ?, license_plate = ?, location = ?, availability_start = ?, availability_end = ? WHERE car_id = ?");
    $stmt->bind_param("ssissssi", $make, $model, $year, $license_plate, $location, $availability_start, $availability_end, $car_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Car updated successfully!";
    } else {
        $_SESSION['message'] = "Error updating car: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    header("Location: cars.php?id=" . $car_id);
    exit();
}

if (isset($_GET['id'])) {
    $car_id = $_GET['id'];
    $conn = get_db_connection();
    $stmt = $conn->prepare("SELECT * FROM cars WHERE car_id = ?");
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $car = $stmt->get_result()->fetch_assoc();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car</title>
</head>
<body>
    <h1>Edit Car</h1>

    <!-- Success/Error Message -->
    <?php if (isset($_SESSION['message'])): ?>
    <script>alert('<?php echo $_SESSION['message']; ?>');</script>
    <?php unset($_SESSION['message']); endif; ?>

    <form action="edit-car.php" method="POST">
        <input type="hidden" name="car_id" value="<?php echo $car['car_id']; ?>">

        <label for="make">Make:</label>
        <input type="text" name="make" id="make" value="<?php echo $car['make']; ?>" required><br>

        <label for="model">Model:</label>
        <input type="text" name="model" id="model" value="<?php echo $car['model']; ?>" required><br>

        <label for="year">Year:</label>
        <input type="number" name="year" id="year" value="<?php echo $car['year']; ?>" required><br>

        <label for="license_plate">License Plate:</label>
        <input type="text" name="license_plate" id="license_plate" value="<?php echo $car['license_plate']; ?>" required><br>

        <label for="location">Location:</label>
        <input type="text" name="location" id="location" value="<?php echo $car['location']; ?>" required><br>

        <label for="availability_start">Availability Start:</label>
        <input type="date" name="availability_start" id="availability_start" value="<?php echo $car['availability_start']; ?>" required><br>

        <label for="availability_end">Availability End:</label>
        <input type="date" name="availability_end" id="availability_end" value="<?php echo $car['availability_end']; ?>" required><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
