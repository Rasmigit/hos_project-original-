<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Lab Login | Care Weave</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body{
    background:linear-gradient(135deg,#0b1f3a,#102e52);
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family:'Poppins',sans-serif;
}

.login-box{
    background:white;
    padding:40px;
    width:360px;
    border-radius:18px;
    box-shadow:0 25px 60px rgba(0,0,0,0.45);
}
.login-box h2{
    text-align:center;
    margin-bottom:20px;
    color:#1e3a8a;
}
input{
    width:100%;
    padding:12px;
    margin-top:12px;
    border-radius:10px;
    border:1px solid #cbd5f5;
}
button{
    width:100%;
    margin-top:20px;
    padding:12px;
    background:#2563eb;
    color:white;
    border:none;
    border-radius:10px;
    font-size:16px;
    cursor:pointer;
}
</style>
</head>

<body>

<div class="login-box">
    <h2>🧪 Lab Login</h2>
    <form method="post" action="check_lab_login.php">
        <input type="text" name="username" placeholder="Lab Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
