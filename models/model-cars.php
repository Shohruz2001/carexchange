<?php
function selectCars() {
    try {
        $conn = get_db_connection();
        $stmt = $conn->prepare("SELECT car_id, owner_id, make, model, year, license_plate, location, availability_start, availability_end FROM `cars`");
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
