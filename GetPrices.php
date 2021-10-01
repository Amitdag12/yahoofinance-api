<?php
include 'index.php';
$Inputdata = json_decode(file_get_contents('php://input'), true);
//aaaaaaaa
$returnData=[];

$stockSymbols =$Inputdata["stockSymbols"];
error_log($stockSymbols);
error_log($Inputdata);
for ($i=0; $i < count($stockSymbols); $i++) {
    $returnData[]=GetStockPrice($stockSymbol[$i]);
}

//error_log(var_dump($Inputdata));
header('Content-Type: application/json; charset=utf-8');
echo json_encode($returnData);
