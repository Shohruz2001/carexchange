<?php
require_once("util-db.php");
session_start(); // Start session to handle messages

if (isset($_POST['trip_id'])) {
    $trip_id = $_POST['trip_id'];
    $conn = get_db_connection();

    // Begin transaction to ensure data integrity
    $conn->begin_transaction();

    try {
        // Delete reservations associated with the trip
        $stmt = $conn->prepare("DELETE FROM reservations WHERE trip_id = ?");
        $stmt->bind_param("i", $trip_id);
        $stmt->execute();

        // Delete the trip
        $stmt = $conn->prepare("DELETE FROM trips WHERE trip_id = ?");
        $stmt->bind_param("i", $trip_id);
        $stmt->execute();

        // Commit transaction
        $conn->commit();
        $_SESSION['message'] = "Trip and all related reservations deleted successfully!";
    } catch (Exception $e) {
        // Rollback transaction if something goes wrong
        $conn->rollback();
        $_SESSION['message'] = "Error: " . $e->getMessage();
    }

    $conn->close();
    header("Location: trips.php");
    exit();
}
