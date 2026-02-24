<?php
$file = 'data/appointments.json';
$appts = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><style>table{width:100%;border-collapse:collapse}th,td{border:1px solid #ddd;padding:6px}</style></head>
<body>
<table>
<tr><th>Name</th><th>Phone</th><th>Doctor</th><th>Date</th><th>Notes</th></tr>
<?php foreach($appts as $a): ?>
<tr>
<td><?= $a['name'] ?></td>
<td><?= $a['phone'] ?></td>
<td><?= $a['doctor'] ?></td>
<td><?= $a['date'] ?></td>
<td><?= $a['notes'] ?></td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>  