<?php
session_start();
include "db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    header("Location: index.html");
    exit();
}

/* Fetch uploaded lab reports */
$result = mysqli_query(
    $conn,
    "SELECT patient_name, report_file, uploaded_at 
     FROM lab_reports 
     ORDER BY uploaded_at DESC"
);
?>
<!DOCTYPE html>
<html>
<head>
<title>Lab Reports | Care Weave</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body{
    font-family:Poppins;
    background:#f4f7fb;
    padding:30px;
}
.header{
    background:linear-gradient(135deg,#2563eb,#1e40af);
    color:#fff;
    padding:20px 30px;
    border-radius:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}
.header a{
    color:#fff;
    text-decoration:none;
    background:#ffffff22;
    padding:8px 14px;
    border-radius:10px;
}
.card{
    background:#fff;
    border-radius:18px;
    padding:25px;
    box-shadow:0 15px 40px rgba(0,0,0,0.12);
}
table{
    width:100%;
    border-collapse:collapse;
}
th{
    background:#0b2e4f;
    color:#fff;
    padding:14px;
}
td{
    padding:14px;
    text-align:center;
    border-bottom:1px solid #e5e7eb;
}
.empty{
    padding:30px;
    text-align:center;
    color:#777;
}
a.view{
    background:#2563eb;
    color:#fff;
    padding:6px 12px;
    border-radius:6px;
    text-decoration:none;
}
</style>
</head>

<body>

<div class="header">
    <h2>📄 Lab Reports</h2>
    <a href="doctor_dashboard.php">⬅ Back to Dashboard</a>
</div>

<div class="card">
<table>
<tr>
    <th>Patient</th>
    <th>Report</th>
    <th>Date</th>
</tr>

<?php
if (mysqli_num_rows($result) === 0) {
    echo "<tr><td colspan='3' class='empty'>No lab reports available</td></tr>";
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$row['patient_name']}</td>
            <td>
                <a class='view' href='{$row['report_file']}' target='_blank'>View</a>
            </td>
            <td>{$row['uploaded_at']}</td>
        </tr>";
    }
}
?>
</table>
</div>

</body>
</html>