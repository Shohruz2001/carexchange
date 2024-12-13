<?php
require_once("util-db.php");
session_start(); // Start session to handle messages

if (isset($_POST['reservation_id'])) {
    $reservation_id = $_POST['reservation_id'];
    $conn = get_db_connection();

    // Delete the reservation
    $stmt = $conn->prepare("DELETE FROM reservations WHERE reservation_id = ?");
    $stmt->bind_param("i", $reservation_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Reservation deleted successfully!";
    } else {
        $_SESSION['message'] = "Error deleting reservation: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    header("Location: reservations.php");
    exit();
}
?>
