<?php
include "db.php";

/* ================= SECURITY CHECK ================= */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

/* ================= FORM DATA ================= */
$full_name   = trim($_POST['full_name'] ?? '');
$blood_group = trim($_POST['blood_group'] ?? '');
$mobile      = trim($_POST['mobile'] ?? '');

if ($full_name === '' || $blood_group === '' || $mobile === '') {
    die("Missing required fields");
}

/* ================= FILE UPLOAD ================= */
$document_file = NULL;
$upload_dir = "uploads/donors/";

/* Create folder if missing */
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

/* Handle file */
if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {

    $ext = pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION);
    $allowed = ['pdf','jpg','jpeg','png'];

    if (!in_array(strtolower($ext), $allowed)) {
        die("Invalid file type");
    }

    /* Unique filename */
    $document_file = uniqid("donor_", true) . "." . $ext;
    $target_path = $upload_dir . $document_file;

    if (!move_uploaded_file($_FILES['document']['tmp_name'], $target_path)) {
        die("File upload failed");
    }
}

/* ================= DATABASE INSERT ================= */
$stmt = $conn->prepare(
    "INSERT INTO blood_donors 
     (full_name, blood_group, mobile, document_file, verification_status)
     VALUES (?, ?, ?, ?, 'Pending')"
);

$stmt->bind_param(
    "ssss",
    $full_name,
    $blood_group,
    $mobile,
    $document_file
);

$stmt->execute();
$stmt->close();

/* ================= REDIRECT (NO WHITE PAGE) ================= */
header("Location: blood_donation.html?success=1");
exit;