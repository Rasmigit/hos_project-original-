<?php
$symptoms = $_POST['symptoms'] ?? [];

function has($s){
    global $symptoms;
    return in_array($s,$symptoms);
}

$disease = "No clear disease detected";
$severity = "Low";
$confidence = 40;

if(has("fever") && has("cough") && has("cold")){
    $disease = "Common Cold / Viral Infection";
    $severity = "Low";
    $confidence = 70;
}
elseif(has("fever") && has("body_pain") && has("fatigue")){
    $disease = "Influenza / Viral Fever";
    $severity = "Medium";
    $confidence = 80;
}
elseif(has("chest_pain") && has("breathing")){
    $disease = "Possible Cardiac / Respiratory Issue";
    $severity = "High";
    $confidence = 90;
}
elseif(has("vomiting") && has("diarrhea")){
    $disease = "Food Poisoning / Gastroenteritis";
    $severity = "Medium";
    $confidence = 75;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Prediction Result</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Poppins',sans-serif;
    background:#f4f7fb;
    padding:40px;
}

.result{
    max-width:700px;
    margin:auto;
    background:white;
    padding:35px;
    border-radius:18px;
    box-shadow:0 20px 40px rgba(0,0,0,0.12);
    animation:fade 0.7s ease;
}

@keyframes fade{
    from{opacity:0; transform:scale(0.95);}
    to{opacity:1; transform:scale(1);}
}

.badge{
    display:inline-block;
    padding:6px 14px;
    border-radius:20px;
    font-size:13px;
    color:white;
}

.low{background:#27ae60;}
.medium{background:#f39c12;}
.high{background:#e74c3c;}

.bar{
    height:12px;
    background:#eee;
    border-radius:8px;
    overflow:hidden;
    margin-top:10px;
}

.fill{
    height:100%;
    background:#0b2e4f;
}

.back{
    margin-top:20px;
    display:inline-block;
    text-decoration:none;
    background:#0b2e4f;
    color:white;
    padding:10px 18px;
    border-radius:8px;
}
</style>
</head>

<body>

<div class="result">
<h2>🧠 AI Prediction Result</h2>

<p><b>Possible Disease:</b><br><?php echo $disease; ?></p>

<p>
<b>Severity:</b>
<span class="badge <?php echo strtolower($severity); ?>">
<?php echo $severity; ?>
</span>
</p>

<p><b>Confidence Level:</b> <?php echo $confidence; ?>%</p>
<div class="bar">
<div class="fill" style="width:<?php echo $confidence; ?>%"></div>
</div>

<a href="symptom_checker.html" class="back">← Check Again</a>
</div>

</body>
</html>
