<?php

include '../include/config.inc.php';

$table = isset($_GET['module']) ? $_GET['module'] : 'logs';
$draw = isset($_GET['draw']) ? $_GET['draw'] : 1;
$start = isset($_GET['start']) ? $_GET['start'] : 0;
$length = isset($_GET['length']) ? $_GET['length'] : $arrConfig["pagination"];

$total = my_query("SELECT COUNT(*) as total FROM $table")[0]['total'];

$records = my_query("SELECT * FROM $table LIMIT $start, $length");

$list_records = [];
foreach ($records as $record) {
  $list_records[] = array_values($record);
}

header('Content-Type: application/json');
echo json_encode([
  'draw' => $draw,
  'recordsTotal' => $total,
  'recordsFiltered' => $total,
  'data' => $list_records
]);
