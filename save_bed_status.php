<?php
include "db.php";

if (!isset($_GET['bed_number']) || !isset($_GET['status'])) {
    die("Invalid Request");
}

$bed = intval($_GET['bed_number']);
$status = str_replace("_", " ", $_GET['status']); // convert back

// Insert or Update (UPSERT)
$sql = "INSERT INTO bed_status (bed_number, status)
        VALUES ('$bed', '$status')
        ON DUPLICATE KEY UPDATE
        status='$status', updated_at=NOW()";

if (mysqli_query($conn, $sql)) {
    echo "Saved";
} else {
    echo "DB Error";
}
?>