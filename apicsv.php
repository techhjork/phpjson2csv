<?php

require_once('json2csv.class.php');
$JSON2CSV = new JSON2CSVutil;

/*----------// TOKEN  //----------------*/
function getToken($url, $data) {     
    $curl = curl_init($url);                                                                            
    curl_setopt($curl, CURLOPT_POST, true);                                                             
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));                                    
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                                   
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));   
    $response = curl_exec($curl);                                                                       
    curl_close($curl);    
    return $response;                                                                      
}  


//  TOKEN
$token = getToken("http://amring-test-api.azurewebsites.net/token",array("grant_type"=>"password","username"=>"402641","password"=>"LveqjekPt1zw"));
$res = json_decode($token, true);
$current_token = $res['access_token'];




/*----------// 
	**GetProducts**  
	@ACCESS PRIVATE  
	@HEADER AUTHORIZATION:Bearer <TOKEN> 
	@DESC get products
//----------------*/

function getProducts($current_token) {
    $url = "http://amring-test-api.azurewebsites.net/api/Articles/GetProducts";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $headers = array(
    "Accept: application/json",
    "Authorization: Bearer $current_token",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //debug only
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $resp = curl_exec($curl);
    curl_close($curl);
    //var_dump($resp);
    
    return $resp;
}
// getProducts($current_token);
$JSON2CSV->readJSON(getProducts($current_token),"Result");
$JSON2CSV->flattenDL("JSON2.CSV");


// getProducts($current_token);



/*-------------//
:- TAKE JSON and $json_decode that and convert to xml
//----------------*/

function array2xml($array, $parentkey="", $xml = false){

   if($xml === false){
       $xml = new SimpleXMLElement('<result/>');
   }

   foreach($array as $key => $value){
       if(is_array($value)){
           array2xml($value, is_numeric((string) $key)?("n".$key):$key, $xml->addChild(is_numeric((string) $key)?$parentkey:$key));
       } else {
           $xml->addAttribute(is_numeric((string) $key)?("n".$key):$key, $value);
       }
   }

   return $xml->asXML('amring.xml');
}
 

?>