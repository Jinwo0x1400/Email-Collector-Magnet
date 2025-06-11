<?php
$db = new PDO("sqlite:db.sqlite");
$db->exec("CREATE TABLE IF NOT EXISTS leads (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT, email TEXT, ip TEXT, tag TEXT, created TEXT
)");
echo "✅ SQLite DB created.";
?>
