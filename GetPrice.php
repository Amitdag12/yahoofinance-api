<?php
include 'index.php';
$Inputdata = json_decode(file_get_contents('php://input'), true);
//aaaaaaaa
$data = GetStockPage($Inputdata["stockSymbol"]);
//error_log(var_dump($Inputdata));
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
