<?php
require_once("util-db.php");
session_start(); // Start session to handle messages

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    $conn = get_db_connection();

    // First, delete all cars associated with the user
    $stmt = $conn->prepare("DELETE FROM cars WHERE owner_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Then, delete the user
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "User and all associated cars deleted successfully!";
    } else {
        $_SESSION['message'] = "Error deleting user: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: users.php");
    exit();
}
?>
