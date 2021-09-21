<?php
include 'index.php';
$Inputdata = json_decode(file_get_contents('php://input'), true);
//aaaaaaaa
$data = GetStockChart($Inputdata["stockSymbol"], $Inputdata["timePeriod"], $Inputdata["interval"]);
$canvasWidth=$Inputdata["canvasWidth"];
$canvasHeight=$Inputdata["canvasHeight"];
$timeStamps=$data["timeStamps"];
$prices=$data["prices"];
$minPrice=min($prices);
$maxPrice=max($prices);
$returnData=[];
$datapointCount=$canvasWidth/100;
$datapointSize=count($prices)/$datapointCount;
$biggestY=$canvasHeight*0.90;
$smallestY=$canvasHeight*0.05;
$i=0;
$timeStampsSum=0;
$pricesArray= [];;
// return data format ["TimePoint" => [["startingX","startingY","FinishX","FinishY","color"],.....]
while ($i<count($prices)) {
    if ($i%$datapointSize==0) {
        $date = date_create();
        date_timestamp_set($date, $timeStampsSum/$datapointSize);
        $time =date_format($date, "H:i:s");
        $returnData[]=BuildReturnData($pricesArray);
    }
}

function BuildReturnData()
{
}
