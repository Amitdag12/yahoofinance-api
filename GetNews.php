<?php
 $url='https://finance.yahoo.com';
 error_log($url);
 $curl = curl_init();
 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
 curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
 curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
 curl_setopt($curl, CURLOPT_URL, $url);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 $result = curl_exec($curl);
 //error_log($result);
 error_log(curl_error($curl));
 curl_close($curl);
 $result=substr($result, strpos($result, '<ul class="My(0) P(0) Wow(bw) Ov(h)">'));
 $result=substr($result, 0, strpos($result, "</ul>"));
 error_log(substr_count($result, '<li'));
$LiArray=SeperateStringToArray($result, "<li", "</li>");

//error_log($result);
error_log(count($LiArray));
//GetLink($LiArray[0]);
$response= [];

for ($i=0; $i <count($LiArray) ; $i++) {
    $pageData=GetActualPage(GetLink($LiArray[$i]));
    $response[$i]=['HeadLine'=>$pageData['HeadLine'],
                    'Image'=>$pageData['Image'],
                    'Paragraph'=>$pageData['Paragraph'],
                    'Link'=>GetLink($LiArray[$i])];
}
error_log(json_encode($response));
echo(str_replace("\/", "/", json_encode($response)));
//var_dump($response);
//echo("                                                                                         ".GetHeadLine($LiArray[0]));
function SeperateStringToArray($string, $starter, $ender)
{
    $text="";
    $arr=[];
    $index=0;
    while (strpos($string, $starter)!==false) {
        $text=substr($string, strpos($string, $starter)+strlen($starter));
        $text=substr($text, 0, strpos($text, $ender));

        $string=substr($string, strpos($string, $ender)+strlen($ender));
        $arr[$index]=$text;
        $index++;
    }
    // error_log(json_encode($arr));
    return $arr;
}
function GetImage($li)
{
    // error_log("image position:".strpos($li, "<img"));
    $li=substr($li, strpos($li, "<img"));
    //  error_log("end position:".strpos($li, ">"));
    $li=substr($li, 0, strpos($li, ">"));
    //  ////error_log($li);
    $li=substr($li, strpos($li, "src=")+5);
    //  ////error_log($li);
    $li=substr($li, 0, strpos($li, '"'));
    //.   ////error_log($li);
    //  error_log(str_replace("\/","/",$li));
    return str_replace("\/", "/", $li);
}
function GetHeadLine($li)
{
    $p=GetParagraph($li);
    //  ////error_log($li);
    //  error_log("a position:".strpos($li, "<a"));
    $li=str_replace("<!-- /react-text -->", "", $li);
    $li=str_replace('"', "", $li);
    $li=substr($li, strpos($li, "<a")+2);
    //  error_log("end position:".strpos($li, ">"));
    $li=substr($li, strpos($li, ">")+1);
    //  error_log("a position:".strpos($li, "<u"));
    $li=substr($li, strpos($li, "<u")+2);
    //  error_log("end position:".strpos($li, ">"));
    $li=substr($li, strpos($li, ">")+1);
    //error_log($li);
    $li=substr($li, strpos($li, ">")+1);
    //error_log($li);
    $li=substr($li, strpos($li, ">")+1);
    ////error_log($li);
    $li=substr($li, 0, strpos($li, "</div>"));
    //////error_log($li);
    //  $li=substr($li,0, strpos($li, ">"));
    $li=str_replace("<!-- /react-text -->", "", $li);
    if (strpos($li, $p) !== false) {
        $li=str_replace($p, "", $li);
    }
    //////error_log($li);
    return $li;
}
function GetParagraph($li)
{
   
    
   // error_log("end a position:".strpos($li, "</a>"));
    $li=substr($li, strpos($li, "</a>")+2);
    
    // error_log("end position:".strpos($li, "<p"));
    $li=substr($li, strpos($li, "<p")+1);
    
    // error_log("a position:".strpos($li, ">"));
    $li=substr($li, strpos($li, ">")+1);
    
    // error_log("end position:".strpos($li, "</p>"));
    $li=substr($li, 0, strpos($li, "</p>"));
    
    
    //  $li=substr($li, 0, strpos($li, "</div>"));
    //  ////error_log($li);
    return $li;
}
function GetLink($li)
{
  
 // error_log("a position:".strpos($li, "<a"));
    //   $li=substr($li, strpos($li, "<a")+2);
  
    //  error_log("a position:".strpos($li, "<a"));
    $li=substr($li, strpos($li, "href")+6);
 
    // error_log("end position:".strpos($li, '"'));
    $li=substr($li, 0, strpos($li, '"'));
    // error_log('https://finance.yahoo.com'.$li);
    return 'https://finance.yahoo.com'.$li;
}
function GetActualPage($url)
{
    // $url='https://finance.yahoo.com';
    error_log($url);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    //error_log($result);
    error_log(curl_error($curl));
    curl_close($curl);
    $headLine=substr($result, strpos($result, '<h1 data-test-locator="headline">')+strlen('<h1 data-test-locator="headline">'));
    $headLine=substr($headLine, 0, strpos($headLine, "</h1>"));
    $pargraph=substr($result, strpos($result, '<div class="caas-body">'));
    $image=substr($pargraph, strpos($pargraph, 'src=')+5);
    $image=substr($image, 0, strpos($image, '"'));
    $pargraph=substr($pargraph, strpos($pargraph, '<p>')+3);
    $pargraph=substr($pargraph, 0, strpos($pargraph, "</p>"));
    if (strlen($pargraph)<50) {
        $pargraph=substr($result, strpos($result, '<div class="caas-body">'));
        $pargraph=substr($pargraph, strpos($pargraph, '</p>')+4);
        $pargraph=substr($pargraph, strpos($pargraph, '<p>')+3);
        $pargraph=substr($pargraph, 0, strpos($pargraph, "</p>"));
    }
    
    error_log("paragraph:".$pargraph);
    error_log("headline:".$headLine);
    error_log("image:".$image);
    return ['Paragraph'=>$pargraph,
    'HeadLine'=>$headLine,
    'Image'=>$image];
}
