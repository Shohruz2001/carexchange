<?php
require_once("util-db.php");
session_start(); // Start session to handle messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact_info = $_POST['contact_info'];
    $password = $_POST['password']; // Retrieve the password

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $conn = get_db_connection();
    $stmt = $conn->prepare("INSERT INTO users (username, email, contact_info, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $contact_info, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['message'] = "User added successfully!";
    } else {
        $_SESSION['message'] = "Error adding user: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
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

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <button type="submit">Add User</button>
    </form>
</body>
</html>
