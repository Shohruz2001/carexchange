<?php
require_once("util-db.php");
session_start(); // Start session to handle messages

if (isset($_POST['car_id'])) {
    $car_id = $_POST['car_id'];

    // Establish the database connection
    $conn = get_db_connection();

    // First, check if there are any reservations associated with this car
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM reservations WHERE car_id = ?");
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $stmt->store_result(); // Needed for getting the row count after SELECT COUNT(*)
    $stmt->bind_result($count);
    $stmt->fetch();

    if ($count > 0) {
        // If there are reservations, set a message and do not delete
        $_SESSION['message'] = "Car cannot be deleted because there are related reservations. Check those fields before deleting.";
    } else {
        // If no reservations, proceed to delete the car
        $stmt = $conn->prepare("DELETE FROM cars WHERE car_id = ?");
        $stmt->bind_param("i", $car_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Car deleted successfully!";
        } else {
            $_SESSION['message'] = "Error deleting car: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
    
    // Redirect back to the cars listing page
    header("Location: cars.php");
    exit();
}
?>
