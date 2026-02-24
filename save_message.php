<?php
function clean($s){ return htmlspecialchars(trim($s)); }
$msg = [
'name'=>clean($_POST['name'] ?? 'Guest'),
'message'=>clean($_POST['message'] ?? ''),
'time'=>date('Y-m-d H:i:s')
];
@mkdir('data');
$file = 'data/messages.json';
$data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
$data[] = $msg;
file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
// small response for fetch
http_response_code(204);
exit;
?> 