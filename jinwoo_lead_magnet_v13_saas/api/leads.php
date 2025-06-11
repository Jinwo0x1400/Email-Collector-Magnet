<?php
header("Content-Type: application/json");
$db = new PDO("sqlite:../db.sqlite");

$input = json_decode(file_get_contents("php://input"), true);
$name = $input["name"] ?? '';
$email = $input["email"] ?? '';
$ip = $_SERVER["REMOTE_ADDR"];
$campaign = $input["campaign"] ?? 'default';
$created = date("Y-m-d H:i:s");

$stmt = $db->prepare("INSERT INTO leads (name,email,ip,tag,created,campaign) VALUES (?,?,?,?,?,?)");
$stmt->execute([$name, $email, $ip, "API", $created, $campaign]);

echo json_encode(["status" => "ok", "name" => $name, "email" => $email]);
?>
