<?php
$password = 'jinwoo1400';
session_start();

if (!isset($_SESSION['loggedin'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['pass'] === $password) {
        $_SESSION['loggedin'] = true;
    } else {
        echo '<form method="post" style="text-align:center;margin-top:100px;">
                <input type="password" name="pass" placeholder="Enter password">
                <button>Login</button>
              </form>';
        exit;
    }
}

$csv = file('leads.csv');
echo "<h2 style='font-family:Arial;text-align:center;'>📋 Lead List Viewer</h2>";
echo "<div style='text-align:center;'><a href='leads.csv' download><button style='padding:10px;background:black;color:white;'>⬇ Download CSV</button></a></div>";
echo "<table border='1' cellpadding='10' style='margin:30px auto;font-family:monospace;background:white;color:black;'>";
foreach ($csv as $line) {
    echo "<tr>";
    foreach (str_getcsv($line) as $cell) {
        echo "<td>" . htmlspecialchars($cell) . "</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>
