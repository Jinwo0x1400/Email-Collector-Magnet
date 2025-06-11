<?php
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'];
$time = date("Y-m-d H:i:s");

// Basic validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) exit("Invalid email.");

// Save locally
$line = "\"$time\",\"$ip\",\"$name\",\"$email\"\n";
file_put_contents("leads.csv", $line, FILE_APPEND);

// Send to Google Sheets
$sheet_url = "https://script.google.com/macros/s/YOUR_DEPLOYED_URL_HERE/exec";
$params = http_build_query([
    'ip' => $ip,
    'name' => $name,
    'email' => $email
]);
@file_get_contents($sheet_url . '?' . $params);

// Telegram Notification
$botToken = "YOUR_BOT_TOKEN";
$chatId = "YOUR_CHAT_ID";
$teleMsg = "📥 New Lead\nName: $name\nEmail: $email\nIP: $ip";
@file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($teleMsg));

// Email Notification
$to = "your@email.com";
$subject = "New Lead - $name";
$message = "Time: $time\nName: $name\nEmail: $email\nIP: $ip";
$headers = "From: notifier@yourdomain.com";
@mail($to, $subject, $message, $headers);

echo "✅ Successfully submitted!";
?>
