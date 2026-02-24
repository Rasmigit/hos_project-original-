<?php
include "db.php";

$id = intval($_GET['id'] ?? 0);

$q = mysqli_query($conn, "SELECT document_file FROM blood_donors WHERE id=$id");
$row = mysqli_fetch_assoc($q);

if (!$row || empty($row['document_file'])) {
    die("Document not found");
}

$file_path = "uploads/donors/" . $row['document_file'];

if (!file_exists($file_path)) {
    die("File missing on server");
}

// Detect file type
$ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

if ($ext === 'pdf') {
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=\"" . basename($file_path) . "\"");
} else {
    header("Content-Type: image/jpeg");
}

readfile($file_path);
exit;