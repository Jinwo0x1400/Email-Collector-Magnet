<?php
session_start();
if (!isset($_SESSION["user"])) exit("Please <a href='../auth/login.php'>login</a>.");
echo "<h2>Welcome, " . $_SESSION["user"]["org"] . "</h2>";
echo "<p>Email: " . $_SESSION["user"]["email"] . "</p>";
echo "<a href='../api/leads.php'>API Endpoint</a>";
?>
