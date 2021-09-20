<?php
include 'index.php';

$data = GetStockPage($_POST["stockSymbol"]);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
