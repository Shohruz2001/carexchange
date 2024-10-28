<?php
require_once("util-db.php");
session_start();

if (isset($_POST['car_id'])) {
    $car_id = $_POST['car_id'];
    $conn = get_db_connection();

    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("DELETE FROM reservations WHERE car_id = ?");
        $stmt->bind_param("i", $car_id);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM cars WHERE car_id = ?");
        $stmt->bind_param("i", $car_id);
        $stmt->execute();

        $conn->commit();
        $_SESSION['message'] = "Car and all related reservations deleted successfully!";
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['message'] = "Error: " . $e->getMessage();
    }

    $conn->close();
    header("Location: cars.php");
    exit();
}
?>

<script>
<?php if (isset($_SESSION['message'])): ?>
    alert('<?php echo $_SESSION['message']; ?>');
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>
</script>
