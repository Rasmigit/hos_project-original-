<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "doctor") {
    header("Location: index.html");
    exit();
}
include "db.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lab Test Requests | Care Weave</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
*{ box-sizing:border-box; font-family:'Poppins',sans-serif; }
body{ background:#f4f7fb; margin:0; padding:25px; }

/* NAV */
.nav-bar{
    background:linear-gradient(135deg,#2563eb,#1e40af);
    color:#fff;
    padding:18px 30px;
    border-radius:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}
.nav-bar a{
    color:#fff;
    text-decoration:none;
    background:#ffffff22;
    padding:8px 14px;
    border-radius:10px;
}

/* CARD */
.card{
    background:#fff;
    border-radius:18px;
    padding:25px;
    box-shadow:0 15px 35px rgba(0,0,0,0.1);
    margin-bottom:30px;
}
.card h3{
    color:#1e40af;
    margin-bottom:20px;
}

/* FORM */
.form-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}
.form-grid input,
.form-grid select{
    padding:12px;
    border-radius:10px;
    border:1px solid #d1d5db;
}
.form-grid button{
    background:#2563eb;
    color:#fff;
    border:none;
    padding:12px;
    border-radius:12px;
    cursor:pointer;
    font-size:15px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}
th{
    background:#2563eb;
    color:#fff;
    padding:12px;
}
td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #e5e7eb;
}

/* STATUS BADGES */
.badge{
    padding:6px 14px;
    border-radius:999px;
    font-size:13px;
    font-weight:500;
}
.pending{ background:#fef3c7; color:#92400e; }
.completed{ background:#dcfce7; color:#166534; }

/* EMPTY */
.empty{
    text-align:center;
    padding:30px;
    color:#777;
}
</style>
</head>

<body>

<!-- NAV -->
<div class="nav-bar">
    <h2>🧪 Lab Test Requests</h2>
    <a href="doctor_dashboard.php">⬅ Back to Dashboard</a>
</div>

<!-- SEND REQUEST -->
<div class="card">
<h3>📤 Send New Lab Request</h3>

<form method="post" action="save_lab_request.php">
<div class="form-grid">
    <input type="number" name="appointment_id" placeholder="Appointment ID" required>
    <input type="text" name="patient_name" placeholder="Patient Name" required>

    <select name="test_type" required>
        <option value="">Select Test</option>
        <option value="Blood Test">Blood Test</option>
        <option value="Urine Test">Urine Test</option>
        <option value="X-Ray">X-Ray</option>
        <option value="ECG">ECG</option>
    </select>

    <button type="submit">Send to Lab</button>
</div>
</form>
</div>

<!-- SENT REQUESTS -->
<div class="card">
<h3>📋 Sent Requests</h3>

<table>
<tr>
    <th>ID</th>
    <th>Patient</th>
    <th>Test</th>
    <th>Status</th>
    <th>Date</th>
</tr>

<?php
$q = mysqli_query($conn, "SELECT * FROM lab_tests ORDER BY created_at DESC");

if (!$q) {
    echo "<tr><td colspan='5' class='empty'>Lab test table not available</td></tr>";
} elseif (mysqli_num_rows($q) === 0) {
    echo "<tr><td colspan='5' class='empty'>No lab requests sent</td></tr>";
} else {
    while ($row = mysqli_fetch_assoc($q)) {
        $statusClass = ($row['status'] === 'Completed') ? 'completed' : 'pending';

        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['patient_name']}</td>
            <td>{$row['test_type']}</td>
            <td><span class='badge $statusClass'>{$row['status']}</span></td>
            <td>{$row['created_at']}</td>
        </tr>";
    }
}
?>
</table>
</div>

</body>
</html>