<?php
require 'score.php';
$payload = [
  'name' => trim($_POST['name'] ?? ''),
  'email' => trim($_POST['email'] ?? ''),
  'ip' => $_SERVER['REMOTE_ADDR'],
  'campaign' => $_POST['campaign'] ?? 'default',
  'created' => date("Y-m-d H:i:s")
];

$payload['score'] = score_lead($payload['name'], $payload['email'], $payload['ip']);
$payload['tag'] = $payload['score'] > 80 ? "High Value" : ($payload['score'] > 50 ? "Potential" : "Low Quality");

// SQLite DB
$db = new PDO("sqlite:db.sqlite");
$stmt = $db->prepare("INSERT INTO leads (name,email,ip,tag,created,campaign) VALUES (?,?,?,?,?,?)");
$stmt->execute([$payload['name'], $payload['email'], $payload['ip'], $payload['tag'], $payload['created'], $payload['campaign']]);

// Webhook dispatch
$hooks = json_decode(file_get_contents("webhooks.json"), true);
if (isset($hooks[$payload['campaign']])) {
  foreach ($hooks[$payload['campaign']] as $url) {
    $opts = ['http' => ['method' => 'POST','header'=>'Content-Type:application/json','content'=>json_encode($payload)]];
    @file_get_contents($url, false, stream_context_create($opts));
  }
}

// Response
echo "<div style='color:lime;font-family:monospace'>✅ SUBMITTED to campaign <b>{$payload['campaign']}</b><br>SCORE: {$payload['score']} | TAG: {$payload['tag']}</div>";
?>
