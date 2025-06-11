<?php
require 'score.php';
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$ip = $_SERVER['REMOTE_ADDR'];
$created = date("Y-m-d H:i:s");
$score = score_lead($name, $email, $ip);

// SQLite insert
$db = new PDO("sqlite:db.sqlite");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->prepare("INSERT INTO leads (name,email,ip,tag,created) VALUES (?,?,?,?,?)");
$tag = $score > 80 ? "High Value" : ($score > 50 ? "Potential" : "Low Quality");
$stmt->execute([$name, $email, $ip, $tag, $created]);

// Send Email
@mail($email, "Thanks", "Hi $name, you're tagged as $tag (score: $score)", "From: notify@yourdomain.com");

// Telegram Notify
$token = "YOUR_BOT_TOKEN";
$chat_id = "YOUR_CHAT_ID";
$msg = "🆕 New Lead\n$name ($email)\nTag: $tag\nScore: $score\nIP: $ip";
file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($msg));

// WhatsApp Notify (CallMeBot)
$wa_api = "https://api.callmebot.com/whatsapp.php";
$wa_msg = urlencode("New Lead: $name ($email) - $tag [$score]");
file_get_contents("$wa_api?phone=YOUR_PHONE&text=$wa_msg&apikey=YOUR_API_KEY");

echo "✅ Submitted: <b>$tag</b> (Score: $score)";
?>
