<?php
include "db.php";

/*
  Fetch the LATEST bed status
  (ESP32 updates this table every 5 seconds)
*/
$q = mysqli_query($conn, "
    SELECT bed_number, status, updated_at 
    FROM bed_status 
    ORDER BY updated_at DESC 
    LIMIT 1
");

/* If no ESP32 data yet */
if (!$q || mysqli_num_rows($q) == 0) {
    echo "<tr>
            <td colspan='3'>No IoT data yet</td>
          </tr>";
    exit;
}

$r = mysqli_fetch_assoc($q);

/* Decide alert style */
$alertClass = ($r['status'] === "Movement Detected")
    ? "alert-move"
    : "alert-safe";

/*
  IMPORTANT:
  data-status is REQUIRED for JS
*/
echo "<tr class='{$alertClass}' data-status='{$r['status']}'>";
echo "<td>Bed {$r['bed_number']}</td>";
echo "<td>{$r['status']}</td>";
echo "<td>{$r['updated_at']}</td>";
echo "</tr>";