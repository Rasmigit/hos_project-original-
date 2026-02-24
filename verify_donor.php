<?php
session_start();
include "db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    exit("Unauthorized");
}

$id = intval($_GET['id']);
mysqli_query($conn,"UPDATE blood_donors SET verification_status='Verified' WHERE id=$id");
header("Location: admin_dashboard.php");
exit();