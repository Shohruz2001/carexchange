<?php
require_once("util-db.php");
session_start(); // Start session to handle messages

if (isset($_POST['car_id'])) {
    $car_id = $_POST['car_id'];
    $conn = get_db_connection();

    // Begin transaction to ensure data integrity
    $conn->begin_transaction();

    try {
        // Delete reservations associated with the car
        $stmt = $conn->prepare("DELETE FROM reservations WHERE car_id = ?");
        $stmt->bind_param("i", $car_id);
        $stmt->execute();

        // Delete the car
        $stmt = $conn->prepare("DELETE FROM cars WHERE car_id = ?");
        $stmt->bind_param("i", $car_id);
        $stmt->execute();

        // Commit transaction
        $conn->commit();
        $_SESSION['message'] = "Car and all related reservations deleted successfully!";
    } catch (Exception $e) {
        // Rollback transaction if something goes wrong
        $conn->rollback();
        $_SESSION['message'] = "Error: " . $e->getMessage();
    }

    $conn->close();
    header("Location: cars.php");
    exit();
}
?>
