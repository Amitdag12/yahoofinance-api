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
 $result=substr($result, strpos($result, '<ul class="My(0) P(0) Wow(bw) Ov(h)" data-reactid="3">'));
 $result=substr($result, 0, strpos($result, "</ul>"));
$LiArray=SeperateStringToArray($result, "<li", "</li>");
GetImage($LiArray[0]);
function SeperateStringToArray($string, $starter, $ender)
{
    $text="";
    $arr=[];
    $index=0;
    $flag=false;
    for ($i=0; $i < strlen($string); $i++) {
        $text.=$string[$i];
        if (strpos($text, $starter) !== false) {
            $flag=true;
        }
        if ($string[$i]=='>'&&$flag) {
            $text="";
            $flag=false;
        }
        if (strpos($text, $ender) !== false) {
            $arr[$index]=substr($text, 0, strpos($text, $ender));
            $index++;
        }
    }
    return $arr;
}
function GetImage($li)
{
    error_log("image position:".strpos($li, "<img"));
    $li=substr($li, strpos($li, "<img"));
    error_log("end position:".strpos($li, 0, strpos($li, ">")));
    $li=substr($li, strpos($li, 0, strpos($li, ">")));
}
