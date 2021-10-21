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
 $result=substr($result, strpos($result, 'id="slingstoneStream-0-Stream"'));
 $result=substr($result, FindNextCloseTag($result));
 ConvertHtmlTagToObject(substr($result, strpos($result, "<"), FindNextCloseTag($result)-strpos($result, "<")));
 function FindNextCloseTag($html)
 {
     return strpos($html, ">");
 }
 function ConvertHtmlTagToObject($tag, $content)
 {
     $htmlTag=new HtmlTag();
     $text="";
     $SpaceCount=0;
     $proprtyName;
     for ($i=0; $i <strlen($tag) ; $i++) {
         $text+=$tag[$i];
         if ($tag[$i]==' ') {
             if ($SpaceCount==0) {
                 $htmlTag->tagName=$text;
                 $text="";
             }
             $SpaceCount++;
         }
         if ($tag[$i]=='=') {
             $proprtyName=$text;
             $text="";
             $i++;
         }
         if ($tag[$i]=='"') {
             $htmlTag->proprties[$proprtyName]=$text;
             $text="";
         }
     }
     error_log(var_dump($htmlTag));
 }
 class HtmlTag
 {
     public $tagName;
     public $proprties;
     public $content;
     public function __construct()
     {
         $this->proprties = [];
         $this->content = [];
     }
 }
