<?php
include 'index.php';
$Inputdata = json_decode(file_get_contents('php://input'), true);
//aaaaaaaa
$returnData=[];

$stockSymbols =$Inputdata["stockSymbols"];
error_log(json_encode($stockSymbols));
error_log(json_encode($Inputdata));
for ($i=0; $i < count($stockSymbols); $i++) {
    $returnData[]=GetStockPrice($stockSymbols[$i]);
}

//error_log(var_dump($Inputdata));
header('Content-Type: application/json; charset=utf-8');
echo json_encode($returnData);
