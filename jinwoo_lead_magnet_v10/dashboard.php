<?php
$db = new PDO("sqlite:db.sqlite");
$data = $db->query("SELECT tag, created FROM leads")->fetchAll(PDO::FETCH_ASSOC);
$tags = [];
$dates = [];
foreach ($data as $row) {
    $tag = $row['tag'];
    $date = substr($row['created'], 0, 10);
    $tags[$tag] = ($tags[$tag] ?? 0) + 1;
    $dates[$date] = ($dates[$date] ?? 0) + 1;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>📊 Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: sans-serif; background: #111; color: white; text-align: center; padding: 30px; }
    canvas { background: #fff; border-radius: 8px; margin: 20px auto; display: block; }
  </style>
</head>
<body>
<h2>📈 Leads Overview</h2>
<canvas id="dateChart" width="600" height="300"></canvas>
<canvas id="tagChart" width="600" height="300"></canvas>
<script>
new Chart(document.getElementById('dateChart'), {
  type: 'bar',
  data: {
    labels: <?= json_encode(array_keys($dates)) ?>,
    datasets: [{ label: "Leads per Day", data: <?= json_encode(array_values($dates)) ?>, backgroundColor: "limegreen" }]
  }
});
new Chart(document.getElementById('tagChart'), {
  type: 'pie',
  data: {
    labels: <?= json_encode(array_keys($tags)) ?>,
    datasets: [{ label: "Tags", data: <?= json_encode(array_values($tags)) ?>, backgroundColor: ["gold","red","blue","orange"] }]
  }
});
</script>
</body>
</html>
