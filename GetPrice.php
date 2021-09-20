<?php
include 'index.php';
$data = json_decode(file_get_contents('php://input'), true);
error_log($_GET["stockSymbol"]);
error_log($_POST["stockSymbol"]);
//aaaaaaaa
$data = GetStockPage($data->{"stockSymbol"});
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
