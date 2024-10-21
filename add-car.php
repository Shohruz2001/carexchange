<?php
require_once("util-db.php");
session_start(); // Start session to handle messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $license_plate = $_POST['license_plate'];
    $location = $_POST['location'];
    $availability_start = $_POST['availability_start'];
    $availability_end = $_POST['availability_end'];

    // Insert into the database
    $conn = get_db_connection();
    $stmt = $conn->prepare("INSERT INTO cars (make, model, year, license_plate, location, availability_start, availability_end) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissss", $make, $model, $year, $license_plate, $location, $availability_start, $availability_end);
    $stmt->execute();
    $conn->close();

    // Redirect after submission
    $_SESSION['message'] = "Car added successfully!";
    header("Location: cars.php"); // Ensure the path is correct and points to Cars.php
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
   <form action="add-car.php" method="POST">
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
