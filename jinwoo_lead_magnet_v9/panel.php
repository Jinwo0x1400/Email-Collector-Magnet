<?php
session_start();
$db = new PDO("sqlite:db.sqlite");

$users = ["admin" => "jinwoo1400", "viewer" => "viewonly1400"];
if (!isset($_SESSION['role'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        if (isset($users[$user]) && $users[$user] === $pass) {
            $_SESSION['role'] = $user;
        } else {
            exit("<form method='post'><input name='user'><input name='pass' type='password'><button>Login</button></form><p>Wrong login</p>");
        }
    } else {
        exit("<form method='post'><input name='user'><input name='pass' type='password'><button>Login</button></form>");
    }
}

$search = $_GET['q'] ?? '';
$stmt = $db->prepare("SELECT * FROM leads WHERE name LIKE ? OR email LIKE ? ORDER BY id DESC");
$stmt->execute(["%$search%", "%$search%"]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>🧠 Lead Panel (".$_SESSION['role'].")</h2>";
echo "<form><input name='q' value='$search'><button>Search</button></form>";
echo "<table border=1 cellpadding=5 style='background:white;color:black;font-family:monospace'><tr><th>ID</th><th>Name</th><th>Email</th><th>IP</th><th>Tag</th><th>Time</th></tr>";
foreach ($data as $row) {
    echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['email']}</td><td>{$row['ip']}</td><td>{$row['tag']}</td><td>{$row['created']}</td></tr>";
}
echo "</table>";
?>
