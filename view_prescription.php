<?php
include "db.php";

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = intval($_GET['id']);

$q = mysqli_query($conn, "SELECT prescription_file FROM orders WHERE id = $id");
$row = mysqli_fetch_assoc($q);

if (!$row || empty($row['prescription_file'])) {
    die("Prescription not found");
}

$file = "uploads/prescriptions/" . $row['prescription_file'];

if (!file_exists($file)) {
    die("File missing on server");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Prescription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
            text-align: center;
        }
        iframe, img {
            width: 90%;
            height: 90vh;
            border: none;
        }
    </style>
</head>
<body>

<h2>Prescription Document</h2>

<?php
$ext = pathinfo($file, PATHINFO_EXTENSION);

if (in_array(strtolower($ext), ['pdf'])) {
    echo "<iframe src='$file'></iframe>";
} else {
    echo "<img src='$file' alt='Prescription'>";
}
?>

</body>
</html>