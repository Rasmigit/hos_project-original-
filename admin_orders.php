<?php
include "db.php";
$result = mysqli_query($conn, "SELECT * FROM orders ORDER BY order_time DESC");
?>

<table>
<tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Phone</th>
    <th>Address</th>
    <th>Medicines</th>
    <th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['customer'] ?></td>
    <td><?= $row['phone'] ?></td>
    <td><?= $row['address'] ?></td>
    <td><?= $row['items'] ?></td>
    <td><?= $row['order_time'] ?></td>
</tr>
<?php } ?>
</table>
