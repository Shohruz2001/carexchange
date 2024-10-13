<?php
// Function to select all trips from the 'trips' table
function selectTrips() {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT trip_id, user_id, destination, departure_city, departure_date, return_date FROM `trips`");
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        return $result;
    } catch (Exception $e) {
        $conn->close();
        throw $e;
    }
}

// Function to get trip details by trip_id
function getTripDetails($trip_id) {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT * FROM trips WHERE trip_id = ?");
        $stmt->bind_param("i", $trip_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        return $result->fetch_assoc();
    } catch (Exception $e) {
        $conn->close();
        throw $e;
    }
}

// Function to get all trips by a specific user
function getUserTrips($user_id) {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT * FROM trips WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        return $result;
    } catch (Exception $e) {
        $conn->close();
        throw $e;
    }
}
?>
