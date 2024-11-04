<?php
require_once("util-db.php");
session_start(); // Start session to handle messages

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $conn = get_db_connection();
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact_info = $_POST['contact_info'];

    // Update the user in the database
    $conn = get_db_connection();
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, contact_info = ? WHERE user_id = ?");
    $stmt->bind_param("sssi", $username, $email, $contact_info, $user_id);
    $stmt->execute();
    $conn->close();

    // Set a success message and redirect
    $_SESSION['message'] = "User updated successfully!";
    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form action="edit-user.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo $user['username']; ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>" required><br>

        <label for="contact_info">Contact Info:</label>
        <input type="text" name="contact_info" id="contact_info" value="<?php echo $user['contact_info']; ?>" required><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
