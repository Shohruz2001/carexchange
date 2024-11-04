<?php
require_once("util-db.php");
session_start(); // Start session to handle messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact_info = $_POST['contact_info'];

    // Insert the new user into the database
    $conn = get_db_connection();
    $stmt = $conn->prepare("INSERT INTO users (username, email, contact_info) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $contact_info);
    $stmt->execute();
    $conn->close();

    // Set a success message and redirect
    $_SESSION['message'] = "User added successfully!";
    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
</head>
<body>
    <h1>Add New User</h1>
    <form action="add-user.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="contact_info">Contact Info:</label>
        <input type="text" name="contact_info" id="contact_info" required><br>

        <button type="submit">Add User</button>
    </form>
</body>
</html>
