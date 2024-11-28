<!-- lib3.php -->
<?php
$pageTitle = "Visual Form Validation";
include "view-header.php";  // Include the header for the page
?>

<h1>Lib3: Visual Form Validation</h1>
<p>This page uses JavaScript to perform visual form validation with instant feedback.</p>

<form id="carForm" action="submit-form.php" method="POST">
    <div class="mb-3">
        <label for="make" class="form-label">Car Make</label>
        <input type="text" class="form-control" id="make" name="make" required>
        <div id="makeError" style="color: red; display: none;">Make is required!</div>
    </div>

    <div class="mb-3">
        <label for="model" class="form-label">Car Model</label>
        <input type="text" class="form-control" id="model" name="model" required>
        <div id="modelError" style="color: red; display: none;">Model is required!</div>
    </div>

    <div class="mb-3">
        <label for="year" class="form-label">Car Year</label>
        <input type="number" class="form-control" id="year" name="year" min="1900" max="2100" required>
        <div id="yearError" style="color: red; display: none;">Please enter a valid year!</div>
    </div>

    <div class="mb-3">
        <label for="location" class="form-label">Car Location</label>
        <input type="text" class="form-control" id="location" name="location" required>
        <div id="locationError" style="color: red; display: none;">Location is required!</div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
    const form = document.getElementById('carForm');
    const make = document.getElementById('make');
    const model = document.getElementById('model');
    const year = document.getElementById('year');
    const location = document.getElementById('location');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Reset errors
        document.getElementById('makeError').style.display = 'none';
        document.getElementById('modelError').style.display = 'none';
        document.getElementById('yearError').style.display = 'none';
        document.getElementById('locationError').style.display = 'none';

        let valid = true;

        // Validate make
        if (make.value.trim() === '') {
            document.getElementById('makeError').style.display = 'block';
            valid = false;
        }

        // Validate model
        if (model.value.trim() === '') {
            document.getElementById('modelError').style.display = 'block';
            valid = false;
        }

        // Validate year
        if (year.value < 1900 || year.value > 2100) {
            document.getElementById('yearError').style.display = 'block';
            valid = false;
        }

        // Validate location
        if (location.value.trim() === '') {
            document.getElementById('locationError').style.display = 'block';
            valid = false;
        }

        // Submit form if valid
        if (valid) {
            form.submit();
        }
    });
</script>

<?php include "view-footer.php"; ?>
