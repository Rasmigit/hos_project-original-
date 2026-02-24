<?php
include "db.php";

$result = mysqli_query($conn, "SELECT * FROM blood_donors");

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Blood Donors | Care Weave</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .page-section {
            max-width: 1100px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        h2 {
            color: #0d6efd;
            text-align: center;
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #0d6efd;
            color: white;
            padding: 12px;
        }
        td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background: #f1f5ff;
        }
        .back-btn {
            display: inline-block;
            margin-top: 25px;
            background: #0d6efd;
            color: white;
            padding: 10px 22px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<header class="header">
    <div class="overlay"></div>
    <h1>Care Weave – A Context-Aware Healthcare Platform</h1>
    <p>Compassionate care. Advanced medicine.</p>
</header>

<div class="page-section">
    <h2>Registered Blood Donors</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Blood Group</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Address</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['full_name']; ?></td>
            <td><?php echo $row['age']; ?></td>
            <td><?php echo $row['gender']; ?></td>
            <td><?php echo $row['blood_group']; ?></td>
            <td><?php echo $row['mobile']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['address']; ?></td>
        </tr>
        <?php } ?>
    </table>

    <a href="index.html" class="back-btn">← Back to Home</a>
</div>

</body>
</html>
