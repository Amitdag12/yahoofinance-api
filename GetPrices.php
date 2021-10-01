<?php
include 'index.php';
$Inputdata = json_decode(file_get_contents('php://input'), true);
//aaaaaaaa
$returnData=[];

$stockSymbols = json_encode($Inputdata["stockSymbols"]);
foreach ($stockSymbols as &$stockSymbol) {
    $returnData[]=GetStockPrice($stockSymbol);
}
//error_log(var_dump($Inputdata));
header('Content-Type: application/json; charset=utf-8');
echo json_encode($returnData);
