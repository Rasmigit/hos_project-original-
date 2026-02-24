<?php
$conn = mysqli_connect("localhost", "root", "", "hos_project");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>