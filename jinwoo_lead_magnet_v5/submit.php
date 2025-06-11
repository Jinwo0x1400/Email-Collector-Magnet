<?php
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'];
$date = date("Y-m-d");
$time = date("Y-m-d H:i:s");

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) exit("Invalid email.");

// IP to Country (basic)
$country = "Unknown";
$ipData = @json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));
if ($ipData && $ipData->status === "success") {
    $country = $ipData->country;
}

// Save to CSV
$line = "\"$time\",\"$ip\",\"$name\",\"$email\",\"$country\"\n";
file_put_contents("leads.csv", $line, FILE_APPEND);

// Push to Firebase
$data = json_encode([
  "name" => $name,
  "email" => $email,
  "ip" => $ip,
  "date" => $date,
  "country" => $country
]);
$ch = curl_init("https://your-project-default-rtdb.firebaseio.com/leads.json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_exec($ch);
curl_close($ch);

echo "✅ Thank you, your data is saved!";
?>
