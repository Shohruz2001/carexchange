<?php
// Function to select all users from the 'users' table
function selectUsers() {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT user_id, username, email, contact_info FROM `users`");
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        return $result;
    } catch (Exception $e) {
        $conn->close();
        throw $e;
    }
}

// Function to get user details by user_id
function getUserDetails($user_id) {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        return $result->fetch_assoc();
    } catch (Exception $e) {
        $conn->close();
        throw $e;
    }
}
?>
