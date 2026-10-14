<?php

include("../../jdf.php");

//
$db = new PDO('mysql:host=localhost;dbname=' . 'mrkgviph_sample_1', 'mrkgviph_sample_1', '*jSekc~$NMhM', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "UTF8"'));
//


$price = ($_GET['price'])/10;
$user_id = $_GET['user_id'];
$Authority = $_GET['Authority'];
$data = array("merchant_id" => "17b27108-a882-4628-a9e1-39749375f923", "authority" => $Authority, "amount" => $_GET['amount']);
$jsonData = json_encode($data);
$ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData)
));

$result = curl_exec($ch);
curl_close($ch);
$result = json_decode($result, true);

$err = '';
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    if ($result['data']['code'] == 100) {
        echo 'Transation success. RefID:' . $result['data']['ref_id'];
    } else {
//        $telegram = new telegram();
//        $sql = "UPDATE tbl_user SET col_wallet='$price' WHERE user_id=".$user_id;
//        $stmt = $telegram->db->prepare($sql);
//        $stmt->execute();
//        //-----------------------------
//        $msgVerify="حساب شما با موفقیت شارژ شد ";
//        $telegram->sendMessage($user_id , $msgVerify);


        $sql = "UPDATE tbl_user SET col_wallet='$price' WHERE user_id=" . $user_id;
        $stmt = $db->prepare($sql);
        $stmt->execute();

        //-------------------------------


        function sendMessage($chat_id, $text, $keyboard = null)
        {
            $fileds = [
                'chat_id' => $chat_id,
                'text' => $text,
                'parse_mode'=>"HTML"
            ];
            if ($keyboard != null) {
                $fileds['reply_markup'] = makeInlineButton($keyboard);
            }
            return excCurl(apiUrl . 'sendMessage', $fileds);
        }

        function makeInlineButton($keyboard)
        {
            $keyboard = ['inline_keyboard' => $keyboard];
            return json_encode($keyboard);
        }
        function excCurl($url, $fields = [])
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $content = curl_exec($ch);
            curl_close($ch);
            return json_decode($content);
        }

        sendMessage($user_id,'پرداخت شما موفقیت آمیز بود.');
        //-------------------------------
        header("Location: https://mrkgnet.shop/telegram_project/abzarvpnbot/redirect/redirect.php?price=$price&user_id=$user_id");
//        echo "پرداخت موفق " . " " . "$price" . " " . ":" . " " . "$user_id" . " " . jdate("Y/n/j-H:i:s ");


    }
}
require_once "../../telegram.php";
$telegram = new telegram();
$telegram->sendMessage($user_id, 'حساب شما شارژ شد ');

?>






