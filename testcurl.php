<?php
$header_data = array(
    'Accept: application/json',
//    'Content-Type: application/x-www-form-urlencoded',
    'Content-Type: application/json',
//    'Authorization: Basic '. base64_encode("your_app_key:your_app_secret")
    'Authorization: Basic 336dd5f558c1486b922ffae624288fb7'
);

$url = "https://api.zen.com/v2/terminals";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/6.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.7) Gecko/20050414 Firefox/1.0.3");
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$result = curl_exec ($ch);
curl_close ($ch);
print_R($result);
?>

