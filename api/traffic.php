<?php
//    require("./config.php");
require("../telegram.php");
require("../config.php");
require("../jdf.php");

$telegram = new telegram();
$sql = 'SELECT * FROM tbl_traffic';
$stmt = $telegram->db->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();

$SQL_REQUEST_USER = 'UPDATE tbl_traffic SET number_request = 0';
$STMT_REQUEST_USER = $telegram->db->prepare($SQL_REQUEST_USER);
$STMT_REQUEST_USER->execute();



foreach ($result as $row) {
    $remaining_traffic = $row['remaining_traffic'];
    $user_id = $row['user_id'];
    $account_username = $row['account_username'];
    $sql = "SELECT * FROM tbl_traffic WHERE user_id = '$user_id'";
    $stmt = $telegram->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result['send_message']==0) {
        display_traffic_api($user_id, $account_username);
    }

}
echo 'hello world';
//
function display_traffic_api($user_id, $account_username)
{
    $telegram = new telegram();
//    $text_message = strtolower($text_message);
    $time_stamp = time();
    $time_persion = jdate('Y/n/j ساعت H:i:s');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://net.abznet.top:8443/XLOo5XjGeMM1n18/login');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "username=mrkgnetnet&password=65006500");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie-name');  //could be empty, but cause problems on some hosts
    curl_setopt($ch, CURLOPT_COOKIEFILE, '/var/www/ip4.x/file/tmp');  //could be empty, but cause problems on some hosts
    $answer = curl_exec($ch);
    if (curl_error($ch)) {
        echo curl_error($ch);
    }
    //another request preserving the session
    curl_setopt($ch, CURLOPT_URL, 'https://net.abznet.top:8443/XLOo5XjGeMM1n18/panel/api/inbounds/getClientTraffics/' . $account_username);
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_POSTFIELDS, "");
    $answer2 = curl_exec($ch);
    if (curl_error($ch)) {
        echo curl_error($ch);
    }
    echo '<br>';


    $convertString = json_decode($answer2);
//                    $telegram->sendMessage($user_id, $convertString);
//                    $telegram->sendMessage($user_id, $answer2);
    if (array_key_exists('obj', $convertString)) {
        //$telegram->sendMessage($user_id, 'yes');
        $username_account = $convertString->obj->email;
        $all_traffic_account = $convertString->obj->total;
        $all_traffic_account = ($all_traffic_account / 1073735424.880463);
        $all_traffic_account = round($all_traffic_account, 2);

        $upload_account = $convertString->obj->up;
        $upload_account = ($upload_account / 1073735424.880463);
        $upload_account = round($upload_account, 2);
        $download_account = $convertString->obj->down;
        $download_account = ($download_account / 1073735424.880463);
        $download_account = round($download_account, 2);
        $end_time = $convertString->obj->expiryTime;
        //  $expire_time_account1= date('Y-m-d H:i:s',  $expire_time_account);
        $end_time = $end_time / 1000;
        $expire_time_account = jdate('Y/n/j ساعت H:i:s ', $end_time);
        $sum_traffic_user = $download_account + $upload_account;
        $baghi_mande_traffic = $all_traffic_account - $sum_traffic_user;
        if ($baghi_mande_traffic <= 3) {
            $sql = "SELECT * FROM tbl_traffic WHERE user_id = '$user_id'";
            $stmt = $telegram->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $keyboard = [
                    [
                        ['text' => '👨🏻‍💻| ارتباط با ادمین', 'url' => 'https://t.me/abzarvpn_admin1']
                    ]
                ];
                $txt = "کاربر گرامی شما بیش از 95 درصد از ترافیک خود را مصرف کردید " . "\n" . '---------' . "\n" . 'بروزرسانی شده در تاریخ: ' . $time_persion . "\n" . ".";
                $telegram->sendMessage($user_id, $txt, $keyboard);
                $sql = "UPDATE tbl_traffic SET send_message = 1 WHERE user_id = '$user_id'";
                $stmt = $telegram->db->prepare($sql);
                $stmt->execute();



        }


    }


}


?>