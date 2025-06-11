<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $org = trim($_POST["org"]);
    $email = trim($_POST["email"]);
    $pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);

    $db = new PDO("sqlite:../db.sqlite");
    $stmt = $db->prepare("INSERT INTO users (org, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$org, $email, $pass]);
    echo "✅ Registered. <a href='login.php'>Login</a>";
    exit;
}
?>
<form method="post">
  <input name="org" placeholder="Organization" required><br>
  <input name="email" type="email" placeholder="Email" required><br>
  <input name="pass" type="password" placeholder="Password" required><br>
  <button>Register</button>
</form>
