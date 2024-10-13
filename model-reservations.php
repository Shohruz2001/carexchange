<?php
// Function to select all reservations from the 'reservations' table
function selectReservations() {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT reservation_id, trip_id, car_id, start_date, end_date, status FROM `reservations`");
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        return $result;
    } catch (Exception $e) {
        $conn->close();
        throw $e;
    }
}

// Function to get reservation details by reservation_id
function getReservationDetails($reservation_id) {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT * FROM reservations WHERE reservation_id = ?");
        $stmt->bind_param("i", $reservation_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        return $result->fetch_assoc();
    } catch (Exception $e) {
        $conn->close();
        throw $e;
    }
}

// Function to get all reservations for a specific trip
function getTripReservations($trip_id) {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT * FROM reservations WHERE trip_id = ?");
        $stmt->bind_param("i", $trip_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        return $result;
    } catch (Exception $e) {
        $conn->close();
        throw $e;
    }
}

// Function to get all reservations for a specific car
function getCarReservations($car_id) {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT * FROM reservations WHERE car_id = ?");
        $stmt->bind_param("i", $car_id);
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
