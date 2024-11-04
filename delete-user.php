<?php
require_once("util-db.php");
session_start(); // Start session to handle messages

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Delete the user from the database
    $conn = get_db_connection();
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $conn->close();

    // Set a success message and redirect
    $_SESSION['message'] = "User deleted successfully!";
    header("Location: users.php");
    exit();
}
