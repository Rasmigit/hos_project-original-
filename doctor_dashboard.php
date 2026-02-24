<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "doctor"){
    header("Location: index.html");
    exit();
}
include "db.php";

/* ===== LIVE QUEUE CALCULATION ===== */
$waiting = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS c FROM appointments WHERE status='Waiting'")
)['c'];

$completed = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS c FROM appointments WHERE status='Completed'")
)['c'];

$current = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT token_number FROM appointments 
                        WHERE status='Waiting' 
                        ORDER BY token_number ASC 
                        LIMIT 1")
);
$currentToken = $current['token_number'] ?? '-';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Doctor Dashboard | Care Weave</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
*{ box-sizing:border-box; font-family:'Poppins',sans-serif; }
body{ background:#f4f7fb; margin:0; padding:24px; }

/* ===== NAV BAR ===== */
.nav-bar{
    background:#2563eb;
    color:#fff;
    padding:16px 28px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-radius:18px;
    margin-bottom:30px;
}
.nav-links a{
    color:#e0e7ff;
    text-decoration:none;
    margin-left:18px;
    font-weight:500;
}
.nav-links a:hover{ color:#fff; text-decoration:underline; }
.logout{
    background:#ef4444;
    padding:6px 14px;
    border-radius:8px;
    color:#fff !important;
}

/* ===== QUEUE ===== */
.queue-bar{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:35px;
}
.queue-box{
    background:#fff;
    border-radius:18px;
    padding:26px;
    text-align:center;
    box-shadow:0 15px 35px rgba(0,0,0,.1);
}
.queue-box h2{
    font-size:36px;
    color:#2563eb;
    margin:0;
}

/* ===== CARD ===== */
.card{
    background:#fff;
    border-radius:18px;
    padding:25px;
    box-shadow:0 15px 35px rgba(0,0,0,.1);
    margin-bottom:35px;
}

/* ===== TABLE ===== */
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
.status-waiting{ color:#f59e0b; font-weight:600; }
.status-completed{ color:#16a34a; font-weight:600; }

.btn{
    background:#2563eb;
    color:#fff;
    padding:6px 14px;
    border-radius:8px;
    border:none;
    cursor:pointer;
}
.bill-btn{
    background:#16a34a;
}
.bill-btn:hover{
    background:#15803d;
}

/* ===== AI ===== */
.ai-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
}
.ai-box{
    background:#f9fbff;
    padding:20px;
    border-radius:14px;
    border:1px solid #e5edff;
}
.result{
    background:#eaf2ff;
    padding:18px;
    border-left:5px solid #2563eb;
    border-radius:10px;
}

@media(max-width:768px){
    .ai-grid{ grid-template-columns:1fr; }
}
</style>
</head>

<body>

<!-- ===== NAV BAR ===== -->
<div class="nav-bar">
    <h2>👨‍⚕️ Doctor Dashboard</h2>
    <div class="nav-links">
        <a href="doctor_dashboard.php">Overview</a>
        <a href="doctor_lab_requests.php">Lab Tests</a>
        <a href="doctor_lab_reports.php">Lab Reports</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</div>

<!-- ===== QUEUE ===== -->
<div class="queue-bar">
    <div class="queue-box">
        <h2><?= $currentToken ?></h2>
        <p>Now Consulting</p>
    </div>
    <div class="queue-box">
        <h2><?= $waiting ?></h2>
        <p>Patients Waiting</p>
    </div>
    <div class="queue-box">
        <h2><?= $completed ?></h2>
        <p>Completed</p>
    </div>
</div>

<!-- ===== APPOINTMENTS ===== -->
<div class="card">
<h3>📅 Appointments & Token Queue</h3>

<table>
<tr>
    <th>ID</th>
    <th>Patient</th>
    <th>Phone</th>
    <th>Date</th>
    <th>Token</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
$result = mysqli_query($conn,"SELECT * FROM appointments ORDER BY token_number ASC");
while($row = mysqli_fetch_assoc($result)){
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['phone']}</td>
        <td>{$row['date']}</td>
        <td>{$row['token_number']}</td>
        <td class='".($row['status']=='Waiting'?'status-waiting':'status-completed')."'>{$row['status']}</td>
        <td>";

    if($row['status'] === 'Waiting'){
        echo "<a class='btn' href='next_patient.php?id={$row['id']}'>Next</a>";
    } else {
        echo "
        <form action='generate_bill.php' method='post' style='display:inline;'>
            <input type='hidden' name='appointment_id' value='{$row['id']}'>
            <input type='hidden' name='patient_name' value='{$row['name']}'>
            <input type='hidden' name='patient_email' value='{$row['email']}'>
            <button class='btn bill-btn'>💳 Generate Bill</button>
        </form>";
    }

    echo "</td></tr>";
}
?>
</table>
</div>

<!-- ===== AI SECTION ===== -->
<div class="card">
<h3>🧠 AI Disease Detection (Decision Support)</h3>

<div class="ai-grid">
    <div class="ai-box">
        <label><input type="checkbox" value="fever"> Fever</label><br>
        <label><input type="checkbox" value="cough"> Cough</label><br>
        <label><input type="checkbox" value="vomiting"> Vomiting</label><br>
        <label><input type="checkbox" value="diarrhea"> Diarrhea</label><br>
        <label><input type="checkbox" value="weight_loss"> Weight Loss</label><br><br>
        <button class="btn" onclick="predict()">Analyze</button>
    </div>

    <div class="ai-box">
        <div id="result" class="result">Select symptoms and analyze.</div>
    </div>
</div>
</div>

<script>
function predict(){
    let s=[...document.querySelectorAll('input:checked')].map(x=>x.value);
    let r="General observation advised";
    if(s.includes("fever") && s.includes("cough")) r="Possible viral infection";
    if(s.includes("vomiting") && s.includes("diarrhea")) r="Gastroenteritis";
    document.getElementById("result").innerHTML="<b>Result:</b> "+r;
}
</script>

</body>
</html>
