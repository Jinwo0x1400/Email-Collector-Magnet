<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$db = new PDO("sqlite:db.sqlite");
$data = $db->query("SELECT * FROM leads")->fetchAll(PDO::FETCH_ASSOC);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->fromArray(array_keys($data[0]), NULL, 'A1');
$row = 2;
foreach ($data as $lead) {
    $sheet->fromArray(array_values($lead), NULL, 'A'.$row++);
}

$filename = "leads_export.xlsx";
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=$filename");
$writer = new Xlsx($spreadsheet);
$writer->save("php://output");
exit;
?>
