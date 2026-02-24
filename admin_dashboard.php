<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("Location: admin_login.php");
    exit();
}
include "db.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard | Care Weave</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
body{
    font-family:Poppins;
    background:#f4f7fb;
    margin:0;
    padding:30px;
}

/* ===== EMERGENCY FULL SCREEN BLINK ===== */
body.emergency {
    animation: screenBlink 1s infinite;
}
@keyframes screenBlink {
    0%   { background:#fee2e2; }
    50%  { background:#fecaca; }
    100% { background:#fee2e2; }
}

.header{
    background:#0f2e4d;
    color:#fff;
    padding:20px 30px;
    border-radius:15px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.logout{
    background:#ef4444;
    color:white;
    padding:8px 18px;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
}
.card{
    background:#fff;
    padding:25px;
    border-radius:18px;
    margin-top:30px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}
table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}
th,td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #e5e7eb;
}
th{
    background:#2563eb;
    color:#fff;
}

/* STATUS COLORS */
.pending{color:#f59e0b;font-weight:600}
.verified{color:#16a34a;font-weight:600}

/* IOT ROW ALERT */
.alert-move{
    background:#fee2e2;
    color:#b91c1c;
    font-weight:700;
    animation: blinkRow 1s infinite;
}
@keyframes blinkRow{
    0%{background:#fee2e2;}
    50%{background:#fecaca;}
    100%{background:#fee2e2;}
}

/* POPUP */
.popup-overlay{
    position:fixed;
    top:0;left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.7);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:9999;
}
.popup-box{
    background:#fff;
    padding:30px;
    width:380px;
    border-radius:15px;
    text-align:center;
}
.popup-box h2{color:#dc2626;}
.popup-box button{
    background:#2563eb;
    color:#fff;
    border:none;
    padding:10px 22px;
    border-radius:8px;
    cursor:pointer;
}
</style>
</head>

<body>

<div class="header">
    <h2>👨‍💼 Admin Dashboard – Care Weave</h2>
    <a href="logout.php" class="logout">Logout</a>
</div>

<!-- ================= BLOOD DONORS (UNCHANGED) ================= -->
<div class="card">
<h3>🩸 Blood Donor Verification</h3>
<table>
<tr>
<th>ID</th><th>Name</th><th>Group</th><th>Mobile</th>
<th>Document</th><th>Status</th><th>Action</th>
</tr>

<?php
$donors = mysqli_query($conn,"SELECT * FROM blood_donors ORDER BY id DESC");
while($d=mysqli_fetch_assoc($donors)){
?>
<tr>
<td><?= $d['id'] ?></td>
<td><?= $d['full_name'] ?></td>
<td><?= $d['blood_group'] ?></td>
<td><?= $d['mobile'] ?></td>
<td>
<?php if($d['document_file']){ ?>
<a target="_blank" href="uploads/donors/<?= $d['document_file'] ?>">View</a>
<?php } else echo "No File"; ?>
</td>
<td class="<?= strtolower($d['verification_status']) ?>">
<?= $d['verification_status'] ?>
</td>
<td>
<?php if($d['verification_status']!=='Verified'){ ?>
<a href="verify_donor.php?id=<?= $d['id'] ?>">Approve</a>
<?php } else echo "-"; ?>
</td>
</tr>
<?php } ?>
</table>
</div>

<!-- ================= PHARMACY ORDERS (UNCHANGED) ================= -->
<div class="card">
<h3>💊 Pharmacy Orders</h3>
<table>
<tr>
<th>ID</th><th>Patient</th><th>Phone</th><th>Doctor</th>
<th>Medicines</th><th>Prescription</th><th>Date</th>
</tr>

<?php
$orders=mysqli_query($conn,"SELECT * FROM orders ORDER BY order_time DESC");
while($o=mysqli_fetch_assoc($orders)){
?>
<tr>
<td><?= $o['id'] ?></td>
<td><?= $o['customer'] ?></td>
<td><?= $o['phone'] ?></td>
<td><?= $o['doctor_name'] ?></td>
<td><?= $o['items'] ?></td>
<td>
<?php if($o['prescription_file']){ ?>
<a target="_blank" href="<?= $o['prescription_file'] ?>">View Prescription</a>
<?php } else echo "Not Uploaded"; ?>
</td>
<td><?= $o['order_time'] ?></td>
</tr>
<?php } ?>
</table>
</div>

<!-- ================= IOT PATIENT BED MONITORING (ONLY MODIFIED) ================= -->
<div class="card">
<h3>🛏️ IoT Patient Bed Monitoring</h3>

<table>
<thead>
<tr>
<th>Bed</th>
<th>Status</th>
<th>Updated</th>
</tr>
</thead>
<tbody id="bedData">
<tr><td colspan="3">Waiting for ESP32 data...</td></tr>
</tbody>
</table>
</div>

<!-- AUDIO -->
<audio id="alertSound" preload="auto">
    <source src="assets/alert.mp3" type="audio/mpeg">
</audio>

<!-- POPUP -->
<div class="popup-overlay" id="alertPopup">
    <div class="popup-box">
        <h2>🚨 Emergency Alert</h2>
        <p>Patient movement detected.<br>Please attend immediately.</p>
        <button onclick="acknowledgeAlert()">Acknowledge</button>
    </div>
</div>

<script>
let lastStatus = "";
let soundEnabled = false;
const alertSound = document.getElementById("alertSound");

document.addEventListener("click", () => {
    soundEnabled = true;
}, { once:true });

function acknowledgeAlert(){
    stopAlert();
}

function startAlert(){
    document.body.classList.add("emergency");
    document.getElementById("alertPopup").style.display = "flex";
    if(soundEnabled){
        alertSound.currentTime = 0;
        alertSound.play().catch(()=>{});
    }
}

function stopAlert(){
    document.body.classList.remove("emergency");
    document.getElementById("alertPopup").style.display = "none";
    alertSound.pause();
    alertSound.currentTime = 0;
}

function loadBeds(){
    fetch("fetch_bed_status.php")
    .then(res=>res.text())
    .then(data=>{
        document.getElementById("bedData").innerHTML = data;

        if(data.includes("Movement Detected") && lastStatus!=="Movement Detected"){
            lastStatus="Movement Detected";
            startAlert();
        }
        if(!data.includes("Movement Detected")){
            lastStatus="No Movement";
            stopAlert();
        }
    });
}

loadBeds();
setInterval(loadBeds,5000);
</script>

</body>
</html>