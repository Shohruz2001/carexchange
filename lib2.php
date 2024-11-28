<!-- lib2.php -->
<?php
require_once('util-db.php');  // Include the database connection
$pageTitle = "Interactive Table: Car Data";
include "view-header.php";  // Include the header for the page

// Fetch all car data from the database
$conn = get_db_connection();
$stmt = $conn->prepare("SELECT make, model, year, location, availability_start, availability_end FROM cars");
$stmt->execute();
$cars = $stmt->get_result();
$conn->close();
?>

<h1>Lib2: Interactive Table using DataTables.js</h1>
<p>This page uses DataTables.js to display an interactive table with car data including make, model, year, and location.</p>

<table id="carTable" class="table table-bordered">
    <thead>
        <tr>
            <th>Make</th>
            <th>Model</th>
            <th>Year</th>
            <th>Location</th>
            <th>Availability Start</th>
            <th>Availability End</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($car = $cars->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $car['make']; ?></td>
            <td><?php echo $car['model']; ?></td>
            <td><?php echo $car['year']; ?></td>
            <td><?php echo $car['location']; ?></td>
            <td><?php echo $car['availability_start']; ?></td>
            <td><?php echo $car['availability_end']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#carTable').DataTable();  // Activate DataTables on the table
    });
</script>

<?php include "view-footer.php"; ?>
