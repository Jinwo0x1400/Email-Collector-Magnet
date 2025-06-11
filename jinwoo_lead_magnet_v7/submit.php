<?php
$name = strtolower(trim($_POST['name'] ?? ''));
$email = strtolower(trim($_POST['email'] ?? ''));
$ip = $_SERVER['REMOTE_ADDR'];
$time = date("Y-m-d H:i:s");

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) exit("Invalid email.");

// === Check for duplicate ===
$lines = file('leads.csv', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
  if (strpos($line, $email) !== false) {
    exit("🚫 Email already submitted.");
  }
}

// === Auto-Tagging ===
$tag = "General";
if (strpos($email, "free") !== false || strpos($email, "test") !== false) $tag = "Freebie Hunter";
if (strpos($email, "@company.com") !== false) $tag = "Business";
if (strpos($name, "dev") !== false || strpos($name, "seo") !== false) $tag = "Marketer";

// === Save to CSV ===
$line = "\"$time\",\"$ip\",\"$name\",\"$email\",\"$tag\"\n";
file_put_contents("leads.csv", $line, FILE_APPEND);

// === Autoresponder Email ===
$to = $email;
$subject = "Thanks for subscribing!";
$message = "Hi " . ucfirst($name) . ",\n\nThanks for joining our list! We'll keep you updated.";
$headers = "From: hello@yourdomain.com\r\nContent-Type: text/plain";
@mail($to, $subject, $message, $headers);

echo "✅ Submitted successfully as: <b>$tag</b>";
?>
