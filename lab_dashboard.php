<?php
session_start();
if(!isset($_SESSION['lab_user'])){
    header("Location: lab_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Lab Dashboard | Care Weave</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}
body{
    background:#f4f7fb;
    color:#0f172a;
}

/* ===== HEADER ===== */
.header{
    background:linear-gradient(90deg,#0b1f3a,#123a6f);
    color:#fff;
    padding:22px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
}
.header h2{
    font-size:24px;
}
.logout{
    background:#e53935;
    padding:10px 18px;
    border-radius:8px;
    text-decoration:none;
    color:#fff;
}

/* ===== CONTAINER ===== */
.container{
    max-width:1200px;
    margin:40px auto;
    padding:0 20px;
}

/* ===== WELCOME CARD ===== */
.welcome{
    background:linear-gradient(135deg,#2563eb,#1e40af);
    color:#fff;
    padding:32px;
    border-radius:20px;
    box-shadow:0 18px 45px rgba(0,0,0,0.25);
    margin-bottom:40px;
}
.welcome h3{
    font-size:26px;
}
.welcome p{
    margin-top:6px;
    opacity:0.9;
}

/* ===== GRID ===== */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:28px;
}

/* ===== CARD ===== */
.card{
    background:#fff;
    padding:28px;
    border-radius:20px;
    box-shadow:0 15px 40px rgba(0,0,0,0.12);
    transition:0.35s;
}
.card:hover{
    transform:translateY(-8px);
    box-shadow:0 25px 60px rgba(37,99,235,0.35);
}
.card h4{
    font-size:20px;
    color:#1e3a8a;
    margin-bottom:10px;
}
.card p{
    font-size:14px;
    color:#475569;
    margin-bottom:20px;
}
.card a{
    display:inline-block;
    background:#2563eb;
    color:#fff;
    padding:10px 18px;
    border-radius:10px;
    text-decoration:none;
    font-size:14px;
}

/* ===== BADGE ===== */
.badge{
    display:inline-block;
    padding:6px 14px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
    margin-bottom:14px;
}
.pending{
    background:#fff3cd;
    color:#b45309;
}
.completed{
    background:#dcfce7;
    color:#166534;
}

/* ===== FOOTER ===== */
footer{
    margin-top:60px;
    text-align:center;
    color:#64748b;
    padding-bottom:30px;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h2>🧪 Care Weave – Laboratory Dashboard</h2>
    <a href="logout.php" class="logout">Logout</a>
</div>

<!-- CONTENT -->
<div class="container">

    <!-- WELCOME -->
    <div class="welcome">
        <h3>Welcome, Lab Technician</h3>
        <p>Manage lab test requests, upload reports, and verify diagnostics efficiently.</p>
    </div>

    <!-- DASHBOARD CARDS -->
    <div class="grid">

        <!-- PENDING TESTS -->
        <div class="card">
            <span class="badge pending">Pending</span>
            <h4>⏳ Pending Lab Tests</h4>
            <p>View lab test requests sent by doctors that require diagnostics.</p>
            <a href="pending_lab_tests.php">View Pending Tests</a>
        </div>

        <!-- UPLOAD REPORT -->
        <div class="card">
            <h4>📤 Upload Lab Report</h4>
            <p>Upload verified lab reports and attach them to test requests.</p>
            <a href="upload_report.php">Upload Report</a>
        </div>

        <!-- VIEW REPORTS -->
        <div class="card">
            <span class="badge completed">Completed</span>
            <h4>📄 View Lab Reports</h4>
            <p>View and download completed lab reports shared with doctors.</p>
            <a href="view_lab_reports.php">View Reports</a>
        </div>

    </div>

</div>

<footer>
© 2025 Care Weave — Context-Aware Healthcare Platform
</footer>

</body>
</html>
