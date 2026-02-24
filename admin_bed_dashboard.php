<?php
$conn = new mysqli("localhost", "root", "", "hos_project");
if ($conn->connect_error) die("DB Error");

$result = $conn->query("SELECT * FROM bed_status ORDER BY bed_number");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Care Weave – Bed Monitoring</title>
  <meta http-equiv="refresh" content="5">
  <style>
    body {
      font-family: Arial;
      background: #f4f6f9;
      padding: 20px;
    }
    h1 {
      color: #0a4fa3;
      text-align: center;
    }
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px,1fr));
      gap: 20px;
      margin-top: 30px;
    }
    .card {
      background: white;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .active {
      color: green;
      font-weight: bold;
    }
    .inactive {
      color: red;
      font-weight: bold;
    }
  </style>
</head>

<body>
<h1>Care Weave – Patient Bed Status</h1>

<div class="grid">
<?php while($row = $result->fetch_assoc()) { ?>
  <div class="card">
    <h2>Bed <?php echo $row['bed_number']; ?></h2>
    <p class="<?php echo ($row['status']=="Movement Detected")?"active":"inactive"; ?>">
      <?php echo $row['status']; ?>
    </p>
    <small>Updated: <?php echo $row['updated_at']; ?></small>
  </div>
<?php } ?>
</div>

</body>
</html>