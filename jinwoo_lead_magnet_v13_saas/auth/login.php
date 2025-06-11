<?php
session_start();
$db = new PDO("sqlite:../db.sqlite");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $pass = $_POST["pass"];
    $stmt = $db->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($pass, $user["password"])) {
        $_SESSION["user"] = $user;
        header("Location: ../dashboard/index.php");
        exit;
    } else {
        echo "❌ Login failed.";
    }
}
?>
<form method="post">
  <input name="email" type="email" placeholder="Email" required><br>
  <input name="pass" type="password" placeholder="Password" required><br>
  <button>Login</button>
</form>
