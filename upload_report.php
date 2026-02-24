<?php
session_start();
include "db.php";

if (!isset($_SESSION['lab_user'])) {
    header("Location: lab_login.php");
    exit();
}

/* Fetch pending lab tests */
$tests = mysqli_query(
    $conn,
    "SELECT id, patient_name, test_type FROM lab_tests WHERE status='Pending'"
);
?>
<!DOCTYPE html>
<html>
<head>
<title>Upload Lab Report | Care Weave</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body{
    font-family:Poppins;
    background:#f4f7fb;
    padding:30px;
}
.card{
    max-width:500px;
    margin:auto;
    background:#fff;
    padding:30px;
    border-radius:18px;
    box-shadow:0 15px 40px rgba(0,0,0,0.15);
}
h2{ color:#0b2e4f; margin-bottom:20px; }
label{ display:block; margin-top:12px; }
input,select,textarea{
    width:100%;
    padding:10px;
    margin-top:6px;
    border-radius:8px;
    border:1px solid #ccc;
}
button{
    margin-top:18px;
    width:100%;
    padding:12px;
    background:#2563eb;
    color:#fff;
    border:none;
    border-radius:10px;
    font-size:15px;
}
.back{
    display:block;
    text-align:center;
    margin-top:18px;
    text-decoration:none;
    color:#2563eb;
}
</style>
</head>

<body>

<div class="card">
<h2>📤 Upload Lab Report</h2>

<form action="save_report.php" method="post" enctype="multipart/form-data">

<label>Select Lab Test</label>
<select name="lab_test_id" required>
<?php while ($t = mysqli_fetch_assoc($tests)) { ?>
    <option value="<?= $t['id'] ?>">
        <?= $t['patient_name'] ?> (<?= $t['test_type'] ?>)
    </option>
<?php } ?>
</select>

<label>Upload Report (PDF / Image)</label>
<input type="file" name="report" required>

<label>Remarks</label>
<textarea name="remarks"></textarea>

<button type="submit">Upload Report</button>

</form>

<a href="lab_dashboard.php" class="back">⬅ Back to Dashboard</a>
</div>

</body>
</html>