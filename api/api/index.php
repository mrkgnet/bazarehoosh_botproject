<?php
session_start();

$_SESSION['log'] = 'log';
//----------------

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://net.irnet.blog:8443/abzvp/login');
curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, "username=mrkgnet&password=56005600");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIESESSION, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie-name');  //could be empty, but cause problems on some hosts
curl_setopt($ch, CURLOPT_COOKIEFILE, '/var/www/ip4.x/file/tmp');  //could be empty, but cause problems on some hosts
$answer = curl_exec($ch);
if (curl_error($ch)) {
    echo curl_error($ch);
}

//another request preserving the session

curl_setopt($ch, CURLOPT_URL, 'https://net.irnet.blog:8443/abzvp/panel/api/inbounds/getClientTraffics/pezmankh');
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_POSTFIELDS, "");
$answer = curl_exec($ch);
if (curl_error($ch)) {
    echo curl_error($ch);
}
echo '<br>';
$convertString = json_decode($answer, true);
echo '<br>';
print_r($convertString);
echo '<br>';
echo '-------------------------';
echo '<br>';
var_dump($convertString);
echo '<br>';
echo '--------------------------';
echo '<br>';
echo $convertString['obj']['expiryTime'];
echo '<br>';
//print_r(json_decode($answer, true));













//------------------------
//$curl = curl_init();
//
//curl_setopt_array($curl, array(
//    CURLOPT_URL => 'https://net.irnet.blog:8443/abzvp/login',
//    CURLOPT_RETURNTRANSFER => true,
//    CURLOPT_ENCODING => '',
//    CURLOPT_MAXREDIRS => 10,
//    CURLOPT_TIMEOUT => 0,
//    CURLOPT_FOLLOWLOCATION => true,
//    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//    CURLOPT_CUSTOMREQUEST => 'POST',
//    CURLOPT_POSTFIELDS => 'username=mrkgnet&password=56005600',
//    CURLOPT_HTTPHEADER => array(
//        'Content-Type: application/x-www-form-urlencoded'
//    ),
//));
//
//$response = curl_exec($curl);
////
//
////echo $response;
//
//
//$curl2 = curl_init();
//
//curl_setopt_array($curl2, array(
//    CURLOPT_URL => 'https://net.irnet.blog:8443/abzvp/panel/inbound/list',
//    CURLOPT_RETURNTRANSFER => true,
//    CURLOPT_ENCODING => '',
//    CURLOPT_MAXREDIRS => 10,
//    CURLOPT_TIMEOUT => 0,
//    CURLOPT_FOLLOWLOCATION => true,
//    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//    CURLOPT_CUSTOMREQUEST => 'GET',
//    CURLOPT_HTTPHEADER => array(
//        'Accept: application/json'
//    ),
//));
//
//$response = curl_exec($curl2);
//
//curl_close($curl2);
//echo $response;


?>