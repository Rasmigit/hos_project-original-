<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

if($role=="doctor" && $username=="doctor" && $password=="doctor123"){
    $_SESSION['role']="doctor";
    header("Location: doctor_dashboard.php");
    exit();
}
elseif($role=="admin" && $username=="admin" && $password=="admin123"){
    $_SESSION['role']="admin";
    header("Location: admin_dashboard.php");
    exit();
}
else{
    echo "<h3>Invalid Login</h3>";
}
?>
