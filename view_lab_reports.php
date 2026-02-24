<?php
session_start();
include "db.php";

if(!isset($_SESSION['lab_user'])){
    header("Location: lab_login.php");
    exit();
}

$sql = "SELECT * FROM lab_reports ORDER BY uploaded_at DESC";
$result = mysqli_query($conn, $sql);

if($result === false){
    die("SQL Error: " . mysqli_error($conn));
}
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
h2{
    color:#0b2e4f;
    margin-bottom:20px;
}
table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(0,0,0,0.12);
}
th,td{
    padding:14px;
    text-align:center;
}
th{
    background:#0b2e4f;
    color:#fff;
}
tr:nth-child(even){
    background:#f1f5ff;
}
a.view{
    background:#2563eb;
    color:#fff;
    padding:6px 12px;
    border-radius:6px;
    text-decoration:none;
}
.back{
    display:inline-block;
    margin-top:25px;
    text-decoration:none;
    background:#2563eb;
    color:#fff;
    padding:10px 18px;
    border-radius:8px;
}
.empty{
    text-align:center;
    padding:25px;
    color:#777;
}
</style>
</head>

<body>

<h2>📄 Completed Lab Reports</h2>

<table>
<tr>
    <th>Patient</th>
    <th>Report</th>
    <th>Date</th>
</tr>

<?php
if(mysqli_num_rows($result) === 0){
    echo "<tr><td colspan='3' class='empty'>No lab reports uploaded</td></tr>";
}

while($row = mysqli_fetch_assoc($result)){
?>
<tr>
    <td><?= htmlspecialchars($row['patient_name']) ?></td>
    <td>
        <a class="view" href="<?= htmlspecialchars($row['report_file']) ?>" target="_blank">
            View Report
        </a>
    </td>
    <td><?= date("d M Y, h:i A", strtotime($row['uploaded_at'])) ?></td>
</tr>
<?php } ?>

</table>

<a href="lab_dashboard.php" class="back">⬅ Back to Dashboard</a>

</body>
</html>