<?php include "db.php"; ?>
<h2>🛑 Patient Movement History</h2>

<table border="1" cellpadding="10">
<tr>
<th>Bed</th>
<th>Patient</th>
<th>Status</th>
<th>Alert</th>
<th>Time</th>
</tr>

<?php
$q = mysqli_query($conn,"SELECT * FROM bed_movement_logs ORDER BY detected_at DESC");
while($r = mysqli_fetch_assoc($q)){
    echo "<tr>
        <td>{$r['bed_number']}</td>
        <td>{$r['patient_name']}</td>
        <td>{$r['status']}</td>
        <td>{$r['alert_message']}</td>
        <td>{$r['detected_at']}</td>
    </tr>";
}
?>
</table>
