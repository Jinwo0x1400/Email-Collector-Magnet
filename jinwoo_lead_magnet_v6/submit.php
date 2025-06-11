<?php
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'];
$time = date("Y-m-d H:i:s");

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) exit("Invalid email.");

// Save to CSV
$line = "\"$time\",\"$ip\",\"$name\",\"$email\"\n";
file_put_contents("leads.csv", $line, FILE_APPEND);

// NOTION API
$notion_token = "YOUR_NOTION_SECRET";
$database_id = "YOUR_DATABASE_ID";

$notion_data = json_encode([
  "parent" => [ "database_id" => $database_id ],
  "properties" => [
    "Name" => [ "title" => [[ "text" => [ "content" => $name ] ]] ],
    "Email" => [ "email" => $email ],
    "IP" => [ "rich_text" => [[ "text" => [ "content" => $ip ] ]] ]
  ]
]);

$notion_headers = [
  "Authorization: Bearer $notion_token",
  "Content-Type: application/json",
  "Notion-Version: 2022-06-28"
];

$ch = curl_init("https://api.notion.com/v1/pages");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $notion_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $notion_headers);
curl_exec($ch);
curl_close($ch);

// MAILCHIMP API
$mailchimp_api = "YOUR_API_KEY";
$list_id = "YOUR_LIST_ID";
$data_center = substr($mailchimp_api,strpos($mailchimp_api,'-')+1);

$mc_data = json_encode([ "email_address" => $email, "status" => "subscribed", "merge_fields" => [ "FNAME" => $name ] ]);
$ch = curl_init("https://$data_center.api.mailchimp.com/3.0/lists/$list_id/members/");
curl_setopt($ch, CURLOPT_USERPWD, "user:$mailchimp_api");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $mc_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_exec($ch);
curl_close($ch);

echo "✅ Success! You’ve been added.";
?>
