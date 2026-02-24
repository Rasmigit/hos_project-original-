<?php
include "db.php";

$appointment_id = $_POST['appointment_id'];
$symptoms = $_POST['symptoms'];
$disease = $_POST['disease'];
$severity = $_POST['severity'];
$confidence = $_POST['confidence'];
$advice = $_POST['advice'];

$query = "INSERT INTO diagnosis_records
(appointment_id, symptoms, predicted_disease, severity, confidence, advice)
VALUES
('$appointment_id','$symptoms','$disease','$severity','$confidence','$advice')";

mysqli_query($conn, $query);

echo "Saved";
?>
