<?php
require_once("util-db.php");
require_once("model-cars.php");

$pageTitle = "Cars";
include "view-header.php";
$cars = selectCars();
include "view-cars.php";
include "view-footer.php";
?>
