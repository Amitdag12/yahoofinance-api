<?php
include 'index.php';
error_log($_GET["stockSymbol"]);
error_log($_POST["stockSymbol"]);
$data = GetStockPage("AAPL");
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
