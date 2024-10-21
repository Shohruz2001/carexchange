<?php
require_once("util-db.php");

if (isset($_GET['id'])) {
    $car_id = $_GET['id'];
    $conn = get_db_connection();
    $stmt = $conn->prepare("SELECT * FROM cars WHERE car_id = ?");
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $car = $stmt->get_result()->fetch_assoc();
    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_id = $_POST['car_id'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $license_plate = $_POST['license_plate'];
    $location = $_POST['location'];
    $availability_start = $_POST['availability_start'];
    $availability_end = $_POST['availability_end'];

    // Update the car in the database
    $conn = get_db_connection();
    $stmt = $conn->prepare("UPDATE cars SET make = ?, model = ?, year = ?, license_plate = ?, location = ?, availability_start = ?, availability_end = ? WHERE car_id = ?");
    $stmt->bind_param("ssissssi", $make, $model, $year, $license_plate, $location, $availability_start, $availability_end, $car_id);
    $stmt->execute();
    $conn->close();

    $_SESSION['message'] = "Car updated successfully!";
    header("Location: cars.php");
    exit();
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
