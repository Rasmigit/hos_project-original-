<?php
$file = 'data/orders.json';
$ords = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
?>
<!doctype html>
<html><head><meta charset="utf-8"><style>table{width:100%;border-collapse:collapse}th,td{border:1px solid #ddd;padding:6px}</style></head>
<body>
<table>
<tr><th>Customer</th><th>Phone</th><th>Address</th><th>Items</th><th>Time</th></tr>
<?php foreach($ords as $o): ?>
<tr>
<td><?= $o['customer'] ?></td>
<td><?= $o['phone'] ?></td>
<td><?= $o['address'] ?></td>
<td><?= $o['items'] ?></td>
<td><?= $o['time'] ?></td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html> 