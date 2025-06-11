<?php
$name = strtolower(trim($_POST['name'] ?? ''));
$email = strtolower(trim($_POST['email'] ?? ''));
$ip = $_SERVER['REMOTE_ADDR'];
$created = date("Y-m-d H:i:s");

// Connect DB
$db = new PDO("sqlite:db.sqlite");
$stmt = $db->prepare("SELECT COUNT(*) FROM leads WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetchColumn() > 0) exit("🚫 Email already exists.");

// Tagging
$tag = "General";
if (strpos($email, "free") !== false || strpos($email, "test") !== false) $tag = "Freebie Hunter";
if (strpos($email, "@company.com") !== false) $tag = "Business";
if (strpos($name, "dev") !== false || strpos($name, "seo") !== false) $tag = "Marketer";

// Insert
$stmt = $db->prepare("INSERT INTO leads (name,email,ip,tag,created) VALUES (?,?,?,?,?)");
$stmt->execute([$name, $email, $ip, $tag, $created]);

// Autoresponder
@mail($email, "Thanks", "Hi $name, you're tagged as $tag", "From: notify@yourdomain.com");

echo "✅ Submitted with tag: <b>$tag</b>";
?>
