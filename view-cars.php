<h1>Cars</h1>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Owner ID</th>
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
                <th>License Plate</th>
                <th>Location</th>
                <th>Availability Start</th>
                <th>Availability End</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php
        while ($car = $cars->fetch_assoc()) {
        ?>
            <tr>
                <td><?php echo $car['car_id']; ?></td>
                <td><?php echo $car['owner_id']; ?></td>
                <td><?php echo $car['make']; ?></td>
                <td><?php echo $car['model']; ?></td>
                <td><?php echo $car['year']; ?></td>
                <td><?php echo $car['license_plate']; ?></td>
                <td><?php echo $car['location']; ?></td>
                <td><?php echo $car['availability_start']; ?></td>
                <td><?php echo $car['availability_end']; ?></td>
                <td><a href="car-details.php?id=<?php echo $car['car_id']; ?>">Details</a></td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</div>
