<?php
//require_once "telegram.php";
//require_once "config.php";
//require_once "userFunctions.php";
////require_once "addminFunctions.php";
//require_once "jdf.php";
//require_once "index.php";

function Eersale_Payame_Etmame_Time($user_id)
{
    $telegram = new telegram();
    date_default_timezone_set('asia/tehran');
    $txtData = date("H:i:s");
    $txtExplode = explode(':', $txtData);




    $rows = $telegram->db->query("SELECT users.username, info.user_id ,info.username_telegram , info.first_name , info.time,DATEDIFF (  users.expire_time_en ,  info.time) AS DateDiff FROM users INNER JOIN info 
ON users.username = info.username where user_id='$user_id'")->fetch()['DateDiff'];



    $resDay = $telegram->db->query("select * from info where user_id='$user_id'")->fetch();
    $resDayUser=$resDay['day_expire'];
   // $telegram->sendMessage('5930684812', $resDayUser);


    if (($txtExplode[0] == "15") && ($txtExplode[1] == "46")) {

        $telegram->sendMessage('5930684812', "ادمین عزیز سلام ربات در وضعیت فعال و بدون مشکل در حال فعالیت می باشد " . PHP_EOL . "ساعت : " . $txtData . " ثانیه ");









        $rowControlAlert = $telegram->db->query("select * from users")->fetchal();
        if ($rowControlAlert['flagControlAlert'] == '1') {
//                  foreach ($rows as $row) {
//
//                $telegram = new telegram();
//                if ($row['DateDiff'] == '1') {
//                    $txt_first_name = $row['first_name'];
//                    $txt_username_discount = $row['user_name'];
//                    $txt_msg_endtime_users =
//                        "  کاربر<code> $txt_first_name </code>عزیز تنها [1] روز به پایان اکانت شما باقی مانده است   ";
//                    $keyboard = [
//                        [['text' => 'تمدید حساب کاربری| تایید ✅', 'callback_data' => 'byNewAccount']], [['text' => 'خانه 🏘', 'callback_data' => 'backtohome']]
//                    ];
//                    $telegram->sendMessage($row['chat_id'], $txt_msg_endtime_users, $keyboard);
//                }

//                elseif ($row['days'] == 1) {
//                    $txt_first_name = $row['first_name'];
//                    $txt_msg_endtime_users = "  کاربر<code> $txt_first_name </code>عزیز تنها [1] روز به پایان اکانت شما باقی مانده است   ";
//                    $keyboard = [
//                        [['text' => 'تمدید حساب کاربری| تایید ✅', 'callback_data' => 'byNewAccount']], [['text' => 'خانه 🏘', 'callback_data' => 'backtohome']]
//                    ];
//                    $telegram->sendMessage($row['chat_id'], $txt_msg_endtime_users, $keyboard);
//                }
            }
//            $telegram->db->query("update users set days = days-1");

        //    $telegram->db->query("update users set flagControlAlert = '0'");

    }

    else {

       // $telegram->db->query("update users set flagControlAlert = '1'");
    }
}

?>
