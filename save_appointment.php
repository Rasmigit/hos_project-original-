<?php
include 'db.php';

function clean($s){
    return htmlspecialchars(trim($s));
}

/* ===== CHECK REQUIRED FIELDS ===== */
if (
    empty($_POST['name']) ||
    empty($_POST['phone']) ||
    empty($_POST['email']) ||
    empty($_POST['doctor']) ||
    empty($_POST['date'])
) {
    die("All fields are required");
}

/* ===== GET FORM DATA ===== */
$name   = clean($_POST['name']);
$phone  = clean($_POST['phone']);
$email  = clean($_POST['email']);
$doctor = clean($_POST['doctor']);
$date   = clean($_POST['date']);
$notes  = isset($_POST['notes']) ? clean($_POST['notes']) : '';

/* ===== TOKEN NUMBER ===== */
$q = mysqli_query($conn, "SELECT MAX(token_number) AS t FROM appointments");
$r = mysqli_fetch_assoc($q);
$token = ($r['t'] ?? 0) + 1;

/* ===== INSERT ===== */
$sql = "INSERT INTO appointments
(name, phone, email, doctor, date, token_number, status, notes)
VALUES
('$name','$phone','$email','$doctor','$date','$token','Waiting','$notes')";

if(mysqli_query($conn, $sql)){
    header("Location: appointments.html?success=1");
    exit();
} else {
    echo "Database error: " . mysqli_error($conn);
}
?>