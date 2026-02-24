<?php
session_start();
include "db.php";

$username = $_POST['username'];
$password = $_POST['password'];

/* RUN QUERY */
$query = "SELECT * FROM lab_users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);

/* CHECK QUERY EXECUTION */
if($result === false){
    die("SQL Error: " . mysqli_error($conn));
}

/* CHECK LOGIN */
if(mysqli_num_rows($result) == 1){
    $_SESSION['lab_user'] = $username;
    header("Location: lab_dashboard.php");
    exit();
}else{
    echo "❌ Invalid Lab Login";
}
