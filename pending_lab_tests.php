<?php
session_start();
if (!isset($_SESSION['lab_user'])) {
    header("Location: lab_login.php");
    exit();
}
include "db.php";

/* FETCH PENDING LAB REQUESTS */
$sql = "SELECT * FROM lab_tests WHERE status='Pending' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

if($result === false){
    die("SQL Error: " . mysqli_error($conn));
}

/* DATE LABEL FUNCTION */
function dateLabel($datetime) {
    $date = date("Y-m-d", strtotime($datetime));
    $today = date("Y-m-d");
    $yesterday = date("Y-m-d", strtotime("-1 day"));

    if ($date === $today) return "Today";
    if ($date === $yesterday) return "Yesterday";
    return date("d M Y", strtotime($datetime));
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Pending Lab Tests | Care Weave</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body{
    font-family:Poppins;
    background:#f4f7fb;
    margin:0;
    padding:30px;
}
.title{
    font-size:28px;
    font-weight:600;
    margin-bottom:25px;
}
.table-card{
    background:#fff;
    border-radius:18px;
    padding:25px;
    box-shadow:0 18px 45px rgba(0,0,0,0.12);
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
    border-bottom:1px solid #e3e3e3;
}
.status{
    padding:6px 14px;
    border-radius:20px;
    font-weight:600;
    background:#fff3cd;
    color:#f57c00;
}
.back{
    margin-top:25px;
    display:inline-block;
    background:#2563eb;
    color:#fff;
    padding:12px 20px;
    border-radius:10px;
    text-decoration:none;
}
</style>
</head>

<body>

<div class="title">⏳ Pending Lab Test Requests</div>

<div class="table-card">
<table>
<tr>
    <th>ID</th>
    <th>Appointment</th>
    <th>Patient</th>
    <th>Doctor</th>
    <th>Test</th>
    <th>Status</th>
    <th>Requested</th>
</tr>

<?php
if(mysqli_num_rows($result) === 0){
    echo "<tr><td colspan='7'>No pending lab requests</td></tr>";
}

while($row = mysqli_fetch_assoc($result)){
?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['appointment_id'] ?></td>
    <td><?= htmlspecialchars($row['patient_name']) ?></td>
    <td><?= htmlspecialchars($row['doctor_name']) ?></td>
    <td><?= htmlspecialchars($row['test_type']) ?></td>
    <td><span class="status"><?= $row['status'] ?></span></td>
    <td>
        <?= date("h:i A", strtotime($row['created_at'])) ?><br>
        <?= dateLabel($row['created_at']) ?>
    </td>
</tr>
<?php } ?>
</table>
</div>

<a href="lab_dashboard.php" class="back">← Back to Dashboard</a>

</body>
</html>