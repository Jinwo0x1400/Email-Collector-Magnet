<?php
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'];
$time = date("Y-m-d H:i:s");

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Invalid email.");
}

$line = ""$time","$ip","$name","$email"\n";
file_put_contents("leads.csv", $line, FILE_APPEND);

// Optional: Telegram notification
// $botToken = "123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11";
// $chatId = "123456789";
// $message = "New Lead:\nName: $name\nEmail: $email\nIP: $ip";
// file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($message));

echo "✅ Thank you! You are now subscribed.";
?>
