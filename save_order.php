<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: blood_donation.html");
    exit;
}

$name  = $_POST['full_name'];
$group = $_POST['blood_group'];
$mobile = $_POST['mobile'];

$documentFile = NULL;

/* ===== FILE UPLOAD ===== */
if (!empty($_FILES['document']['name'])) {
    $folder = "uploads/donors/";
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $fileName = time() . "_" . basename($_FILES['document']['name']);
    $targetPath = $folder . $fileName;

    if (move_uploaded_file($_FILES['document']['tmp_name'], $targetPath)) {
        $documentFile = $fileName;
    }
}

/* ===== INSERT ===== */
$stmt = $conn->prepare("
    INSERT INTO blood_donors 
    (full_name, blood_group, mobile, document_file, verification_status)
    VALUES (?, ?, ?, ?, 'Pending')
");

$stmt->bind_param("ssss", $name, $group, $mobile, $documentFile);
$stmt->execute();

/* ===== REDIRECT BACK (NO BLANK PAGE) ===== */
header("Location: blood_donation.html?success=1");
exit;