<?php
require_once("util-db.php");

if (isset($_POST['car_id'])) {
    $car_id = $_POST['car_id'];

    // Delete the car from the database
    $conn = get_db_connection();
    $stmt = $conn->prepare("DELETE FROM cars WHERE car_id = ?");
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $conn->close();

    $_SESSION['message'] = "Car deleted successfully!";
    header("Location: cars.php");
    exit();
}
