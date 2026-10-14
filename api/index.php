<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://net.irnet.blog:8443/abzvp/login');
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
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
//curl_setopt($ch, CURLOPT_URL, 'https://net.irnet.blog:8443/abzvp/panel/api/inbounds/get/' . 'c14a1e6f-84df-4dea-b9f1-f3fddac57c77
//');

curl_setopt($ch, CURLOPT_URL, 'https://net.irnet.blog:8443/abzvp/panel/api/inbounds/createbackup');
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_POSTFIELDS, "");
$answer2 = curl_exec($ch);
if (curl_error($ch)) {
    echo curl_error($ch);
}
echo '<br>';
echo $answer2;

echo '<br>';
echo 'alidiie';

//id: 7
//settings: {"clients": [{
//    "id": "e7ebfe72-90d2-4832-aef0-8c7c3c00c23c",
//  "security": "auto",
//  "email": "0e6qt1b7",
//  "limitIp": 0,
//  "totalGB": 1073741824,
//  "expiryTime": -86400000,
//  "enable": true,
//  "tgId": "",
//  "subId": "l30t98xlctqvtrwx",
//  "reset": 0
//}]}

?>