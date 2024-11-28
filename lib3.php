<!-- lib3.php -->
<?php
$pageTitle = "Form Validation using Formik.js";
include "view-header.php";

// Fetch car makes and locations for the form options
$conn = get_db_connection();
$make_stmt = $conn->prepare("SELECT DISTINCT make FROM cars");
$make_stmt->execute();
$makes_result = $make_stmt->get_result();

$location_stmt = $conn->prepare("SELECT DISTINCT location FROM cars");
$location_stmt->execute();
$locations_result = $location_stmt->get_result();

$conn->close();
?>

<h1>Lib3: Form Validation using Formik.js</h1>
<p>This page uses Formik.js to validate car form inputs.</p>

<form id="carForm" method="POST" action="submit-form.php">
    <div class="mb-3">
        <label for="make" class="form-label">Car Make</label>
        <select class="form-control" id="make" name="make" required>
            <?php while ($row = $makes_result->fetch_assoc()) { ?>
                <option value="<?php echo $row['make']; ?>"><?php echo $row['make']; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="model" class="form-label">Car Model</label>
        <input type="text" class="form-control" id="model" name="model" required>
    </div>
    <div class="mb-3">
        <label for="year" class="form-label">Car Year</label>
        <input type="number" class="form-control" id="year" name="year" required>
    </div>
    <div class="mb-3">
        <label for="location" class="form-label">Car Location</label>
        <select class="form-control" id="location" name="location" required>
            <?php while ($row = $locations_result->fetch_assoc()) { ?>
                <option value="<?php echo $row['location']; ?>"><?php echo $row['location']; ?></option>
            <?php } ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/formik@2.2.9/dist/formik.umd.min.js"></script>
<script>
    const { Formik } = Formik;

    Formik({
        initialValues: { make: '', model: '', year: '', location: '' },
        onSubmit: (values) => {
            alert("Form Submitted: " + JSON.stringify(values, null, 2));
        }
    }).mount('#carForm');
</script>

<?php include "view-footer.php"; ?>
