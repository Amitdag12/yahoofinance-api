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
 //$result=substr($result, strpos($result, '<div id="slingstoneStream-0-Stream"'));
error_log(json_encode(html_to_obj($result)));
 function html_to_obj($html)
 {
     $dom = new DOMDocument();
     $dom->loadHTML($html);
     return element_to_obj($dom->documentElement);
 }
 function element_to_obj($element)
 {
     $obj = array( "tag" => $element->tagName );
     foreach ($element->attributes as $attribute) {
         $obj[$attribute->name] = $attribute->value;
     }
     foreach ($element->childNodes as $subElement) {
         if ($subElement->nodeType == XML_TEXT_NODE) {
             $obj["html"] = $subElement->wholeText;
         } elseif ($subElement->nodeType == XML_CDATA_SECTION_NODE) {
             $obj["html"] = $subElement->data;
         } else {
             $obj["children"][] = element_to_obj($subElement);
         }
     }
     return $obj;
 }
