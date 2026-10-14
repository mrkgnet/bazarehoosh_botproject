<?php
//require_once "../../index.php";
//require_once "user/user-function-bot.php";
//require_once "../../callback-data-bot.php";
//requier_one ("../../telegram.php");
//require_once ("../../telegram.php");
//-------------------------------------
//$telegram = new telegram();
//$telegram->db->query()
//$telegram = new telegram();
$price=intval($_GET['amount']) ;
$user_id=$_GET['user_id'];
//echo $price1;

$data = array("merchant_id" => "17b27108-a882-4628-a9e1-39749375f923",
    "amount" => $price,
    "callback_url" => "https://mrkgnet.shop/telegram_project/abzarvpnbot/pay/zp/verify.php?price=$price&user_id=$user_id",
    "description" => "پرداخت با موفقیت انجام شد",
    "metadata" => [ "email" => "info@email.com","mobile"=>"09121234567"],
);
$jsonData = json_encode($data);
$ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData)
));

$result = curl_exec($ch);
$err = curl_error($ch);
$result = json_decode($result, true, JSON_PRETTY_PRINT);
curl_close($ch);



if ($err) {
    echo "cURL Error #:" . $err;
} else {
    if (empty($result['errors'])) {
        if ($result['data']['code'] == 100) {
            header('Location: https://www.zarinpal.com/pg/StartPay/' . $result['data']["authority"]);
        }
    } else {
        echo'Error Code: ' . $result['errors']['code'];
        echo'message: ' .  $result['errors']['message'];

    }
}
?>