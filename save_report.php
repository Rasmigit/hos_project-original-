<?php
session_start();
include "db.php";

/* AUTH */
if (!isset($_SESSION['lab_user'])) {
    header("Location: lab_login.php");
    exit();
}

/* VALIDATE REQUEST */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

/* REQUIRED FIELDS */
if (
    !isset($_POST['lab_test_id']) ||
    !isset($_FILES['report'])
) {
    die("Invalid request");
}

$lab_test_id = intval($_POST['lab_test_id']);
$remarks     = $_POST['remarks'] ?? '';

/* FILE UPLOAD */
$upload_dir = "uploads/lab_reports/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$file_name = time() . "_" . basename($_FILES['report']['name']);
$file_path = $upload_dir . $file_name;

if (!move_uploaded_file($_FILES['report']['tmp_name'], $file_path)) {
    die("File upload failed");
}

/* GET LAB TEST DETAILS */
$test = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT patient_name, doctor_name FROM lab_tests WHERE id='$lab_test_id'")
);

if (!$test) {
    die("Invalid lab test");
}

/* INSERT REPORT */
mysqli_query($conn, "
    INSERT INTO lab_reports (lab_test_id, patient_name, report_file, uploaded_at)
    VALUES ('$lab_test_id', '{$test['patient_name']}', '$file_path', NOW())
");

/* UPDATE STATUS */
mysqli_query($conn, "
    UPDATE lab_tests SET status='Completed' WHERE id='$lab_test_id'
");

/* NOTIFICATION */
mysqli_query($conn, "
    INSERT INTO notifications (doctor_name, message)
    VALUES ('{$test['doctor_name']}', '🧪 Lab report uploaded')
");

/* REDIRECT */
header("Location: lab_dashboard.php");
exit();