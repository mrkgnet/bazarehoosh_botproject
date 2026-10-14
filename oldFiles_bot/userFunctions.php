<?php

// require_once 'index.php';
// require_once 'jdf.php';
// require_once 'config.php';
// require_once 'telegram.php';
// require_once"learning_ssh.php";
// require_once'learning_v2ray.php';


// function Authentication_Users($chatid, $userid, $text, $first_name, $last_name, $user_name, $chat_first_name, $chat_last_name, $chat_username)
// {
//     $telegram = new telegram();
//     $telegram->db->query("UPDATE info SET step='sabte_name_avaliee' WHERE user_id=" . $userid);
//     $rows = $telegram->db->query("SELECT * FROM info WHERE user_id=" . $userid)->fetch();
//     if (($rows['username'] !== null)) {
//         $msg = "اطلاعات شما از قبل در پایگاه داده ذخیره شده ";
//         $telegram->excCurl(apiUrl . 'sendMessage', [
//             'chat_id' => $chatid,
//             'text' => $msg,
//             'inline_keyboard' => json_encode([
//                 [['text' => 'بازگشت به پنل کاربری 🔙', 'callback_data' => 'index']]
//             ])

//         ]);

//     } else {
//         //   WelcomToBot();
//         ComingToBot();

//     }


// }




// function ExitFromStart($chatid, $callback_id, $message_id)
// {
//     $telegram = new telegram();
//     $telegram->db->query("update info set startbot = 'false', go_to_bot='false'");
//     $telegram->excCurl(apiUrl . 'answerCallbackQuery', [
//         'callback_query_id' => $callback_id,
//         'text' => " از اینکه ما را انتخاب کردید متشکریم.... 😍",
//         'show_alert' => 'true'
//     ]);
//     $msg = "در صورت تمایل به شروع مجدد لطفا گزینه استارت را مجدد ارسال کنید " . "\n" . "/start";
//     $telegram->excCurl(apiUrl . 'editMessageText', [
//         'chat_id' => $chatid,
//         'message_id' => $message_id,
//         'text' => $msg,
//         'reply_markup' => json_encode([
//             'inline_keyboard' => [
//                 [['text' => 'ارتباط با ادمین👨🏻‍💻‍', 'url' => 'https://t.me/abzarvpnbot']]
//             ]
//         ])

//     ]);
// }




// function home($chat_id, $message_id)
// {
//     $telegram = new telegram();
// //    $telegram->sendMessage($chat_id,'dsdsd');
//     $msg = "<b>یکی از گزینه های زیر را انتخاب کنید </b>:" . "\n" . "<b> 1- ورود به پنل کاربری :</b>" .
//         " پس از خرید اکانت و دریافت یوزرنیم و پسورد با انتخاب این گزینه می توانید وارد پنل کاربری خودتان شوید. پنل کاربری شامل( مشاهده حجم، زمان، مشخصات اکانت، تمدید، ورود به حساب دیگر و.. ) می باشد " . "\n" . "\n" . "<b>2-مشاهده آموزش ها:</b>" . " با انتخاب این گزینه آموزش نصب و فعالسازی سرویس ها به شما نشان داده خواهد شد." . "\n" . "\n" . "<b>3-تعرفه قیمت ها:</b>" . "تعرفه قیمت های سرویس ها را میتوانید با انتخاب این گزینه مشاهده کنید" . "\n" . "\n"
//         . "===========📛📛==========" . "\n" . "\n" . "<b> 📛: در هر مرحله و به هر دلیلی ربات دچار هنگی شد مجدد گزینه خانه(🏘) در پایین را فشاردهید تا مجدد ربات راه اندازی شود و عملیات مورد نظر را انجام دهید </b>";

//     $keyboard = [

//         [['text' => '2-|مشاهده آموزش ها|🧑‍🎨', 'callback_data' => 'moshahedeh_amoozehsha'],
//             ['text' => '1-|ورود به پنل کاربری|🔑', 'callback_data' => 'go_to_pannel_user']],
//         [['text' => '4-|ارتباط با ادمین|👨🏻‍💻 ', 'url' => 'https://t.me/abzarvpn_admin1'], ['text' => '3-|تعرفه قیمت ها|💰', 'callback_data' => 'pricing']], [['text' => '6-|بازگشت 🔙', 'callback_data' => 'index'], ['text' => '5-|خانه|🏘 ', 'callback_data' => 'home']]
//     ];

//     //['text' => 'خرید اکانت جدید|✅', 'callback_data' => 'byNewAccount']
//     $telegram->editMessageText($chat_id, $message_id, $msg, $keyboard);
// }


// function homeLearning($chat_id, $message_id)
// {
//     $telegram = new telegram();
// //    $telegram->sendMessage($chat_id,'dsdsd');
//     $msg = "<b>یکی از گزینه های زیر را انتخاب کنید </b>:" . "\n" . "<b> 1- ورود به پنل کاربری :</b>" .
//         " پس از خرید اکانت و دریافت یوزرنیم و پسورد با انتخاب این گزینه می توانید وارد پنل کاربری خودتان شوید. پنل کاربری شامل( مشاهده حجم، زمان، مشخصات اکانت، تمدید، ورود به حساب دیگر و.. ) می باشد " . "\n" . "\n" . "<b>2-مشاهده آموزش ها:</b>" . " با انتخاب این گزینه آموزش نصب و فعالسازی سرویس ها به شما نشان داده خواهد شد." . "\n" . "\n" . "<b>3-تعرفه قیمت ها:</b>" . "تعرفه قیمت های سرویس ها را میتوانید با انتخاب این گزینه مشاهده کنید" . "\n" . "\n"
//         . "===========📛📛==========" . "\n" . "\n" . "<b> 📛: در هر مرحله و به هر دلیلی ربات دچار هنگی شد مجدد گزینه خانه(🏘) در پایین را فشاردهید تا مجدد ربات راه اندازی شود و عملیات مورد نظر را انجام دهید </b>";

//     $keyboard = [

//         [['text' => '2-|مشاهده آموزش ها|🧑‍🎨', 'callback_data' => 'moshahedeh_amoozehsha'],
//             ['text' => '1-|ورود به پنل کاربری|🔑', 'callback_data' => 'go_to_pannel_user']],
//         [['text' => '4-|ارتباط با ادمین|👨🏻‍💻 ', 'url' => 'https://t.me/abzarvpn_admin1'], ['text' => '3-|تعرفه قیمت ها|💰', 'callback_data' => 'pricing']], [['text' => '6-|بازگشت 🔙', 'callback_data' => 'index'], ['text' => '5-|خانه|🏘 ', 'callback_data' => 'home']]
//     ];

//     //['text' => 'خرید اکانت جدید|✅', 'callback_data' => 'byNewAccount']
//     $telegram->sendMessage($chat_id, $msg, $keyboard);
// }

// function choice_service_learning($chat_id, $message_id)
// {
//     $telegram = new telegram();
//     $msg = "<b>برای مشاهده نصب و راه اندازی، سرویس مورد نظر خودرا انتخاب کنید  </b>:" . "\n" . "\n"
//         . "===========📛📛==========" . "\n" . "\n" . "<b> 📛: در هر مرحله و به هر دلیلی ربات دچار هنگی شد مجدد گزینه خانه(🏘) در پایین را فشاردهید تا مجدد ربات راه اندازی شود و عملیات مورد نظر را انجام دهید </b>";
//     $keyboard = [

//         [['text' => 'سرویس|v2ray|💣', 'callback_data' => 'v2ray_service_learning'], ['text' => 'سرویس|ssh|🚀', 'callback_data' => 'ssh_service_learning']],
//         [['text' => 'بازگشت 🔙', 'callback_data' => 'index'], ['text' => 'خانه|🏘 🔙', 'callback_data' => 'home']]
//         //, ['text' => 'تعرفه قیمت ها|💰', 'callback_data' => 'pricing']

//     ];


//     $telegram->editMessageText($chat_id, $message_id, $msg, $keyboard);
// }

// function WelcomToBot($chat_id, $user_id)
// {
//     $telegram = new telegram();

//     $textMyPanel = "برای ورود به پنل کاربری لطفا نام کاربری اکانت خود را ار ارسال کنید" . PHP_EOL . "به عنوان مثال: ali8892" . PHP_EOL . PHP_EOL . '🆔:@abzarvpn' . PHP_EOL . '🆔:@abzarvpn' . '.';
//     $telegram->sendMessage($user_id, $textMyPanel);
// }

// function CommingBackToPannel($chat_id, $user_id, $message_id, $text_message)
// {
//     $telegram = new telegram();
//     $rowsTblInfo = $telegram->db->query("select * from info where user_id=" . $user_id)->fetch();
//     $rowsTblUsers = $telegram->db->query("select * from users")->fetchAll();
//     if (($rowsTblUsers['username'] != $text_message) and ($rowsTblInfo['step'] != 'vorud_be_pannele_karbari')) {
//         $txtNotAccout = "دستور وارد شده صحیح نمی باشد 🤷🏻🤷🏻🤷🏻🤷🏻";
//         $keyboardNotAccout = [
//             [['text' => 'ارتباط با ادمین|👨🏻‍💻 ', 'url' => 'https://t.me/abzarvpn_admin1']]
//         ];
//         $telegram->sendMessage($user_id, $txtNotAccout, $keyboardNotAccout);
//     } elseif (($rowsTblUsers['username'] == $text_message) and ($rowsTblInfo['backtomain'] == 'false')) {
//         $telegram->sendMessage($user_id, 'inja');
//         //WelcomToBot($chat_id,$user_id);
//     } elseif (($rowsTblInfo['backtomain'] == 'true') and ($rowsTblInfo['username'] == $text_message)) {

//         $msg = "📢 شما قبلاً وارد شدید برای ورود به پنل کاربری خود گزینه زیر را انتخاب کنید|⬅️ ";
//         $keyboardLogin = [
//             [['text' => 'ورود مجدد به پنل کاربری|🔐', 'callback_data' => 'login_account']],
//             [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//         ];
//         $telegram->sendMessage($user_id, $msg, $keyboardLogin);
//     }


// }

// function InsertDataUsersInToDB($chat_id, $user_id, $text_message, $message_id, $callback_id)
// {
//     $telegram = new telegram();
//     $explodTextMessage = explode(':', $text_message);
//     $username_account = strtolower(trim($explodTextMessage[0]));
//     $password_account = strtolower(trim($explodTextMessage[1]));
//     $rows4 = $telegram->db->query("select * from users where username like '$username_account' and password like '$password_account'")->fetch();

//     if (($rows4['username'] == $username_account) && ($rows4['password'] == $password_account)) {
//         $rows4 = $telegram->db->query("UPDATE info SET username ='$username_account' , password='$password_account',step='InsertDataTodb' WHERE user_id=" . $user_id);
//         $telegram->excCurl(apiUrl . 'sendMessage', [
//             'chat_id' => $chat_id,
//             'message_id' => $message_id,
//             'text' => " نام کاربری و پسورد شما با موفقیت تایید شد(تایید اولیه)| ✅",
//             'reply_markup' => json_encode([
//                 'inline_keyboard' => [
//                     [['text' => 'ارتباط با ادمین 👨🏻‍💻 ', 'url' => 'https://t.me/abzarvpn_admin1'], ['text' => 'ورود به پنل کاربری 🔐', 'callback_data' => 'login_account']], [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//                 ]
//             ])
//         ]);

//     } else {
//         $telegram->excCurl(apiUrl . 'sendMessage', [
//             'chat_id' => $chat_id,
//             'message_id' => $message_id,
//             'text' => "نام کاربری یا پسورد اشتباه است ",
//             'reply_markup' => json_encode([
//                 'inline_keyboard' => [
//                     [['text' => ' ویرایش اطلاعات| 📝 ', 'callback_data' => 'editData']]
//                 ]
//             ])
//         ]);
//     }


// }

// //تابع مربوط به بروزرسانی اطلاعات از پایگاه داده توسط کاربر
// function Refresh_Data($user_id, $chat_id, $message_id)
// {
//     $telegram = new telegram();
//     $rows1 = $telegram->db->query("select * from info where  user_id=" . $user_id)->fetch();
//     $msg = " سلام " . $rows1['first_name'] . " عزیز شما " . "\n" . " در تایخ: " . jdate("Y/m/d") . " ساعت: " . jdate("G:i:s") . "\n" . "با موفقیت وارد حساب کاربری خود شدید";
//     //$telegram->get_client_ip();
//     $telegram->db->query("update info set step='fetch_data_from_db' where user_id=" . $user_id);


//     $rows = $telegram->db->query("SELECT users.username , users.password, users.finishdate  , users.enable, users.traffic , info.first_name, info.last_name,info.user_id , info.username_telegram FROM users INNER JOIN info 
// ON users.username = info.username where user_id=" . $user_id)->fetch();

//     $db_firstName = $rows['first_name'];
//     $db_lastName = $rows['last_name'];
//     $db_username_telegram = $rows['username_telegram'];
//     $db_usernamevpn = $rows['username'];
//     $db_passwordvpn = $rows['password'];
//     $db_days_to_finish = $rows['days'];
//     $db_finishdate = $rows['finishdate'];
//     $db_enable_user = $rows1['enableAccount'];
//     $db_traffic_user = $rows['traffic'];
//     $db_mobile_user = $rows['mobile'];

//     if ($db_lastName === "") {
//         $db_lastName = "ثبت نشده است";
//     }
//     if ($db_username_telegram === "") {
//         $db_username_telegram = "ثبت نشده است";

//     }
//     if ($db_traffic_user === "") {
//         $db_traffic_user = "نامحدود";

//     } else {
//         $db_traffic_user = $db_traffic_user;
//     }
//     if ($db_enable_user == "true") {
//         $txtEnable = "فعال🟢";
//     } else {
// //        $txtEnable = "غیرفعال🔴".'<b>'."روی گزینه فعالسازی اکانت کلیک کنید تا حساب کاربری شما فعال شود ".'</b>';
//         $txtEnable = "غیرفعال🔴" . "\n" . '<b>' . "(روی گزینه فعالسازی اکانت کلیک کنید) " . '</b>' . "\n" . '<b>' . "ومجدد بروزرسانی اطلاعات را بزنید" . '</b>';

//     }

//     if ($db_enable_user === "expired") {
//         $db_enable_user = "اشتراک زمانی شما به اتمام رسیده است🟠";
//     }

//     $msg = "
// اطلاعات دریافتی شما شامل موارد زیر است: " . "\n" .
//         "🙍 نام تلگرامی شما: " . '<code>' . $db_firstName . '</code>' . "\n" . "🙍 نام خانوادگی تلگرامی شما: " . '<code>' . $db_lastName . '</code>' . "\n" . "👈 آی دی تلگرامی شما: " . '<code>' . urldecode($db_username_telegram . "@") . '</code>' . "\n" . "========================" . "\n" . '<b>' . "مشخصات اکانت SSH شما " . '</b>' . "\n" . "⏰ ترافیک اکانت شما: " . "نامحدود(منصفانه)" . "\n" . "🕹 وضعیت اکانت شما: " . $txtEnable . "\n" . "⏳ تعداد روز مانده به پایان اکانت: " . $db_days_to_finish . "\n" . "👈 نام کاربری اکانت شما: " . '<code>' . $db_usernamevpn . '</code>' . "\n" . "🔑 پسورد اکانت شما: " . '<code>' . $db_passwordvpn . '</code>' . "\n" . "\n" . "========================" . "\n" . '<b>توجه: باتوجه به بروزرسانی داده ها در بازه های مشخص ممکن بازه 1 الی 2 روز تفاوت زمانی وجود داشته باشد </b>';


// //    $msg = "
// //اطلاعات دریافتی شما شامل موارد زیر است: " . "\n" .
// //        "🙍 نام تلگرامی شما: " . '<code>' . $db_firstName . '</code>' . "\n" . "🙍 نام خانوادگی تلگرامی شما: " . '<code>' . $db_lastName . '</code>' . "\n" . "👈 آی دی تلگرامی شما: " . '<code>' . urldecode($db_username_telegram . "@") . '</code>' . "\n" . "========================" . "\n" . '<b>' . "مشخصات اکانت SSH شما " . '</b>' . "\n" . "⏰ ترافیک اکانت شما: " . "نامحدود(منصفانه)" . "\n" . "⏳ تعداد روز مانده به پایان اکانت: " . $db_days_to_finish . "\n" . "👈 نام کاربری اکانت شما: " . '<code>' . $db_usernamevpn . '</code>' . "\n" . "🔑 پسورد اکانت شما: " . '<code>' . $db_passwordvpn . '</code>' . "\n" . "\n" . "========================" . "\n" . '<b>توجه: باتوجه به بروزرسانی داده ها در بازه های مشخص ممکن بازه 1 الی 2 روز تفاوت زمانی وجود داشته باشد </b>';


//     $telegram->excCurl(apiUrl . 'editMessageText', [
//         'chat_id' => $chat_id,
//         'message_id' => $message_id,
//         'text' => $msg,
//         'parse_mode' => 'HTML',
//         'reply_markup' => json_encode([
//             'inline_keyboard' => [
//                 [['text' => 'فعالسازی اکانت|✅', 'callback_data' => "enableAccount"]],
//                 [['text' => ' ورود به حساب کاربری دیگر|📝', 'callback_data' => 'editData'], ['text' => ' فعالسازی نوتیفیکیشن|🔔', 'callback_data' => 'notification_callback']],
//                 [['text' => 'بروزرسانی اطلاعات|♻️', 'callback_data' => 'refresh_from_database'], ['text' => 'تمدید اکانت|⏰', 'callback_data' => 'byNewAccount']],
//                 [['text' => 'لیست سرورها|🛜', 'callback_data' => 'GetLastUpdateServer'], ['text' => 'مشاهده آموزش ها|🧑‍🎨', 'callback_data' => 'moshahedeh_amoozehsha']],
//                 [['text' => 'ارتباط با ادمین|👨🏻‍💻', 'url' => 'https://t.me/abzarvpn_admin1'], ['text' => 'خروج از حساب کاربری|🔙', 'callback_data' => 'ExitPannel']],
//                 [['text' => 'بازگشت 🔙', 'callback_data' => 'index']],

//             ]
//         ])
//     ]);

// }

// // تابع مربوط به فعالسازی اکانت یوزر و ارسال تایید به مدیریت
// function enableAccount($user_id, $chat_id, $message_id, $callback_id)
// {
//     $telegram = new telegram();
//     $resFetch = $telegram->db->query("SELECT * FROM info WHERE user_id=" . $user_id)->fetch();
// //    $telegram->db->query("UPDATE info SET enableAccount='true' WHERE user_id=".$user_id);

//     if ($resFetch['enableAccount'] != 'true') {

//         $txtCallback = ' حساب کاربری شما با موفقیت فعال شد' . "\n" . "\n" . "
//         روی گزینه بروزرسانی اطلاعات حساب کاربری خود کلید کنید تا تغییرات اعمال شود 
//         ";
//         $txtSendToAdmin = "حساب کاربری یوزر: " . '<b>' . $resFetch['username'] . '</b>' . " با موفقیت فعال شد ";

//         $telegram->answerCallbackQuery($callback_id, $txtCallback, 'true');
//         $telegram->sendMessage('5930684812', $txtSendToAdmin);
//         $telegram->sendMessage('449057527', $txtSendToAdmin);
//         $telegram->db->query("UPDATE info SET enableAccount='true' WHERE user_id=" . $user_id);
// //        $telegram->db->query("update info set enableAccount='true' where user_id= " . $user_id);

//     } else {
//         $txtCallbackAlert = "⚠️|شما قبلا حساب کاربری خود را فعال کردید" . "\n" . "\n" . "
//         روی گزینه بروزرسانی اطلاعات حساب کاربری خود کلید کنید تا تغییرات اعمال شود 
//         ";;
//         $telegram->answerCallbackQuery($callback_id, $txtCallbackAlert, 'true');

//     }


// //    $telegram->db->query("UPDATE info SET step")

// }
// //---------------------------
// function Display_user_account_information($user_id, $chat_id, $message_id, $callback_id)// panel user
// {
//     $telegram = new telegram();
//   //----------------------------------------

//     ///--------------------
//     $sql="SELECT * FROM tbl_user WHERE user_id=".$user_id    ;
//     $stmt= $telegram->db->prepare($sql);
//     $stmt->execute();
//     $resutl_datauser= $stmt->fetch(PDO::FETCH_ASSOC);
//     ///--------------------
//     $msgSendMessage =  '<b>'."✋🏻| سلام"." ".$resutl_datauser['first_name']." ".'عزیز به پنل کاربری خود خوش آمدید'.'</b>'."\n".'<u>'.'📋| اطلاعات پروفایل شما به صورت زیر است:'.'</u>'."\n".
//         '👤| نام پروفایل شما: '.'<code>'.$resutl_datauser['first_name'].'</code>'."\n".
//         '◀️| آیدی تلگرام شما: '.'<code>'.$resutl_datauser['username_telegram'].'</code>'."\n".
//         '🔹| یوزرآیدی شما: '.'<code>'.$resutl_datauser['user_id'].'</code>'."\n".'<b>'.
//         '💰| موجودی کیف پول شما: '.'</b>'.'<code>'.$resutl_datauser['col_wallet'].'</code>'."  "."هزارتومان"."\n".
//         '⏰| زمان ورود به پنل: '.'<code>'.$resutl_datauser['time_persion'].'</code>'."\n"

//     ;
//     $keyboardHome = [
//       [['text'=>'♻️| تمدید اشتراک']],
//         [['text' => "👨‍🏫| مشاهده آموزش ها"],['text' => "🔌| شارژ حساب کاربری"]],
//         [['text' => "🕹| ورود به حساب دیگر"],['text' => "🔄| بروزرسانی اطلاعات"]],
//         [['text' => "👨🏻‍💻| ارتباط با ادمین"],['text' => "💰| تعرفه قیمت ها"]],
//         [['text' => "🖇| اشتراک گذاری"],['text' => "💎| خرید تلگرام پرمیوم"]],
//         [['text' => "🔙| بازگشت به مرحله قبل"],['text' => "🏘| خانه"]]
//     ];
//     $telegram->sendMessage2($chat_id,$msgSendMessage , $keyboardHome);

//   //----------------------------------------

//     $rows1 = $telegram->db->query("select * from info where  user_id=" . $user_id)->fetch();
//     $msg = " سلام " . $rows1['first_name'] . " عزیز شما " . "\n" . " در تایخ : " . jdate("Y/m/d") . "  ساعت :  " . jdate("G:i:s") . "\n" . "با موفقیت وارد حساب کاربری خود  شدید";
//     //$telegram->get_client_ip();
//     $telegram->excCurl(apiUrl . 'answerCallbackQuery', [
//         'callback_query_id' => $callback_id,
//         'text' => $msg,
//         'show_alert' => true
//     ]);


//     $telegram->db->query("update info set step='fetch_data_from_db' where user_id=" . $user_id);
//     $rows = $telegram->db->query("SELECT users.username , users.password , users.expire_time_fa ,users.expire_time_en, users.enable, users.traffic , info.first_name, info.last_name, info.user_id , info.username_telegram , info.time,DATEDIFF (  users.expire_time_en ,  info.time) AS DateDiff FROM users INNER JOIN info 
// ON users.username = info.username where user_id=" . $user_id)->fetch();

//     $db_firstName = $rows['first_name'];
//     $db_lastName = $rows['last_name'];
//     $db_username_telegram = $rows['username_telegram'];
//     $db_usernamevpn = $rows['username'];
//     $db_passwordvpn = $rows['password'];
//     $expire_time = explode("-", $rows['expire_time_fa']);
//     $expire_time = $expire_time[0] . "/" . $expire_time[1] . "/" . $expire_time[2];
//     $day_expire = $rows['DateDiff'];
//     $db_finishdate = $rows['finishdate'];
//     $db_enable_user = $rows1['enableAccount'];
//     $db_traffic_user = $rows['traffic'];
//     $db_mobile_user = $rows['mobile'];

// //    if ($db_lastName === "") {
// //        $db_lastName = "ثبت نشده است";
// //    }
//     if ($db_username_telegram === "") {
//         $db_username_telegram = "ثبت نشده است";

//     }
//     if ($db_traffic_user === "") {
//         $db_traffic_user = "نامحدود";

//     } else {
//         $db_traffic_user = $db_traffic_user;
//     }
//     if ($db_enable_user == "true") {
//         $txtEnable = "فعال🟢";
//     } else {
// //        $txtEnable = "غیر فعال🔴";
//         $txtEnable = "غیرفعال🔴" . "\n" . '<b>' . "(روی گزینه فعالسازی اکانت کلیک کنید) " . '</b>' . "\n" . '<b>' . "ومجدد بروزرسانی اطلاعات را بزنید" . '</b>';

//     }
//     if ($db_enable_user === "expired") {
//         $db_enable_user = "اشتراک زمانی شما به اتمام رسیده است🟠";
//     }

//     $msg = "
// اطلاعات دریافتی شما شامل موارد زیر است: " . "\n" .
//         "🙍 نام تلگرامی شما: " . '<code>' . $db_firstName . '</code>' . "\n" . "🙍 نام خانوادگی تلگرامی شما: " . '<code>' . $db_lastName . '</code>' . "\n" . "👈 آی دی تلگرامی شما: " . '<code>' . urldecode($db_username_telegram . "@") . '</code>' . "\n" . "========================" . "\n" . '<b>' . "مشخصات اکانت SSH شما " . '</b>' . "\n" . "⏰ ترافیک اکانت شما: " . "نامحدود(منصفانه)" . "\n" . "⏳ تاریخ پایان اکانت: " . $expire_time . "\n" .
//         "⏳ تعداد روز باقی مانده: " . $day_expire . " روز " . "\n" . "👈 نام کاربری اکانت شما: " . '<code>' . $db_usernamevpn . '</code>' . "\n" . "\n" . "========================" . "\n" . '<b>توجه: باتوجه به بروزرسانی داده ها در بازه های مشخص ممکن بازه 1 الی 2 روز تفاوت زمانی وجود داشته باشد </b>';


//     $telegram->excCurl(apiUrl . 'editMessageText', [
//         'chat_id' => $chat_id,
//         'message_id' => $message_id,
//         'text' => $msg,
//         'parse_mode' => 'HTML',
//         'reply_markup' => json_encode([
//             'inline_keyboard' => [
//                 [['text' => 'فعالسازی اکانت|✅', 'callback_data' => "enableAccount"]],
//                 [['text' => ' ورود به حساب کاربری دیگر|📝', 'callback_data' => 'editData'], ['text' => ' فعالسازی نوتیفیکیشن|🔔', 'callback_data' => 'notification_callback']],
//                 [['text' => 'بروزرسانی اطلاعات|♻️', 'callback_data' => 'refresh_from_database'], ['text' => 'تمدید اکانت|⏰', 'callback_data' => 'byNewAccount']],
//                 [['text' => 'لیست سرورها|🛜', 'callback_data' => 'GetLastUpdateServer'], ['text' => '👨‍🏫| مشاهده آموزش ها', 'callback_data' => 'moshahedeh_amoozehsha']],
//                 [['text' => 'ارتباط با ادمین|👨🏻‍💻', 'url' => 'https://t.me/abzarvpn_admin1'], ['text' => 'خروج از حساب کاربری|🔙', 'callback_data' => 'ExitPannel']],
//                 [['text' => 'بازگشت 🔙', 'callback_data' => 'index']],

//             ]
//         ])
//     ]);

// }

// function ExitPannel($chat_id, $message_id, $callback_id)
// {
//     $telegram = new telegram();
//     $msgAlert = "اطلاعات شما به صورت کامل از پایگاه داده حذف شد برای ورود مجدد به بات دکمه استارت را بزنید ";
//     $txtAlert = "اطلاعات شما به صورت کامل از پایگاه داده حذف شد برای ورود مجدد به بات دکمه استارت را بزنید ";
//     $telegram->answerCallbackQuery($callback_id, $msgAlert, 'true');


//     $telegram->editMessageText($chat_id, $message_id, $txtAlert);
// }

// function ComeBackToBot($chat_id, $user_id, $text_message, $first_name, $last_name, $user_name, $message_id)
// {
//     $telegram = new telegram();
//     $msg = "شما با موفقیت از حساب کاربری خود خارج شدید برای ورود مجدد به بات لطفا روی گزینه استارت زیر  " . "\n" . "\n" . "/start" . "\n" . "کلیک کنید";
//     $telegram->excCurl(apiUrl . 'editMessageText', [
//         'chat_id' => $chat_id,
//         'message_id' => $message_id,
//         'text' => $msg,
//     ]);
// }

// function EnableNotif($chat_id, $message_id)
// {
//     $telegram = new telegram();
//     $msg = 'در صورت تمایل به ارسال نوتیفیکیشن قبل از اتمام اکانتتان لطفا روی گزینه فعال سازی نوتیفیکیشن کلیک کنید.';
//     $telegram->excCurl(apiUrl . 'editMessageText', [
//         'chat_id' => $chat_id,
//         'message_id' => $message_id,
//         'text' => $msg,
//         'reply_markup' => json_encode([
//             'inline_keyboard' => [
//                 [['text' => 'غیر فعالسازی نوتیف|❌', 'callback_data' => 'DisableAlert'], ['text' => 'فعالسازی نوتیف|✅ ', 'callback_data' => 'EnableAlert']],
//                 [['text' => 'بازگشت به پنل کاربری 🔙', 'callback_data' => 'index']]
//             ]
//         ])
//     ]);
// }

// function ConfirmEnableAlert($chat_id, $message_id, $callback_id)
// {
//     $telegram = new telegram();

//     // global $api_url, $API_TOKEN, $callback_id, $chat_id, $first_name, $last_name, $username, $text_message, $user_id, $db, $message_id;
//     $telegram->excCurl(apiUrl . 'answerCallbackQuery', [
//         'callback_query_id' => $callback_id,
//         'text' => "فعالسازی یادآوری زمان پایان برای شما با موفقیت فعال شد 🔔",
//         'reply_markup' => json_encode([
//             'inline_keyboard' => [
//                 [['text' => 'بازگشت به پنل کاربری 🔙', 'callback_data' => 'index']],

//             ]
//         ])
//     ]);


//     $telegram->excCurl(apiUrl . 'editMessageText', [
//         'chat_id' => $chat_id,
//         'message_id' => $message_id,
//         'text' => 'فعالسازی یادآوری زمان پایان برای شما با موفقیت فعال شد 🔔',
//         'reply_markup' => json_encode([
//             'inline_keyboard' => [
//                 [['text' => 'بازگشت به پنل کاربری 🔙', 'callback_data' => 'index']],

//             ]
//         ])
//     ]);


// }

// function ConfirmDisableAlert($chat_id, $message_id, $callback_id)
// {
//     $telegram = new telegram();
//     $telegram->excCurl(apiUrl . 'answerCallbackQuery', [
//         'callback_query_id' => $callback_id,
//         'text' => "فعالسازی یادآوری زمان پایان برای شما غیر فعال شد 🔕",
//         'reply_markup' => json_encode([
//             'inline_keyboard' => [
//                 [['text' => 'بازگشت به پنل کاربری 🔙', 'callback_data' => 'index']],

//             ]
//         ])
//     ]);


//     $telegram->excCurl(apiUrl . 'editMessageText', [
//         'chat_id' => $chat_id,
//         'message_id' => $message_id,
//         'text' => 'فعالسازی یادآوری زمان پایان برای شماغیر فعال شد 🔕',
//         'reply_markup' => json_encode([
//             'inline_keyboard' => [
//                 [['text' => 'بازگشت به پنل کاربری 🔙', 'callback_data' => 'index']],

//             ]
//         ])
//     ]);
// }

// function Invalid_Send_Msg_Users($chat_id, $user_id, $text_message, $first_name, $last_name, $user_name, $message_id)
// {
//     $telegram = new telegram();
//     $msg = "🚫|خطای اطلاعات ورودی";
//     $telegram->excCurl(apiUrl . 'sendMessage', [
//         'chat_id' => $chat_id,
//         'text' => $msg,
//         'message_id=' => $message_id,
//         'parse_mode' => json_encode([
//             'inline_keyboard' => [
//                 [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//             ]
//         ])
//     ]);
// }

// function Error_Entering_User_Information($chat_id, $user_id, $text_message, $first_name, $last_name, $user_name, $message_id)
// {
//     $telegram = new telegram();
//     $msg = "<b> لطفاً مطابق با فرمت زیر نام کاربری و پسورد خودراارسال کنید</b>:
// <pre>
// <code>username:password</code>
// For Example=>  ali:1234  ✅
// </pre>
//     ⚠️ حتما از جدا کنند <b> : </b> برای جدا کردن نام کاربری و پسورد استفاده کنید." . "\n" . "<b>حتماً نام کاربری و پسورد با حروف کوچک نوشته شود </b>";

//     $markup = array('inline_keyboard' => array(array(array('text' => 'بازگشت 🔙', 'callback_data' => 'index'))));
// //    file_get_contents($api_url . 'editMessageText?' . 'chat_id=' . $chat_id . '&message_id=' . $message_id . '&text=' . $msg . '&reply_markup=' . json_encode($markup) . '&parse_mode=' . 'HTMl');


//     $telegram->excCurl(apiUrl . 'editMessageText', [
//         'chat_id' => $chat_id,
//         'message_id' => $message_id,
//         'text' => $msg,
//         'parse_mode' => "HTML",
//         'reply_markup' => json_encode([
//             'inline_keyboard' => [
//                 [['text' => 'بازگشت 🔙', 'callback_data' => 'index']],

//             ]
//         ])
//     ]);

// }


?>