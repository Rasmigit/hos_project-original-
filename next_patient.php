<?php
include "db.php";
$id = (int)$_GET['id'];
mysqli_query($conn,"UPDATE appointments SET status='Completed' WHERE id=$id");
header("Location: doctor_dashboard.php");
?>
