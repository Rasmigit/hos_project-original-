<?php
$error = isset($_GET['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Doctor Login | Care Weave</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
:root{
    --accent:#2f6df6;      /* Doctor Blue */
    --bg1:#061a33;
    --bg2:#0b2e4f;
    --card:#ffffff;
    --text:#0b2e4f;
}
body.dark{
    --card:#0f172a;
    --text:#e5e7eb;
    background:#020617;
}
*{ box-sizing:border-box; font-family:Poppins,sans-serif; }

body{
    margin:0;
    min-height:100vh;
    background:linear-gradient(135deg,var(--bg1),var(--bg2));
    display:flex;
    align-items:center;
    justify-content:center;
    color:var(--text);
}

.login-card{
    width:420px;
    background:var(--card);
    padding:40px;
    border-radius:22px;
    box-shadow:0 40px 80px rgba(0,0,0,.35);
}

.title{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
}
.title h2{
    margin:0;
    color:var(--accent);
}
.toggle{
    cursor:pointer;
    font-size:18px;
}

p{
    margin:0 0 22px;
    color:#94a3b8;
    font-size:14px;
}

input{
    width:100%;
    padding:14px;
    margin-bottom:14px;
    border-radius:12px;
    border:1px solid #cbd5e1;
    font-size:14px;
}
input:focus{
    outline:none;
    border-color:var(--accent);
}

.password-box{
    position:relative;
}
.password-box span{
    position:absolute;
    right:14px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    color:#64748b;
}

button{
    width:100%;
    padding:14px;
    background:var(--accent);
    border:none;
    color:#fff;
    border-radius:14px;
    font-size:16px;
    cursor:pointer;
}
button:hover{ opacity:.9; }

.error{
    background:#fee2e2;
    color:#991b1b;
    padding:10px;
    border-radius:10px;
    font-size:13px;
    margin-bottom:14px;
}

.footer{
    text-align:center;
    margin-top:18px;
    font-size:12px;
    color:#94a3b8;
}
</style>
</head>

<body>

<div class="login-card">
    <div class="title">
        <h2>👨‍⚕️ Doctor Login</h2>
        <div class="toggle" onclick="toggleDark()">🌙</div>
    </div>

    <p>Care Weave clinical access</p>

    <?php if($error): ?>
        <div class="error">Invalid username or password</div>
    <?php endif; ?>

    <form method="post" action="check_login.php">
        <input type="text" name="username" placeholder="Doctor Username" required>

        <div class="password-box">
            <input type="password" id="pass" name="password" placeholder="Password" required>
            <span onclick="togglePass()">👁️</span>
        </div>

        <input type="hidden" name="role" value="doctor">
        <button type="submit">Login</button>
    </form>

    <div class="footer">Secure medical system</div>
</div>

<script>
function togglePass(){
    let p=document.getElementById("pass");
    p.type = p.type==="password" ? "text":"password";
}
function toggleDark(){
    document.body.classList.toggle("dark");
}
</script>

</body>
</html>
