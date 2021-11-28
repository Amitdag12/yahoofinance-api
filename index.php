<?php
function GetStockQuote($stockSymbol)
{
    $url = "http://query1.finance.yahoo.com/v10/finance/quoteSummary/".$stockSymbol."?modules=price,defaultKeyStatistics";
    //  $url = "http://query1.finance.yahoo.com/v10/finance/quoteSummary/AAPL?modules=price,defaultKeyStatistics";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    $result = curl_exec($curl);
    error_log(curl_error($curl));
    error_log($result);
    curl_close($curl);
    $result=json_decode($result);
    return $result;
    
    //$price=$resposne->{"quoteSummary"}->{"result"}[0]->{"price"}->{"regularMarketPrice"}->{"raw"};
}
  function GetStockHistoryChart($stockSymbol, $interval, $timePeriod)
  {
      $dayAmount;
      if (strpos($timePeriod, "mo")) {
          $dayAmount=30*intval(str_replace("mo", "", $timePeriod));
      } elseif (strpos($timePeriod, "y")) {
          $dayAmount=365*intval(str_replace("y", "", $timePeriod));
      } else {
          $dayAmount=intval(str_replace("d", "", $timePeriod));
      }
     
    
      //Possible inputs for &interval=: 1m, 5m, 15m, 30m, 90m, 1h, 1d, 5d, 1wk, 1mo, 3mo
      //$url='https://query1.finance.yahoo.com/v8/finance/chart/'.$stockSymbol.'?symbol='.$stockSymbol.'&period1='.(time()-($dayAmount*24*60*60)).'&period2=9999999999&interval='.$interval;
    $url='https://query1.finance.yahoo.com/v8/finance/chart/'.$stockSymbol.'?symbol='.$stockSymbol.'&range='.$timePeriod.'&interval='.$interval;
      error_log($url);
    //  $url="https://query1.finance.yahoo.com/v8/finance/chart/AAPL?symbol=AAPL&period1=1600362461&period2=9999999999&interval=1d";
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      $result = curl_exec($curl);
      error_log($result);
      error_log(curl_error($curl));
      curl_close($curl);
      $result=json_decode($result);
      return $result;
  }
function GetStockPrice($symbol)
{
    //  $resposne = GetStockHistoryPage($symbol, "1d", "1y");
    $resposne = GetStockQuote($symbol);
    return $resposne->{"quoteSummary"}->{"result"}[0]->{"price"}->{"regularMarketPrice"}->{"raw"};
    // echo($price);
}
function GetStockChart($symbol, $timePeriod, $interval)
{
    $resposne = GetStockHistoryChart($symbol, $interval, $timePeriod);
    // error_log($resposne);
    $times=$resposne->{"chart"}->{"result"}[0]->{"timestamp"};
    /*
    foreach ($times as &$time) {
        $date = date_create();
        date_timestamp_set($date, $time);
        $time =date_format($date, "H:i:s");
    }
        */
    
    $values=$resposne->{"chart"}->{"result"}[0]->{"indicators"}->{"quote"}[0]->{"open"};
    return ["timeStamps"=>$times,
    "prices"=>$values];
}
//GetStockPrice("AAPL");
//echo("hi");
//curl query1.finance.yahoo.com/v10/finance/quoteSummary/AAPL?modules=price [regularMarketDayHigh]
