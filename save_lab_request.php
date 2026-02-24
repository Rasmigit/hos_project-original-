<?php
session_start();
include "db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "doctor") {
    die("Unauthorized");
}

$appointment_id = $_POST['appointment_id'] ?? '';
$patient_name   = $_POST['patient_name'] ?? '';
$test_type      = $_POST['test_type'] ?? '';

$doctor_name = $_SESSION['doctor_name'] ?? 'Doctor';

if ($appointment_id === '' || $patient_name === '' || $test_type === '') {
    die("Missing data");
}

$sql = "
INSERT INTO lab_tests 
(appointment_id, patient_name, doctor_name, test_type, status, created_at)
VALUES 
('$appointment_id', '$patient_name', '$doctor_name', '$test_type', 'Pending', NOW())
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}

header("Location: doctor_lab_requests.php?success=1");
exit();