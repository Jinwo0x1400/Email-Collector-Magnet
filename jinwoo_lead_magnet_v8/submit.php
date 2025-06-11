<?php
$name = strtolower(trim($_POST['name'] ?? ''));
$email = strtolower(trim($_POST['email'] ?? ''));
$ip = $_SERVER['REMOTE_ADDR'];
$time = date("Y-m-d H:i:s");
$date = date("Y-m-d");
$filename = "leads-$date.csv";

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) exit("Invalid email.");

// Duplicate filter
if (file_exists($filename)) {
  $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($lines as $line) {
    if (strpos($line, $email) !== false) {
      exit("🚫 Email already submitted today.");
    }
  }
}

// Tagging
$tag = "General";
if (strpos($email, "free") !== false || strpos($email, "test") !== false) $tag = "Freebie Hunter";
if (strpos($email, "@company.com") !== false) $tag = "Business";
if (strpos($name, "dev") !== false || strpos($name, "seo") !== false) $tag = "Marketer";

// Save to daily CSV
$line = "\"$time\",\"$ip\",\"$name\",\"$email\",\"$tag\"\n";
file_put_contents($filename, $line, FILE_APPEND);

// Discord/Slack Webhook
$webhook_url = "YOUR_DISCORD_OR_SLACK_WEBHOOK";
$msg = [
  "content" => "**New Lead**\nName: $name\nEmail: $email\nIP: $ip\nTag: $tag"
];
$options = [
  'http' => [
    'header'  => "Content-type: application/json",
    'method'  => 'POST',
    'content' => json_encode($msg),
  ]
];
@file_get_contents($webhook_url, false, stream_context_create($options));

// Autoresponder
$headers = "From: notify@yourdomain.com\r\nContent-Type: text/plain";
@mail($email, "Thanks for Joining", "Hi $name,\n\nYou're now tagged as '$tag'. Stay tuned!", $headers);

echo "✅ Saved as <b>$tag</b> on $date";
?>
