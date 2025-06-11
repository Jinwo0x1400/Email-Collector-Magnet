<?php
session_start();
$db = new PDO("sqlite:db.sqlite");
$users = ["admin" => "jinwoo1400", "viewer" => "viewonly1400"];

if (!isset($_SESSION['role'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $u = $_POST['user'];
        $p = $_POST['pass'];
        if (isset($users[$u]) && $users[$u] === $p) $_SESSION['role'] = $u;
        else exit("Login failed");
    } else {
        echo "<form method='post'><input name='user'><input name='pass' type='password'><button>Login</button></form>";
        exit;
    }
}

if ($_SESSION['role'] === 'admin') {
    if (isset($_POST['delete'])) {
        $stmt = $db->prepare("DELETE FROM leads WHERE id=?");
        $stmt->execute([$_POST['delete']]);
    }
    if (isset($_POST['edit'])) {
        $stmt = $db->prepare("UPDATE leads SET name=?, email=?, tag=? WHERE id=?");
        $stmt->execute([$_POST['name'], $_POST['email'], $_POST['tag'], $_POST['id']]);
    }
}

$data = $db->query("SELECT * FROM leads ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
echo "<h2>🧠 Panel ({$_SESSION['role']})</h2><a href='dashboard.php'>📊 Dashboard</a> | <a href='export.php'>📁 Export XLSX</a><br><br>";
echo "<table border=1 cellpadding=5 style='background:white;color:black;font-family:monospace'><tr><th>ID</th><th>Name</th><th>Email</th><th>Tag</th><th>IP</th><th>Time</th><th>Action</th></tr>";
foreach ($data as $row) {
    echo "<tr>
    <form method='post'>
    <td>{$row['id']}<input type='hidden' name='id' value='{$row['id']}'></td>
    <td><input name='name' value='{$row['name']}'></td>
    <td><input name='email' value='{$row['email']}'></td>
    <td><input name='tag' value='{$row['tag']}'></td>
    <td>{$row['ip']}</td>
    <td>{$row['created']}</td>
    <td>";
    if ($_SESSION['role'] === 'admin') {
        echo "<button name='edit'>✏️</button> <button name='delete' value='{$row['id']}'>🗑</button>";
    } else {
        echo "-";
    }
    echo "</td></form></tr>";
}
echo "</table>";
?>
