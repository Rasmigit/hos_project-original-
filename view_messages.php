<?php
// CONNECT TO DATABASE
$conn = new mysqli("localhost", "root", "", "hospital");

// CHECK CONNECTION
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// GET ALL MESSAGES
$result = $conn->query("SELECT * FROM messages ORDER BY id DESC");

// SHOW MESSAGES
echo "<table border='1' cellpadding='8' style='width:100%; border-collapse:collapse;'>
<tr style='background:#f0f0f0; font-weight:bold;'>
<th>Name</th>
<th>Message</th>
<th>Time</th>
</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$row['name']}</td>
    <td>{$row['message']}</td>
    <td>{$row['created_at']}</td>
    </tr>";
}

echo "</table>";
?>
